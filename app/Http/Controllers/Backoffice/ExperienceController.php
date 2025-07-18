<?php

namespace App\Http\Controllers\Backoffice;

use App\Enums\ImageType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\ExperienceCollection;
use App\Http\Resources\Backoffice\ExperienceShowResource;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use App\Models\Experience;
use App\Models\Image as ImageModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Laravel\Facades\Image;

class ExperienceController extends Controller
{
    public function index(Request $request)
    {

        $perPage = 12; // Jumlah item per halaman
        $page = $request->input('page', 1); // Mendapatkan halaman saat ini, default ke 1 jika tidak ada
        $start = ((int)$page - 1) * $perPage + 1;
        $data = Experience::where(function ($q) use ($request) {
                if (
                    $request->has('search') 
                    && $request->search != ''
                    && $request->search != 'all'
                ){
                    $q->where('title', 'like', '%' . $request->search . '%');
                    $q->orWhere('status', 'like', '%' . $request->search . '%');
                }
            })
            ->latest()
            ->paginate($perPage);

        $data->getCollection()->transform(function ($item) use (&$start) {
            $item->no = $start++;
            return $item;
        });
        
        return response()->json(ResponseFormat::format(
            200,
            '',
            ExperienceCollection::collection($data),
            [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ]
        ),200);
    }

    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'status' => 'required|in:PUBLISHED,DRAFT',
            'content' => 'required|string',
            'short_description' => 'required|max:255',
            'thumbnail' => 'required|mimes:jpg,jpeg,png,gif,svg'.(env('APP_ENV') === 'production' ? '|max:1024':''),
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }
        
        // Simpan data ke database dan dapatkan ID baru
        $data = Experience::create([
            'title' => $request->title,
            'status' => $request->status,
            'content' => $request->content,
            'short_description' => $request->short_description,
        ]);

        // Simpan gambar
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
            $landscapePath = 'assets/experience/landscape_'.$name;
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
            $portraitPath = 'assets/experience/portrait_'.$name;
            // Simpan gambar hasil crop
            $imgPortrait->save(env('APP_BASE_PATH').$portraitPath,100);

            $image = ImageModel::create([
                'path_original' => $landscapePath,
                'path_portrait' => $portraitPath,
                'type' => ImageType::EXPERIENCE_THUMBNAIL,
            ]);
            // Update path file di database
            $data
                ->update([
                    'image_id' => $image->id_image,
                ]);
        }
        
       
        return response()->json(ResponseFormat::format(
            200,
            'Experience added'
        ));
    }
    public function show($id)
    {
        $data = Experience::find($id);
        
        return response()->json(ResponseFormat::format(
            200,
            '',
            new ExperienceShowResource($data)
        ));
    }
    public function update(Request $request, $id)
    {   
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'status' => 'required|in:PUBLISHED,DRAFT',
            'content' => 'required|string',
            'short_description' => 'required|max:255',
            'thumbnail' => 'nullable|mimes:jpg,jpeg,png,gif,svg'.(env('APP_ENV') === 'production' ? '|max:1024':''),
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }
        
        // Simpan data ke database dan dapatkan ID baru
        $data = Experience::find($id);
        $data->update([
            'title' => $request->title,
            'status' => $request->status,
            'content' => $request->content,
            'short_description' => $request->short_description,
        ]);
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
            $landscapePath = 'assets/experience/landscape_'.$name;
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
            $portraitPath = 'assets/experience/portrait_'.$name;
            // Simpan gambar hasil crop
            $imgPortrait->save(env('APP_BASE_PATH').$portraitPath,100);

            File::delete(env('APP_BASE_PATH').$data->thumbnail?->path_portrait);
            File::delete(env('APP_BASE_PATH').$data->thumbnail?->path_original);


            $image =  $data->thumbnail()->updateOrCreate([
                'type' => ImageType::EXPERIENCE_THUMBNAIL,
            ],[
                'path_original' => $landscapePath,
                'path_portrait' => $portraitPath,
                'type' => ImageType::EXPERIENCE_THUMBNAIL,
            ]);

            $data->thumbnail_image_id = $image->id_image;
        }
        
        return response()->json(ResponseFormat::format(
            200,
            'Experience updated'
        ));
    }

    public function destroy($id)
    {
        $data = Experience::find($id);
    
        if(!is_null($data->thumbnail?->path || null)){

            $filePath = env('APP_BASE_PATH').data->thumbnail?->path;
            if (file_exists($filePath)) {
                File::delete($filePath);
            }
            $data->thumbnail()->delete();
        }

        $data->delete();

        return response()->json(ResponseFormat::format(
            200,
            'Experience deleted'
        ));
    }
}
