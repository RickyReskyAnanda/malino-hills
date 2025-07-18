<?php

namespace App\Http\Controllers\Backoffice;

use App\Enums\ImageType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Backoffice\VenueGalleryCollection;
use App\Http\Resources\Backoffice\VenueGalleryShowResource;
use App\Models\Image as ImageModel;
use App\Models\Venue;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class MeetingRoomGalleryController extends Controller
{
    protected $id = 1;
    public function index(Request $request)
    {
        $perPage = $request->input('limit',15);
        $data = ImageModel::where('type', ImageType::VENUE)
            ->where('parent_id', $this->id)
            ->latest()
            ->paginate($perPage);

        return response()->json(ResponseFormat::format(
            200,
            '',
            VenueGalleryCollection::collection($data),
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
        $venue = Venue::find($this->id);
        if($venue->slideImages()->count() >= 10){
            return response()->json(
                ResponseFormat::format(
                    400,
                    'You have exceeded the input limit of 10 images',
                ),
                200
            );
        }
        
        $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png,gif,svg'.(env('APP_ENV') === 'production' ? '|max:2048':''),
        ]);

        $uploadedFiles = [];
        
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
            $landscapePath = 'assets/venue/landscape_'.$name;
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
            $portraitPath = 'assets/venue/portrait_'.$name;
            // Simpan gambar hasil crop
            $imgPortrait->save(env('APP_BASE_PATH').$portraitPath,100);

            $image = ImageModel::create([
                'path_original' => $landscapePath,
                'path_portrait' => $portraitPath,
                'type' => ImageType::VENUE,
                'parent_id' => $venue->id_venue,
            ]);
        }

        

        return response()->json(
            ResponseFormat::format(
                200,
                'Image added',
                new VenueGalleryShowResource($image)
            ),
            200
        );
    }

    public function destroy($idImage)
    {
        $data = ImageModel::find($idImage);
    
        $filePath = env('APP_BASE_PATH').$data->path_original;
        if (file_exists($filePath)) {
            File::delete($filePath);
        }

        $filePath = env('APP_BASE_PATH').$data->path_portrait;
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
