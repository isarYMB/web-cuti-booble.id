@extends('layouts/index')

@section('content')
<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn text-dark mr-3"> <i data-feather="align-justify"></i></a></li>
          </ul>
          <ul class="navbar-nav font-weight-bold h6">
            Riwayat Cuti
          </ul>
          
        </div>
      </nav>
<div class="main-content">
    <section class="section">
        <div class="row">
        <div class="col-12 col-sm-12 col-lg-12">
        <div id="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
        @if(session()->has('message'))
            <div class="alert alert-dismissable alert-danger">
                {{ session()->get('message') }}
            </div>
        @endif
            <div class="card">
                <div class="card-header ml-4">
                    <h4>Data Pengajuan Cuti</h4>
                </div>
                <table class="table table-striped">
                <tr>
                  <th class="ml-4 mt-3 text-left  ">
                    {{-- <div class="ml-4">Sisa Cuti: {{$permohonan->jumlah_cuti}}</div> --}}
                </th>
                  <th class="ml-4 mt-3 text-right  ">
                    <button class="btn btn-warning mr-4" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-plus"></i> Tambah</button>
                </th>
                </tr>
                </table>
                
            <div class="card-body">
                <div class="table-responsive table-invoice">
                <table class="table table-striped">
                    <tr>
                        <th class="text-center">No</th>
                        <th>nama karyawan</th>
                        <th>Alasan Cuti</th>
                        <th>Mulai Cuti</th>
                        <th>Berakhir Cuti</th>
                        <th class="text-center">Status</th>
                        <th>Ket. Tolak</th>
                        <th class="text-center">#</th>
                    </tr>
                    @foreach($permohonan as $i => $p)
                    <tr>
                        <td class="p-0 text-center">{{$i+1}}</td>
                        <td class="font-weight-600">{{$p->name}}</td>
                        <td class="text-truncate">{{$p->alasan_cuti}}</td>
                        <td class="align-middle">{{$p->tgl_mulai}}</td>
                        <td class="align-middle">{{$p->tgl_akhir}}</td>
                        <td class="align-middle text-center">
                            @if($p->status === "Baru")
                                <span class="badge baru">{{$p->status}}</span>
                            @elseif($p->status === "Diterima")
                                <span class="badge diterima">{{$p->status}}</span>
                            @elseif($p->status === "Diatasan")
                                <span class="badge diatasan">{{$p->status}}</span>
                            @elseif($p->status === "Dibatalkan")
                                <span class="badge batal">{{$p->status}}</span>
                            @elseif($p->status === "Ditolak")
                                <span class="badge ditolak">{{$p->status}}</span>
                            @endif
                        </td>
                        <td>
                            @if($p->status === "Ditolak")
                            <a data-id="{{$p->ket_tolak}}" class="badge detail" data-toggle="modal" data-backdrop="true" href="#" data-target="#ketTolakAdmin">Detail..</a>
                              
                            @else
                            @endif
                        </td>
                        <td class="text-center">
                            {{-- @if($p->status === "Diterima")
                            <a class="badge cetakSurat" href="{{ url('cetak-surat') }}" target="_blank">Cetak Surat</a> --}}
                            @if($p->status === "Baru")
                            <a class="badge batal" style="color: white !important" href="{{route('permohonan.dibatalkan',['id' => $p->id])}}">Batalkan</a>
                            @elseif($p->status === "Diatasan")
                            <a href="{{route('permohonan.dibatalkan',['id' => $p->id])}}" class="badge batal" style="color: white !important">Batalkan</a>
                            {{-- <a class="btn btn-action bg-purple mr-1" href="{{route('permohonan.dibatalkan',['id' => $p->id])}}" >Setuju</a>  --}}
                            @elseif($p->status === "Batal")
                            <div></div>
                            @else
                            <div></div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
    <!-- modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Form Tambah Data Karyawan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="" action="{{ route('permohonan.insert')}}" method="post" >
          @csrf
            <div class="form-group">
              <label>Alasan Cuti</label>
              <textarea class="form-control" name="alasan_cuti" required ></textarea>
            </div>
            <div class="form-group">
              <label>tanggal Mulai Cuti</label>
              <input type="text" name="tgl_mulai" required class="form-control datepicker">
            </div>
            <div class="form-group">
              <label>tanggal Berahir Cuti</label>
              <input type="text" name="tgl_akhir" required class="form-control datepicker">
            </div> 
            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ketTolakAdmin" tabindex="-1" role="dialog" aria-labelledby="formModal"
                            aria-hidden="true">
                            <div class=" modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="formModal">Alasan Ditolak</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-floating mb-3">
                                    <input type="texDaftar Riwayat Cutit" readonly class="form-control-plaintext" id="ketTolakAdminUser">
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>

  
</div>
@endsection