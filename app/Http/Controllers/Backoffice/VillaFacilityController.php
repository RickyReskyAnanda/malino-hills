<?php

namespace App\Http\Controllers\Backoffice;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\VillaShowResource;
use App\Http\Resources\Backoffice\VillaFacilityCollection;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use App\Models\Villa;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class VillaFacilityController extends Controller
{
    public function index(Request $request,$id)
    {
        $villa = Villa::find($id);

        $facilities = $villa
            ->facilities()
            ->get();

        return response()->json(ResponseFormat::format(
            200,
            '',
            VillaFacilityCollection::collection($facilities),
        ));
    }
    
    public function update(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'facilities.*.id' => 'nullable|numeric',
            'facilities.*.name' => 'required|string|max:50',
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }

        $villa = Villa::find($id);
        $facilities = $request->input('facilities',[]);
        $hfArr = [];
        foreach($facilities as $key => $hF) {
            $facility = $villa
            ->facilities()
            ->where('id_villa_facility', $hF['id'])
            ->updateOrCreate([ 
                'id_villa_facility' => $hF['id']
            ],[
                'name' => $hF['name'],
                'status_highlight'=> 'REGULER',
                'status'=> StatusType::PUBLISHED,

            ]);    

            $hfArr[] = $facility->id;
        }


        $villa
            ->facilities()
            ->whereNotIn('id_villa_facility', $hfArr)
            ->delete();

        return response()->json(ResponseFormat::format(
            200,
            "Facilities updated"
        ));
    }
}
