<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class GaleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $galeries = Galery::get();
       return view('index',compact('galeries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $val=$request->validate([
            'judul'=>"required",
            'deskripsi'=>"required",
            'photo'=>"required",
        ]);
        if ($request->hasFile('photo'))
        {
            $filePath=Storage::disk('public')->put('image/posts/',request()->file('photo'));
            $val['photo']=$filePath;
        }
        $create= Galery::create([
            'judul' => $val['judul'],
            'deskripsi' => $val['deskripsi'],
            'photo' => $val['photo'],
            'user_id' => Session::get('user_id'),
        ]);
        if ($create)
        {
            session()->flash('succes','galery berhasil dibuat');
            return redirect('/galery');
        }
        return abort(500);
    }    
    /**
     * Display the specified resource.
     */
    public function show(Galery $galery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galery $galery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galery $galery)
    {
        //
        if ($request->hasFile('photo')){
          
            $filePath=Storage::disk('public')->put('image/posts/',request()->file('photo'));
            $galery->judul=$request->judul;
            $galery->deskripsi=$request->deskripsi;
            $galery->photo=$filePath;
            $galery->user_id=Session::get('user_id');
            $galery->save();
            
        }
        else{
            $galery->judul=$request->judul;
            $galery->deskripsi=$request->deskripsi;
            $galery->photo=$galery->photo;
            $galery->user_id=Session::get('user_id');
            $galery->save();
        }
        return redirect('/galery');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galery $galery)
    {
        //
        $galery->delete();
        return redirect('/galery');
    }
}
