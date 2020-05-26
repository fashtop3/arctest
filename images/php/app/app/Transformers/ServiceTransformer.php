<?php

namespace App\Transformers;

use App\Service;
use League\Fractal;

class ServiceTransformer extends Fractal\TransformerAbstract
{
    public function transform(Service $service)
    {
        return [
            'id' => (int)$service->id,
            'service_name' => $service->service_name,
            'price' => $service->price,
            'plan' => $service->plan,
            'service_description' => $service->service_description,
            'created_at' => $service->created_at->format('d-m-Y'),
            'updated_at' => $service->updated_at->format('d-m-Y'),
            'links' => [
                [
                    'uri' => 'services/' . $service->id,
                ]
            ],
        ];
    }
}
