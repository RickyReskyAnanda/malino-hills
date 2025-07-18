<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\VillaShowResource;
use App\Http\Resources\Backoffice\VillaFacilityCollection;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use App\Models\Villa;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class VillaHighlightFacilityController extends Controller
{
    public function index(Request $request,$id)
    {
        $villa = Villa::find($id);

        $highlightFacilities = $villa
            ->highlightFacilities()
            ->get();

        return response()->json(ResponseFormat::format(
            200,
            '',
            VillaFacilityCollection::collection($highlightFacilities),
        ));
    }
    
    public function update(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'highlight_facilities.*.id' => 'required|numeric',
            'highlight_facilities.*.name' => 'required|string|max:50',
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }

        $villa = Villa::find($id);

        foreach($request->input('highlight_facilities',[]) as $key => $hF) {
            $villa
            ->highlightFacilities()
            ->where('id_villa_facility', $hF['id'])
            ->update([ 'name' => $hF['name'] ]);    
        }
        return response()->json(ResponseFormat::format(
            200,
            "Highlighted facilities updated"
        ));
    }
}
