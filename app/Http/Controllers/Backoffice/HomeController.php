<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Resources\UploadKVCollection;
use App\Utils\ResponseFormat;
use Illuminate\Http\Request;
use App\Models\BankKV;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UploadKVController extends Controller
{
    public function index(Request $request)
    {
                
        $data = BankKV::where(function ($q) use ($request) {
                if ($request->has('search') && $request->search != '') {
                    $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('produk', 'like', '%' . $request->search . '%')
                    ->orWhere('jenis', 'like', '%' . $request->search . '%');
                }
            })
            ->orderBy('id_bank_kv', 'desc')
            ->paginate(10);

        return response()->json(ResponseFormat::format(
            200,
            '',
            UploadKVCollection::collection($data),
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'produk' => 'required|min:2|max:100',
            'jenis' => 'required|min:2|max:100',
            'kv' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'kv_cdr' => 'required|file|max:10240',
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }
        
        // Simpan data ke database dan dapatkan ID baru
        $data = BankKV::create([
            'title' => $request->title,
            'produk' => $request->produk,
            'jenis' => $request->jenis,
        ]);

        // Simpan gambar
        $kvFile = $request->file('kv');
        $kvFileName = $data->id_bank_kv . "_" . $kvFile->getClientOriginalName();
        $kvFile->move(public_path("bank_kv"), $kvFileName);

        // Simpan file CDR
        $cdrFile = $request->file('kv_cdr');
        $cdrFileName = $data->id_bank_kv . "_" . $cdrFile->getClientOriginalName();
        $cdrFile->move(public_path("bank_kv"), $cdrFileName);

        // Update path file di database
        $data
            ->update([
                'kv' => "bank_kv/".$kvFileName,
                'kv_cdr' => "bank_kv/".$cdrFileName,
            ]);
        return response()->json(ResponseFormat::format(
            200,
            'KV added'
        ));
    }
    public function show($id)
    {
        $data = BankKV::find($id);
        
        return response()->json(ResponseFormat::format(
            200,
            '',
            $data
        ));
    }
    public function update(Request $request, $id)
    {   
         // Validasi input

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'produk' => 'required|min:2|max:100',
            'jenis' => 'required|min:2|max:100',
            'kv' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kv_cdr' => 'nullable|file|max:10240',
        ]);
    
        if ($validator->fails()) {
            return response()->json(ResponseFormat::format(
                400,
                $validator->errors()->first()
            ), 200);
        }
        // Simpan data ke database dan dapatkan ID baru
        BankKV::where('id_bank_kv',$id)
        ->update([
            'title' => $request->title,
            'produk' => $request->produk,
            'jenis' => $request->jenis,
        ]);

        $data = BankKV::select('kv','kv_cdr')
                ->where('id_bank_kv',$id)
                ->first();

        if ($request->hasFile('kv')) {
            $kvFile = $request->file('kv');
            $kvFileName = time() . $kvFile->getClientOriginalName();
            $kvFile->move(public_path("bank_kv"), $kvFileName);

            $filePath = public_path("bank_kv/$data->kv");
            File::delete($filePath);

            $data->kv = "bank_kv/".$kvFileName;
            $data->save();
        }
        if ($request->hasFile('kv_cdr')) {
            $cdrFile = $request->file('kv_cdr');
            $cdrFileName = time() . $cdrFile->getClientOriginalName();
            $cdrFile->move(public_path("bank_kv"), $cdrFileName);

            $filePath = public_path("bank_kv/$data->kv_cdr");
            File::delete($filePath);

            $data->kv_cdr = "bank_kv/".$cdrFileName;
            $data->save();
        }

        return response()->json(ResponseFormat::format(
            200,
            'KV updated'
        ));
    }

    public function destroy($id)
    {
        $data = BankKV::find($id);
    
        $filePath = public_path($data->kv);
        if (file_exists($filePath)) {
            File::delete($filePath);
        }
        $filePath = public_path($data->kv_cdr);
        if (file_exists($filePath)) {
            File::delete($filePath);
        }

        $data->delete();
        return response()->json(ResponseFormat::format(
            200,
            'KV deleted'
        ));
    }

    // public function download($id)
    // {
    //     $data = BankKV::select('kv_cdr')
    //         ->where('id', $id)
    //         ->first();
        
    //     return response()->download(public_path("bank_kv/$data->kv_cdr"));
    // }
}
