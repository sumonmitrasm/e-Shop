<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    public static function getShippingCharges($total_weight,$country)
    {
        $shippingDetails = ShippingCharge::where('country',$country)->first()->toArray();
        if ($total_weight>0) {
            if ($total_weight>0 && $total_weight<=500) {
                $shipping_charges = $shippingDetails['0_500g'];
            }else if ($total_weight>501 && $total_weight<=1000) {
                $shipping_charges = $shippingDetails['501_1000g'];
            }else if ($total_weight>1001 && $total_weight<=2000) {
                $shipping_charges = $shippingDetails['1001_2000g'];
            }else if ($total_weight>2001 && $total_weight<=5000) {
                $shipping_charges = $shippingDetails['2001_5000g'];
            }else if ($total_weight>5000) {
                $shipping_charges = $shippingDetails['above_5000g'];
            }else{
                $shipping_charges = 0;
            }
        }else{
            $shipping_charges = 0;
        }
        return $shipping_charges;
    }
}
