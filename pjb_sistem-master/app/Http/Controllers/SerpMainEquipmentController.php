<?php

namespace App\Http\Controllers;

use App\Models\Serp_System;
use App\Models\Serp_Main_Equipment;
use App\Models\Serp_Pic;
use App\Exports\MainEquipmentExport;
use App\Imports\MainEquipmentImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SerpMainEquipmentController extends Controller
{
    public function index()
    {
        $serp_system = Serp_System::all();
        $serp_main = Serp_Main_Equipment::orderBy('MPI','desc')->get();
        $pic = Serp_Pic::all();
        return view('SERP_MAIN.data-serp_main',compact('serp_system','serp_main','pic'));
    }   

   
    public function search(Request $request)
    { 
        $serp_pic_id = $request->get('serp_pic_id');
        $serp_system = Serp_System::all();
        $serp_main_sc = Serp_Main_Equipment::where('serp_pic_id',$serp_pic_id)->orderBy('mpi','desc')->get()->count();
        $serp_main_10p = floor($serp_main_sc/10);
        $serp_main = Serp_Main_Equipment::where('serp_pic_id',$serp_pic_id)->orderBy('mpi','desc')->take($serp_main_10p)->get();
        $pic = Serp_Pic::all();
        return view('SERP_MAIN.data-serp_main',compact('serp_system','serp_main','pic','serp_pic_id'));
    }


   public function ekspor ()
   {
    return Excel::download(new MainEquipmentExport, 'serp_main_equipment.xlsx');

   }

   public function impor(Request $request) 
   {
       // validasi
       $this->validate($request, [
           'file' => 'required|mimes:csv,xls,xlsx'
       ]);

       // menangkap file excel
       $file = $request->file('file');

       // membuat nama file unik
       $nama_file = rand().$file->getClientOriginalName();

       // upload ke folder file_main_equipment di dalam folder public
       $file->move('file_main_equipment',$nama_file);

       // import data
       Excel::import(new MainEquipmentImport,'file_main_equipment/'.$nama_file);


       // notifikasi
       return redirect('data-serp_main')->with('success', 'Data Berhasil DiImpor!');

   }

    public function create()
    {
        $serp_system = Serp_System::all();
        $serp_pic = Serp_Pic::all();
        $serp_main = Serp_Main_Equipment::all();
        return view('SERP_MAIN.create-serp_main',compact('serp_system','serp_main','serp_pic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'serp_main_equipment_id'=>'required',
            'serp_main_equipment_name'=>'required',
            'serp_system_id'=>'required',
            'OC'=>'required',
            'PT'=>'required',
            'PQ'=>'required',
            'RC'=>'required',
            'PE'=>'required',
            'RT'=>'required',
            'serp_pic_id'=>'required',
            'serp_main_equipment_keterangan'=>'required',
        ]);
        
        $oc=$request->OC;
        $pt=$request->PT;
        $pq=$request->PQ;
        $sf=$request->SF;
        $rc=$request->RC;
        $pe=$request->PE;
        $rt=$request->RT;
        $ocr=$request->OCR;
        $afpf=$request->AFPF;
        $scr=pow((pow($oc,2)+pow($pt,2)+pow($pq,2)+pow($sf,2)+pow($rc,2)+pow($pe,2)+pow($rt,2))/7,0.5);
        $acr=$scr*$ocr;
        $mpi=$acr*$afpf;
        
        Serp_Main_Equipment::create([
            'serp_main_equipment_id' => $request->serp_main_equipment_id,
            'serp_main_equipment_name' => $request->serp_main_equipment_name,
            'serp_system_id' => $request->serp_system_id,
            'OC' => $request->OC,
            'PT' => $request->PT,
            'PQ' => $request->PQ,
            'SF' => $request->SF,
            'RC' => $request->RC,
            'PE' => $request->PE,
            'RT' => $request->RT,
            'SCR'=>$scr,
            'OCR'=>$request->OCR,
            'ACR'=>$acr,
            'AFPF'=>$request->AFPF,
            'MPI'=>$mpi,
            'serp_pic_id' => $request->serp_pic_id,
            'serp_main_equipment_keterangan' => $request->serp_main_equipment_keterangan,
            'created_at' => date('Y-M-d H:i:s'),
            'updated_at' => date('Y-M-d H:i:s'),
            ]);
        return redirect('data-serp_main')->with('success', 'Data Berhasil Tersimpan!');
    }


    public function history()
    {
        $main1= Serp_Main_Equipment::count();
        dd($main1);

    }

    public function show(Serp_Main_Equipment $serp_Main_Equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Serp_Main_Equipment  $serp_Main_Equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Serp_Main_Equipment $serp_main_equipment)
    {
        $serp_system = Serp_System::all();
        $serp_pic = Serp_Pic::all();
        return view('SERP_MAIN.edit-serp_main',compact('serp_main_equipment','serp_system','serp_pic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Serp_Main_Equipment  $serp_Main_Equipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Serp_Main_Equipment $serp_main_equipment)
    {
        $request->validate([
            'serp_main_equipment_id'=>'required',
            'serp_main_equipment_name'=>'required',
            'serp_system_id'=>'required',
            'OC'=>'required',
            'PT'=>'required',
            'PQ'=>'required',
            'RC'=>'required',
            'PE'=>'required',
            'RT'=>'required',
            'serp_pic_id'=>'required',
            'serp_main_equipment_keterangan'=>'required',
        ]);
    
        $oc=$request->OC;
        $pt=$request->PT;
        $pq=$request->PQ;
        $sf=$request->SF;
        $rc=$request->RC;
        $pe=$request->PE;
        $rt=$request->RT;
        $ocr=$request->OCR;
        $afpf=$request->AFPF;
        $scr=pow((pow($oc,2)+pow($pt,2)+pow($pq,2)+pow($sf,2)+pow($rc,2)+pow($pe,2)+pow($rt,2))/7,0.5);
        $acr=$scr*$ocr;
        $mpi=$acr*$afpf;
        
        Serp_Main_Equipment::where('serp_main_equipment_id',$serp_main_equipment->serp_main_equipment_id)
        ->update([
            'serp_main_equipment_id' => $request->serp_main_equipment_id,
            'serp_main_equipment_name' => $request->serp_main_equipment_name,
            'serp_system_id' => $request->serp_system_id,
            'OC' => $request->OC,
            'PT' => $request->PT,
            'PQ' => $request->PQ,
            'SF' => $request->SF,
            'RC' => $request->RC,
            'PE' => $request->PE,
            'RT' => $request->RT,
            'SCR'=>$scr,
            'OCR'=>$request->OCR,
            'ACR'=>$acr,
            'AFPF'=>$request->AFPF,
            'MPI'=>$mpi,
            'serp_pic_id' => $request->serp_pic_id,
            'serp_main_equipment_keterangan' => $request->serp_main_equipment_keterangan,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            ]);
        return redirect('data-serp_main')->with('success', 'Data Berhasil Tersimpan!');
    }

   
    public function destroy($serp_main_equipment_id)
    {
        $data = Serp_Main_Equipment::findOrFail($serp_main_equipment_id);
        $data->delete();
        return back()->with('info', 'Data Berhasil Terhapus');
    }
}
