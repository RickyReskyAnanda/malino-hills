<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\VillaShowResource;
use App\Http\Resources\Backoffice\VillaCollection;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use App\Models\Villa;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class VillaController extends Controller
{
    public function index(Request $request)
    {
                
        $data = Villa::with('highlightFacilities')
            ->oldest()
            ->get();

        return response()->json(ResponseFormat::format(
            200,
            '',
            VillaCollection::collection($data),
        ));
    }

    public function show($id)
    {
        $data = Villa::find($id);
        
        return response()->json(ResponseFormat::format(
            200,
            '',
            new VillaShowResource ($data)
        ));
    }
    public function update(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'is_active' => 'required|in:ACTIVE,INACTIVE',
            'description' => 'required|max:2000',
            'price' => 'required|numeric',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:10000',
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }
        // Simpan data ke database dan dapatkan ID baru
        $data = Villa::where('id_villa',$id)->first();

        $data->name = $request->name;
        $data->is_active = $request->is_active;
        $data->price = $request->price;
        $data->description = $request->description;


        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path("villas"), $thumbnailName);

            $filePath = public_path("assets/villas/$data->thumbnail");
            File::delete($filePath);

            $data->images()->updateOrCreate([
                'type' => "VILLA_THUMBNAIL",
            ],[
                'path' => "assets/villas/".$thumbnailName,
                'type' => "VILLA_THUMBNAIL",
            ]);
        }

        $data->save();

        return response()->json(ResponseFormat::format(
            200,
            "Villa {$data->name} updated"
        ));
    }
}
