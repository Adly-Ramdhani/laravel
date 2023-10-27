<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicines = Medicine::orderBy('name', 'ASC')->simplePaginate(5);
        return view('medicine.index', compact('medicines'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('medicine.create');     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
        $request->validate([
            'name'=>'required|min:3',
            'type'=> 'required',
            'price'=>'required|numeric',
            'stock'=>'required|numeric',
            // 'email'=> 'emaol.dns'
        ],[
            'name.required' => 'Nama obat wajid diisi!',
            'name.min' => 'Nama obat tidak boleh kurang dari 3 karakter!',
            'type.required' => 'Jenis Obat wajib diisi!',
            'price.required' => 'Harga Obat Wajib diisi!',
            'stock.required' => 'Stok obat wajid diisi!',

        ]);

        Medicine::create([
            'name'=> $request->name,
            'type'=> $request->type,
            'price'=> $request->price,
            'stock'=> $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function show(Medicine $medicine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $medicine = Medicine::find($id);
        return view('medicine.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $request->validate([
                'name' => 'required|min:3',
                'type' => 'required',
                'price' => 'required|numeric'
            ]);
    
            Medicine::where('id', $id)->update([
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price
            ]);
    
            return redirect()->route('medicine.home')->with('success', 'Berhasil mengubah data!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    
    public function stock()
    {
        $medicines = Medicine::orderBy('stock', 'ASC')->get();
        return view('medicine.stock', compact('medicines'));
    }

    public function destroy($id )
    {
        Medicine::where('id',$id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }
}