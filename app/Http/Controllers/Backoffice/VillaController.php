<?php

namespace App\Http\Controllers\Backoffice;

use App\Enums\ImageType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\VillaShowResource;
use App\Http\Resources\Backoffice\VillaCollection;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use App\Models\Villa;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

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

    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'status' => 'required|in:PUBLISHED,DRAFT',
            'content' => 'required|max:2000',
            'price' => 'required|numeric',
            'villa_count' => 'required|numeric',
            'thumbnail' => 'nullable|mimes:jpg,jpeg,png,gif,svg'.(env('APP_ENV') === 'production' ? '|max:2048':''),
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }

        // Simpan data ke database dan dapatkan ID baru
        $data = new Villa();

        $data->name = $request->name;
        $data->status = $request->status;
        $data->price = $request->price;
        $data->villa_count = $request->villa_count;
        $data->content = $request->content;

        if ($request->hasfile('thumbnail')) {
            // Asumsi kamu menerima gambar melalui request
            $image = $request->file('thumbnail');
            $name = time() . '_' . $image->getClientOriginalName();

            // Buat instance dari gambar yang diupload
            $imgLandscape = Image::read($image);
            $imgPortrait = Image::read($image);

            // Ukuran yang diinginkan
            $targetWidth = 679;
            $targetHeight = 467;

            // Dapatkan ukuran asli gambar
            $originalWidth = $imgLandscape->width();
            $originalHeight = $imgLandscape->height();

            $nowHeight = ($originalWidth*11)/16;
            // if($originalWidth < $originalHeight)
            $imgLandscape->crop($originalWidth,   $nowHeight,  0, ($originalHeight - $nowHeight) /2);
            $imgLandscape->resize($targetWidth, $targetHeight, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Crop bagian tengah gambar setelah resize
            $landscapePath = 'assets/villas/landscape_'.$name;
            // Simpan gambar hasil crop
            $imgLandscape->save(env('APP_BASE_PATH').$landscapePath,100);



            $targetWidth = 467;
            $targetHeight = 679;

            // Dapatkan ukuran asli gambar
            $originalWidth = $imgPortrait->width();
            $originalHeight = $imgPortrait->height();

            $nowWidth = ($originalHeight*11)/16;
            // if($originalWidth < $originalHeight)
            $imgPortrait->crop($nowWidth, $originalHeight  ,  ($originalWidth - $nowWidth) /2, 0);
            $imgPortrait->resize($targetWidth, $targetHeight, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Crop bagian tengah gambar setelah resize
            $portraitPath = 'assets/villas/portrait_'.$name;
            // Simpan gambar hasil crop
            $imgPortrait->save(env('APP_BASE_PATH').$portraitPath,100);

            $image =  $data->images()->create([
                'path_original' => $landscapePath,
                'path_portrait' => $portraitPath,
                'type' => ImageType::VILLA_THUMBNAIL,
            ]);

            $data->thumbnail_image_id = $image->id_image;
        }

        $data->save();

        for ($i=0; $i < $data->villa_count; $i++) { 
            $data->villaNumber()->create([
                'number' => $i+1,
            ]);
        }

        $facilities = $this->getHighlightFacilities();
        foreach($facilities as $key => $d){
            $data->highlightFacilities()->create(['villa_id'=>$data->id_villa, ...$d]);
        }

        return response()->json(ResponseFormat::format(
            200,
            "{$data->name} created",
            ['id' => $data->id_villa]
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
            'status' => 'required|in:PUBLISHED,DRAFT',
            'content' => 'required|max:2000',
            'villa_count' => 'required|numeric',
            'price' => 'required|numeric',
            'thumbnail' => 'nullable|mimes:jpg,jpeg,png,gif,svg'.(env('APP_ENV') === 'production' ? '|max:2048':''),
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
        $data->status = $request->status;
        $data->price = $request->price;
        $data->villa_count = $request->villa_count;
        $data->content = $request->content;
        if ($request->hasfile('thumbnail')) {
            // Asumsi kamu menerima gambar melalui request
            $image = $request->file('thumbnail');
            $name = time() . '_' . $image->getClientOriginalName();

            // Buat instance dari gambar yang diupload
            $imgLandscape = Image::read($image);
            $imgPortrait = Image::read($image);

            // Ukuran yang diinginkan
            $targetWidth = 679;
            $targetHeight = 467;

            // Dapatkan ukuran asli gambar
            $originalWidth = $imgLandscape->width();
            $originalHeight = $imgLandscape->height();

            $nowHeight = ($originalWidth*11)/16;
            // if($originalWidth < $originalHeight)
            $imgLandscape->crop($originalWidth,   $nowHeight,  0, ($originalHeight - $nowHeight) /2);
            $imgLandscape->resize($targetWidth, $targetHeight, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Crop bagian tengah gambar setelah resize
            $landscapePath = 'assets/villas/landscape_'.$name;
            // Simpan gambar hasil crop
            $imgLandscape->save(env('APP_BASE_PATH').$landscapePath,100);



            $targetWidth = 467;
            $targetHeight = 679;

            // Dapatkan ukuran asli gambar
            $originalWidth = $imgPortrait->width();
            $originalHeight = $imgPortrait->height();

            $nowWidth = ($originalHeight*11)/16;
            // if($originalWidth < $originalHeight)
            $imgPortrait->crop($nowWidth, $originalHeight  ,  ($originalWidth - $nowWidth) /2, 0);
            $imgPortrait->resize($targetWidth, $targetHeight, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Crop bagian tengah gambar setelah resize
            $portraitPath = 'assets/villas/portrait_'.$name;
            // Simpan gambar hasil crop
            $imgPortrait->save(env('APP_BASE_PATH').$portraitPath,100);

            File::delete(env('APP_BASE_PATH').$data->images?->path_portrait);
            File::delete(env('APP_BASE_PATH').$data->images?->path_original);


            $image =  $data->images()->updateOrCreate([
                'type' => ImageType::VILLA_THUMBNAIL,
            ],[
                'path_original' => $landscapePath,
                'path_portrait' => $portraitPath,
                'type' => ImageType::VILLA_THUMBNAIL,
            ]);

            $data->thumbnail_image_id = $image->id_image;
        }
        $data->save();

        for ($i=1; $i <= $data->villa_count; $i++) { 
            $data->villaNumber()->updateOrCreate([
                'number' => $i+1,
            ],[
                'number' => $i+1,
            ]);
        }
        $data->villaNumber()->where('number',">",$data->villa_count)->delete();


        return response()->json(ResponseFormat::format(
            200,
            "{$data->name} updated"
        ));
    }


    private function getHighlightFacilities(){
        return [
            [
                'icon_id' => 2,
                'name' => '1 Bed',
                'status' => 'PUBLISHED',
                'status_highlight' => 'HIGHLIGHT',
            ],
            [
                'icon_id' => 3,
                'name' => '1 People',
                'status' => 'PUBLISHED',
                'status_highlight' => 'HIGHLIGHT',
            ],
            [
                'icon_id' => 1,
                'name' => 'Breakfast',
                'status' => 'PUBLISHED',
                'status_highlight' => 'HIGHLIGHT',
            ],
            [
                'icon_id' => 4,
                'name' => 'View',
                'status' => 'PUBLISHED',
                'status_highlight' => 'HIGHLIGHT',
            ],
        ];
    }
}
