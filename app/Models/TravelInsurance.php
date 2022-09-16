<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TravelInsurance extends Model
{
    use HasFactory;

    public static function makeInsurance($request) {
        // return GroupInsurance::addGroup();
        $dob = date('Y-m-d', strtotime($request->dob));
        $departure = date('Y-m-d H:i:s', strtotime($request->departure));
        $return = date('Y-m-d H:i:s', strtotime($request->return));

        $lastInsertId = DB::table('travel_insurances')->insertGetId([
            'group' => $request->group,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $dob,
            'departure' => $departure,
            'return' => $return,
            'from' => $request->from,
            'to' => $request->to,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);


        GroupInsurance::addGroup($request->all()['groupInsuranceList'], $lastInsertId);

    }

}
