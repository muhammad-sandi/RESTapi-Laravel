<?php

namespace App\Http\Controllers\Api;

use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KamarResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get Kamars
        $kamars = Kamar::latest()->paginate(5);

        //return collection of kamars as a resource
        return new KamarResource(true, 'List Data Kamar', $kamars);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'tipe_kamar'     => 'required',
            'harga_kamar'    => 'required',
            'jumlah_kamar'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // //upload image
        // $image = $request->file('image');
        // $image->storeAs('public/kamars', $image->hashName());

        //create kamar
        $kamar = Kamar::create([
            'tipe_kamar'     => $request->tipe_kamar,
            'harga_kamar'     => $request->harga_kamar,
            'jumlah_kamar'   => $request->jumlah_kamar,
        ]);

        //return response
        return new KamarResource(true, 'Data Kamar Berhasil Ditambahkan!', $kamar);
    }

    /**
     * show
     *
     * @param  mixed $kamar
     * @return void
     */
    public function show(Kamar $kamar)
    {
        //return single kamar as a resource
        return new KamarResource(true, 'Data Kamar Ditemukan!', $kamar);
    }

    // /**
    //  * update
    //  *
    //  * @param  mixed $request
    //  * @param  mixed $kamar
    //  * @return void
    //  */
    // public function update(Request $request, Kamar $kamar)
    // {
    //     //define validation rules
    //     $validator = Validator::make($request->all(), [
    //         'tipe_kamar'     => 'required',
    //         'harga_kamar'    => 'required',
    //         'jumlah_kamar'   => 'required',
    //     ]);

    //     //check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //         //update kamar
    //         $kamar->update([
    //             'tipe_kamar'     => $request->tipe_kamar,
    //             'harga_kamar'     => $request->harga_kamar,
    //             'jumlah_kamar'   => $request->jumlah_kamar,
    //         ]);

    //     //return response
    //     return new KamarResource(true, 'Data Kamar Berhasil Diubah!', $kamar);
    // }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy(Kamar $kamar)
    {
        // //delete image
        // Storage::delete('public/posts/'.$post->image);

        //delete post
        $kamar->delete();

        //return response
        return new KamarResource(true, 'Data Kamar Berhasil Dihapus!', null);
    }
}