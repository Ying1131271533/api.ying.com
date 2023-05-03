<?php

namespace App\Transformers;

use App\Models\Address;
use League\Fractal\TransformerAbstract;

class AddressTransformer extends TransformerAbstract
{
    public function transform(Address $address)
    {
        return [
            'id'          => $address->id,
            'user_id'     => $address->user_id,
            'name'        => $address->name,
            'citie_code'    => $address->citie_code,
            'cities_name' => cities_name($address->citie_code),
            'address'     => $address->address,
            'phone'       => $address->phone,
            'is_default'  => $address->is_default,
            'created_at'  => $address->created_at->toDateTimeString(),
            'updated_at'  => $address->updated_at->toDateTimeString(),
        ];
    }
}
