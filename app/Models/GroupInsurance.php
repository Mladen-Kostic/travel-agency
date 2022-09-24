<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GroupInsurance extends Model
{
    use HasFactory;

    public static function addGroup($data, $id) {

        foreach ($data as $item) {
            $date = date('Y-m-d', strtotime($item['dob']));

            DB::table('group_insurances')->insert([
                'first_name' => $item['first_name'],
                'last_name' => $item['last_name'],
                'dob' => $date,
                'travel_insurances_id' => $id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
    }

    public static function groupById($id) {
        $data = DB::table('group_insurances')
            ->where('travel_insurances_id', $id)
            ->select(
                'first_name',
                'last_name',
                'dob'
            )
            ->get();

        return $data;
    }

}
