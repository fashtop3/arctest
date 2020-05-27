<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use  App\User;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get the authenticated User.
     *
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }

    /**
     * Get all User.
     *
     * @return Response
     */
    public function allUsers()
    {
        return response()->json(['users' => User::all()], 200);
    }

    /**
     * Get one user.
     *
     * @return Response
     */
    public function singleUser($id)
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'user not found!'], 404);
        }

    }

    /**
     * delete user
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {

        //Return error 404 response if Services was not found
        if (!User::find($id)) return $this->errorResponse('User not found!', 404);

        //Return 410(done) success response if delete was successful
        if (User::find($id)->delete()) {
            return $this->customResponse('User deleted successfully!', 204);
        }

        //Return error 400 response if delete was not successful
        return $this->errorResponse('Failed to delete User!', 400);
    }

}
