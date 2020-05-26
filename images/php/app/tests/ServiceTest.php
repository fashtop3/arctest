<?php


use App\User;

class ServiceTest extends TestCase
{
    /**
     * create a dummy login user
     */
    public function loginWithFakeUser()
    {

//        $user = factory('App\User')->create();

        $user = new User([
            'id' => 1,
            'name' => 'yish',
            "email" => 'example@gmail.com'
        ]);

        $this->actingAs($user);
    }


    /**
     * /services [GET]
     */
    public function testShouldReturnAllservices()
    {
        $this->loginWithFakeUser();
        $this->get("/api/services", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'service_name',
                    'price',
                    'plan',
                    'service_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ],
            'meta' => [
                '*' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages',
                    'links',
                ]
            ]
        ]);

    }

    /**
     * /services/id [GET]
     */
    public function testShouldReturnProduct()
    {
        $this->loginWithFakeUser();

        $this->get("/api/services/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'service_name',
                    'price',
                    'plan',
                    'service_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ]
        );

    }

    /**
     * /services [POST]
     */
    public function testShouldCreateProduct()
    {
        $this->loginWithFakeUser();

        $parameters = [
            'service_name' => 'Business Loan Subscription',
            'price' => 3000.22,
            'plan' => "Plan_code",
            'service_description' => 'Loan plan subscription',
        ];

        $this->post("/api/services", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'service_name',
                    'price',
                    'plan',
                    'service_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ]
        );

    }

    /**
     * /services/id [PUT]
     */
    public function testShouldUpdateProduct()
    {

        $this->loginWithFakeUser();

        $parameters = [
            'service_name' => 'Personal Loan Subscription',
            'price' => 4000,
            'plan' => 'Plan_code_update',
            'service_description' => 'Get a loan free',
        ];

        $this->put("/api/services/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'service_name',
                    'price',
                    'plan',
                    'service_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ]
        );
    }

    /**
     * /services/id [DELETE]
     */
    public function testShouldDeleteProduct()
    {

        $this->loginWithFakeUser();

        $parameters = [
            'service_name' => 'Personal advance Loan',
            'price' => 200,
            'plan' => "Plan_code-psersonal",
            'service_description' => 'Loan plan subscription',
        ];

        $content = json_decode($this->post("/api/services", $parameters, [])->seeStatusCode(200)->response->getContent());

        $this->delete("/api/services/" . $content->data->id, [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
            'status',
            'message'
        ]);
    }

}
