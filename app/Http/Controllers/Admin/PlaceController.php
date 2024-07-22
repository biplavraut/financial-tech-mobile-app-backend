<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    //
    public function district()
    {
        //
        $districts =  DB::table('districts')->get();
        return $districts;
    }

    public function province()
    {
        //
        $provinces =  DB::table('provinces')->get();
        return $provinces;
    }

    public function municipalities()
    {
        //
        $municipalities =  DB::table('municipalities')->get();
        return $municipalities;
    }

    public function filterrByDistrict(Request $request)
    {
        //
        $districtName = DB::table('districts')->select('name', 'province_id')->where('id', $request->district)->first();
        //return $districtName->name;
        $municipalities =  DB::table('municipalities')->where('district_name', $districtName->name)->get();
        return ['data' => $municipalities, 'province' => $districtName->province_id];
    }

}
