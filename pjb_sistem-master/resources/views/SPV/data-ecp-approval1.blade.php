@extends('HalamanDepan.beranda')

@section('title','Data ECP')
@section('container')
 
<div class="content">
      <div class ="card card-info card-outline">  
      <div class ="card-header">  
      <a><b>ECP yg perlu approval : </b></a><a style="color:red"><b>{{$jumlah}}</b></a>   
         
      </div>
        
            <!-- /.card-header -->
            <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped myTable table-sm">
                <thead>
                <tr>
                  <th>#</th>
                  <th>NO ECP</th>
                  <th>NAMA</th>
                  <th>DESKRIPSI</th>
                  <th>URGENSI</th>
                  <th>APPROVAL1</th>
                  <th>APPROVAL2</th>
                  <th>FILE PENDUKUNG</th>
                  <th>TANGGAL PENGAJUAN</th>
                  <th>PROGRES</th>
                  <th>AKSI</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($ecp as $e=>$item)
                <tr>
                <td>{{ $loop->iteration}}</td>                  
                    <td>{{$item->ecp_no}}</td>
                    <td>{{$item->user->user_name}}</td>
                    <td>{{$item->ecp_deskripsi}}</td>
                    @if($item->urgensi_id == 1)
                    <td> <label class="badge badge-primary">{{$item->urgensi->urgensi_name}} </label></td>
                    

                    @elseif($item->urgensi_id == 2)
                    <td> <label class="badge badge-warning">{{$item->urgensi->urgensi_name}} </label></td>

                    @elseif($item->urgensi_id == 3)
                    <td> <label class="badge badge-danger">{{$item->urgensi->urgensi_name}} </label></td>
                    @endif
                    <td>{{$item->approval1->user_name}}</td>
                    <td>{{$item->approval2->user_name}}</td>
                    <td> <p> <a href="{{asset($item->ecp_file_pendukung) }}" class="badge badge-info" download=""><i class="fas fa-download"></i>  Download File</a></p></td>
                    <td>{{date('d M Y H:i:s',strtotime($item->created_at))}}</td>
                    <td><i>{{$item->progres->progres_name}}</i></td>
                    <td>
                    @php
                       $ecp_no = str_replace('/','-',$item->ecp_no);
                    @endphp
                    <a href="{{route('show-ecp',$ecp_no)}}" class="badge badge-dark"><i class="fas fa-eye" style="color:aliceblue"></i> Detail</a>
                    @if ((auth()->user()->role_id=='3')&& ($item->progres_id=='1'))
                    <a class="badge badge-light">*Lihat Detail Untuk Approve</a>
                    @endif
                      </td>
                </tr>
                @endforeach
                </tbody>
              </table>
              </div>
            </div>
</div>
</div>
@endsection



 
