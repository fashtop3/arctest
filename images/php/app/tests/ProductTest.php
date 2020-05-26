<?php


class ProductTest extends TestCase
{
    /**
     * /products [GET]
     */
    public function testShouldReturnAllProducts()
    {

        $this->get("/api/products", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'product_name',
                    'product_description',
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
     * /products/id [GET]
     */
    public function testShouldReturnProduct()
    {
        $this->get("/api/products/2", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'product_name',
                    'product_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ]
        );

    }

    /**
     * /products [POST]
     */
    public function testShouldCreateProduct()
    {

        $parameters = [
            'product_name' => 'Business Loan Subscription',
            'price' => 3000.22,
            'product_description' => 'NOTE 4 5.7-Inch IPS LCD (3GB, 32GB ROM) Android 7.0 ',
        ];

        $this->post("/api/products", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'product_name',
                    'price',
                    'product_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ]
        );

    }

    /**
     * /products/id [PUT]
     */
    public function testShouldUpdateProduct()
    {

        $parameters = [
            'product_name' => 'Personal Loan Subscription',
            'product_description' => 'Get a loan free',
        ];

        $this->put("/api/products/4", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'product_name',
                    'price',
                    'product_description',
                    'created_at',
                    'updated_at',
                    'links'
                ]
            ]
        );
    }

    /**
     * /products/id [DELETE]
     */
    public function testShouldDeleteProduct()
    {

//        $this->delete("/api/products/6", [], []);
//        $this->seeStatusCode(410);
//        $this->seeJsonStructure([
//            'status',
//            'message'
//        ]);
    }

}
