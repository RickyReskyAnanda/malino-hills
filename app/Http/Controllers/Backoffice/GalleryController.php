<?php

namespace App\Http\Controllers\Backoffice;

use App\Enums\ImageType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\GalleryCollection;
use App\Http\Resources\Backoffice\GalleryShowResource;
use App\Models\Image as ImageModel;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('limit',15);
        $data = ImageModel::where('type', ImageType::GALLERY)
            ->latest()
            ->paginate($perPage);

        return response()->json(ResponseFormat::format(
            200,
            '',
            GalleryCollection::collection($data),
            [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ]
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png,gif,svg'.(env('APP_ENV') === 'production' ? '|max:10500':''),
        ]);

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
            $landscapePath = 'assets/gallery/landscape_'.$name;
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
            $portraitPath = 'assets/gallery/portrait_'.$name;
            // Simpan gambar hasil crop
            $imgPortrait->save(env('APP_BASE_PATH').$portraitPath,100);

            $image = ImageModel::create([
                'path_original' => $landscapePath,
                'path_portrait' => $portraitPath,
                'type' => ImageType::GALLERY,
            ]);
        }

        return response()->json(
            ResponseFormat::format(
                200,
                'Image added',
                new GalleryShowResource($image)
            ),
            200
        );
    }

    public function destroy($id)
    {
        $data = ImageModel::find($id);
    
        $filePath = env('APP_BASE_PATH').$data->path;
        if (file_exists($filePath)) {
            File::delete($filePath);
        }

        $data->delete();

        return response()->json(ResponseFormat::format(
            200,
            'Image deleted'
        ));
    }
}
