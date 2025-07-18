<?php

namespace App\Http\Controllers\Backoffice;

use App\Enums\ImageType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\FacilityCollection;
use App\Http\Resources\Backoffice\FacilityShowResource;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\Image as ImageModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $data = Facility::where(function ($q) use ($request) {
                // if ($request->has('search') && $request->search != '') {
                //     $q->where('name', 'like', '%' . $request->search . '%');
                // }
            })
            ->latest()
            ->get();

        return response()->json(ResponseFormat::format(
            200,
            '',
            FacilityCollection::collection($data),
        ));
    }

    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'status' => 'required|in:PUBLISHED,DRAFT',
            'description' => 'required|min:2|max:225',
            'image' => 'required|mimes:jpg,jpeg,png,gif,svg'.(env('APP_ENV') === 'production' ? '|max:1024':''),
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }
        
        // Simpan data ke database dan dapatkan ID baru
        $data = Facility::create([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        // Simpan gambar
        if ($request->hasfile('image')) {
            // Asumsi kamu menerima gambar melalui request
            $image = $request->file('image');
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
            $landscapePath = 'assets/facility/landscape_'.$name;
            // Simpan gambar hasil crop
            $imgLandscape->save(env('APP_BASE_PATH').($landscapePath),100);



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
            $portraitPath = 'assets/facility/portrait_'.$name;
            // Simpan gambar hasil crop
            $imgPortrait->save(env('APP_BASE_PATH').($portraitPath),100);

            $image = ImageModel::create([
                'path_original' => $landscapePath,
                'path_portrait' => $portraitPath,
                'type' => ImageType::FACILITY,
            ]);
        }
        // Update path file di database
        $data
            ->update([
                'image_id' => $image->id_image,
            ]);
        return response()->json(ResponseFormat::format(
            200,
            'Facility added'
        ));
    }
    public function show($id)
    {
        $data = Facility::find($id);
        
        return response()->json(ResponseFormat::format(
            200,
            '',
            new FacilityShowResource($data)
        ));
    }
    public function update(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'status' => 'required|in:PUBLISHED,DRAFT',
            'description' => 'required|min:2|max:225',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,svg'.(env('APP_ENV') === 'production' ? '|max:1024':''),
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }
        
        // Simpan data ke database dan dapatkan ID baru
        $data = Facility::find($id);
        $data->update([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        // Simpan gambar
        if ($request->hasfile('image')) {
            // Asumsi kamu menerima gambar melalui request
            $image = $request->file('image');
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
            $landscapePath = 'assets/facility/landscape_'.$name;
            // Simpan gambar hasil crop
            $imgLandscape->save(env('APP_BASE_PATH').($landscapePath),100);



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
            $portraitPath = 'assets/facility/portrait_'.$name;
            // Simpan gambar hasil crop
            $imgPortrait->save(env('APP_BASE_PATH').($portraitPath),100);


            if(!is_null($data->thumbnail)){
                $filePath = env('APP_BASE_PATH').($data->thumbnail?->path_original);
                if (file_exists($filePath)) {
                    File::delete($filePath);
                }
                $filePath = env('APP_BASE_PATH').($data->thumbnail?->path_portrait);
                if (file_exists($filePath)) {
                    File::delete($filePath);
                }

                $data->thumbnail()->delete();
            }

            $image = ImageModel::create([
                'path_original' => $landscapePath,
                'path_portrait' => $portraitPath,
                'type' => ImageType::FACILITY,
            ]);
            $data->update([
                'image_id' => $image->id_image,
            ]);
        }
        
        return response()->json(ResponseFormat::format(
            200,
            'Facility updated'
        ));
    }

    public function destroy($id)
    {
        $data = Facility::find($id);
    
        if(!is_null($data->thumbnail?->path || null)){

            $filePath = env('APP_BASE_PATH').($data->thumbnail?->path);
            if (file_exists($filePath)) {
                File::delete($filePath);
            }
            $data->thumbnail()->delete();
        }

        $data->delete();

        return response()->json(ResponseFormat::format(
            200,
            'Facility deleted'
        ));
    }
}
