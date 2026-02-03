<?php

namespace App\Helpers;

use App\Models\EmbroideryOrder;

class EmbroideryOrderHelper
{
    public static function generateOrderNo()
    {
        $last = EmbroideryOrder::latest('id')->first();

        if (!$last) {
            return 'EMB-0000001';
        }

        $number = intval(substr($last->emb_order_no, 4)) + 1;

        return 'EMB-' . str_pad($number, 7, '0', STR_PAD_LEFT);
    }
}
