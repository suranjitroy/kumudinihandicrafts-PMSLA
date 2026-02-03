<?php

namespace App\Helpers;
use App\Models\ProductionChallan;


class ChallanHelper
{
    public static function generateChallanNo()
    {
        $last = ProductionChallan::latest('id')->first();

        if (!$last) {
            return 'PRCH-0000001';
        }

        $number = intval(substr($last->pro_challan_no, 5)) + 1;

        return 'PRCH-' . str_pad($number, 7, '0', STR_PAD_LEFT);
    }
}