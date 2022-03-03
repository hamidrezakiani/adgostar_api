<?php

namespace App\Services\Representation;

use App\Repositories\Eloquent\ItemRepository;
use App\Repositories\Eloquent\OrderPropertyRepository;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\PropertyRepository;
use App\Repositories\Eloquent\RepresentationItemPeriodRepository;

class OrderPropertyService
{
    protected $orderPropertyRepository,$propertyRepository;
    public function __construct()
    {
        $this->orderPropertyRepository = new OrderPropertyRepository();
        $this->propertyRepository = new PropertyRepository();
    }

    public function store($order,$properties)
    {
      // return $properties;
       foreach($properties as $property)
       {
        //    $property = (array) $property;
           $type = $this->propertyRepository->find($property->id)->type->dataType;
           switch($type)
           {
               case 'TEXT':
                $this->orderPropertyRepository->create([
                    'order_id' => $order->id,
                    'property_id' => $property->id,
                    'value' => $property->value,
                ]);
                break;
               case 'FILE':

                break;
               default:
                break;
           }
       }
    }

}
