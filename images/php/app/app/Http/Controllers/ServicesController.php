<?php

namespace App\Http\Controllers;

use App\Service;

use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Transformers\ServiceTransformer;



class ServicesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $fractal;

    public function __construct()
    {
//        $this->middleware('auth');
        $this->fractal = new Manager();
    }

    /**
     * GET /Servicess
     *
     * @return array
     */
    public function index()
    {
        $paginator = Service::paginate();
        $Servicess = $paginator->getCollection();
        $resource = new Collection($Servicess, new ServiceTransformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return $this->fractal->createData($resource)->toArray();
    }

    public function show($id)
    {
        $Services = Service::find($id);
        $resource = new Item($Services, new ServiceTransformer);
        return $this->fractal->createData($resource)->toArray();
    }

    public function store(Request $request)
    {

        //validate request parameters
        $this->validate($request, [
            'service_name' => 'bail|required|max:255',
            'price' => 'required|numeric',
            'plan' => 'bail|required|max:255',
            'service_description' => 'bail|required',
        ]);

        $Services = Service::create($request->all());
        $resource = new Item($Services, new ServiceTransformer);
        return $this->fractal->createData($resource)->toArray();
    }

    public function update($id, Request $request)
    {

        //validate request parameters
        $this->validate($request, [
            'service_name' => 'max:255',
        ]);

        //Return error 404 response if Services was not found
        if (!Service::find($id)) return $this->errorResponse('Services not found!', 404);

        $Services = Service::find($id)->update($request->all());

        if ($Services) {
            //return updated data
            $resource = new Item(Service::find($id), new ServiceTransformer);
            return $this->fractal->createData($resource)->toArray();
        }

        //Return error 400 response if updated was not successful
        return $this->errorResponse('Failed to update Services!', 400);
    }

    public function destroy($id)
    {

        //Return error 404 response if Services was not found
        if (!Service::find($id)) return $this->errorResponse('Services not found!', 404);

        //Return 410(done) success response if delete was successful
        if (Service::find($id)->delete()) {
            return $this->customResponse('Services deleted successfully!', 410);
        }

        //Return error 400 response if delete was not successful
        return $this->errorResponse('Failed to delete Services!', 400);
    }

    public function customResponse($message = 'success', $status = 200)
    {
        return response(['status' => $status, 'message' => $message], $status);
    }
}
