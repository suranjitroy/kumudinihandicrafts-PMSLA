<?php

namespace App\Helpers;
use App\Models\DesignInfo;

class DesignHelper
{
    public static function generateDesignNo(): string
    {
        $lastDesignNo = DesignInfo::orderBy('id', 'desc')->value('design_no');

        if (!$lastDesignNo) {
            return 'DES-0000001';
        }

        $number = (int) str_replace('DES-', '', $lastDesignNo);

        return 'DES-' . str_pad($number + 1, 7, '0', STR_PAD_LEFT);
    }
}
