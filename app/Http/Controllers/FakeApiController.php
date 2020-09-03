<?php

namespace App\Http\Controllers;


use App\Models\BadgeType;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FakeApiController extends AppController
{
    public function calculateBadgePrice($data) {
        try {
            $badge =  BadgeType::where('id', $data['badge_type_id'])->first();
            $zone = Zone::where('id', $data['zone_id'])->first();
            if(!$badge && !$zone) {
                return false;
            }
            return $badge['couttc'] + $zone['tarif'];
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
