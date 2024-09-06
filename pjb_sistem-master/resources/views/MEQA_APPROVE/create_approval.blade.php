@extends('HalamanDepan.beranda')

@section('title','MEQA Approval ECP')

@section('container')
    <!-- Main content -->
    <div class="content">
    <div class ="card card-info card-outline col-11">
        <div class ="card-header">
          <h5>Input Data</h5>
        </div>
        <div class="card-body">
          <form action="{{route('simpan-meqa_approve')}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row">
          <div class="col-md-7">
          <div class="form-group">
            <label>NO ECP</label>
              <input type="text" id="ecp_no" name="ecp_no" class="form-control" value="{{$ecp_no}}">
            </div>

              <div class="form-group">
                <label>Alasan</label>
                <textarea class="form-control @error('meqa_approval_alasan') is-invalid @enderror" rows="2" name="meqa_approval_alasan" value="{{old('meqa_approval_alasan')}}"></textarea>
                @error('meqa_approval_alasan') <div class="invalid-feedback"> Masukkan Alasan !  </div> @enderror
              </div>
          </div>

          <div class="col-md-5  ">
              <div class="form-group">
                <label for="user_nid">Nama Manager EQA</label>
                <select class="form-control select2 @error('user_nid') is-invalid @enderror" id="user_nid" name="user_nid" value="{{old('user_nid')}}">
                <option selected value="{{auth()->user()->user_nid}}">{{auth()->user()->user_name}}</option>
                @error('user_id') <div class="invalid-feedback"> Masukkan Nama !  </div> @enderror 
                </select>
              </div>
              
              <div class="form-group">
                <label for="user_nid">Disposisi SPV SO</label>
                <select class="form-control select2 @error('spv_so') is-invalid @enderror"  name="spv_so" value="{{old('spv_so')}}">
                @foreach($spv as $item)
                <option selected value="{{$item->user_nid}}">{{$item->user_name}} : {{$item->jabatan->jabatan_name}} {{$item->fungsi->fungsi_name}}</option>
@endforeach
                @error('spv_so') <div class="invalid-feedback"> Masukkan Nama !  </div> @enderror 
                </select>
              </div>

                <div class="form-group col-sm-8">
            <label>Status ECP </label>
              <select class="form-control select2 @error('status_ecp_id') is-invalid @enderror" id="status_ecp_id" name="status_ecp_id" value="{{old('status_ecp_id')}}">
                <option selected disabled><-Status ECP-></option>
              @foreach($status as $item)
                <option value="{{$item->status_ecp_id}}">{{$item->status_ecp_name}}</option>
              @endforeach
              </select>
              @error('status_ecp_id') <div class="invalid-feedback"> {{$message}} </div> @enderror
              </div>
              </div>


           
            </div>
        </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success">Simpan Data</button>
            </div>

            


    <!-- /.content -->  
      </div>
    </div>
  @endsection
  <!-- /.content-wrapper -->

