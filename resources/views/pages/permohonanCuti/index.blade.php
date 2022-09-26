@extends('layouts/index')

@if(Auth::user()->role === "Staf HR")
@section('content')
<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn text-dark mr-3"> <i data-feather="align-justify"></i></a></li>
            {{-- <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li> --}}
              
            
          </ul>

          <ul class="navbar-nav font-weight-bold h6">
            Pengajuan Cuti
          </ul>
          
        </div>
        {{-- <ul class="navbar-nav navbar-right">
          <a href="{{route('logout')}}" class="dropdown-item text-danger"> <i class="fas fa-sign-out-alt"></i>
            Logout
          </a>
        </ul> --}}
      </nav>

<div class="main-content">
    <section class="section">
        <div class="row">
        <div class="col-12 col-sm-12 col-lg-12">
            <div id="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
            <div class="card">
            <div class="card-header">
                <h4>Data Pengajuan Cuti</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive table-invoice">
                <table class="table table-striped" id="table-1">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Tanggal Mohon</th>
                        <th>Nama Pegawai</th>
                        <th>Alasan Cuti</th>
                        <th>Mulai Cuti</th>
                        <th>Berakhir Cuti</th>
                        <th>Durasi Cuti</th>
                        <th class="text-center">#</th>
                    </tr>
                    @foreach($permohonan as $i => $p)
                    <tr>
                        <td class="p-0 text-center">{{$i+1}}</td>
                        <td class="align-middle">{{$p->tgl_memohon}}</td>
                        <td class="font-weight-600">{{$p->name}}</td>
                        <td class="text-truncate">{{$p->alasan_cuti}}</td>
                        <td class="align-middle">{{$p->tgl_mulai}}</td>
                        <td class="align-middle">{{$p->tgl_akhir}}</td>
                        <td class="font-weight-600 text-center">{{$p->durasi_cuti}}</td>
                        @if($p->status === "Baru")
                        <td class="text-center">
                            <a class="badge batal" href="{{route('permohonan.dikirim',['id' => $p->id])}}" >Kirim</a> 
                            <a data-id="{{$p->id}}" style="color: white !important" class="badge ditolak" data-toggle="modal" data-backdrop="true" href="#" data-target="#tolakModalLeader">Tolak</a>
                            
                        </td>
                        @elseif($p->status === "Diatasan")
                        <td class="text-center">
                            <a class="badge cetakSurat" >Menunggu Persetujuan</a> 
                        </td>
                        @endif
                        
                    </tr>
                    
                    <!-- modal -->
                    {{-- <div class="modal fade" id="tolakModalAdmin" tabindex="-1" role="dialog" aria-labelledby="formModal"
                    aria-hidden="true">
                    <div class="modal-dialog-centered modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="formModal">Masukan Alasan Penolakan</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            
                            <form class="" action="{{route('permohonan.tolak')}}" method="post" >
                            
                            @csrf
                                <div class="form-group">
                                <label>Alasan Penolakan Cuti</label>
                                <textarea class="form-control" name="ket_tolak" required ></textarea>
                                </div>
                                <div class="form-group">
                                  <input type="hidden" id="userTolakAdmin" name="custId">
                                </div>
                                <button type="submit" class="btn btn-danger m-t-15 waves-effect">Tolak</button> --}}
                            {{-- <a type="submit" class="btn btn-danger btn-action" href=""></a> --}}
                            
                        {{-- </form>
                        
                        
                        </div>
                      </div>
                    </div>
                  </div> --}}

                    @endforeach
                </table>
                </div>
            </div>
            </div>
        </div>
        </div>
    </section>
    <!-- modal -->
    <div class="modal fade" id="tolakModalLeader" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Masukan Alasan Penolakan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" action="{{route('permohonan.tolak')}}" method="post" >
            
            @csrf
                <div class="form-group">
                <label>Alasan Penolakan Cuti</label>
                <textarea class="form-control" name="ket_tolak" required ></textarea>
                </div>
                <div class="form-group">
                  <input type="hidden" id="tolakModalLeaderUser" name="custId">
                </div>
                <button type="submit" class="btn btn-danger m-t-15 waves-effect">Tolak</button>
            {{-- <a type="submit" class="btn btn-danger btn-action" href=""></a> --}}
            
        </form>
        
        
        </div>
      </div>
    </div>
  </div>
</div>

@elseif(Auth::user()->role === "Leader")
@section('content')
<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn text-dark mr-3"> <i data-feather="align-justify"></i></a></li>
            {{-- <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li> --}}
              
            
          </ul>

          <ul class="navbar-nav font-weight-bold h6">
            Riwayat Cuti
          </ul>
          
        </div>
        {{-- <ul class="navbar-nav navbar-right">
          <a href="{{route('logout')}}" class="dropdown-item text-danger"> <i class="fas fa-sign-out-alt"></i>
            Logout
          </a>
        </ul> --}}
      </nav>
<div class="main-content">
    <section class="section">
        <div class="row">
        <div class="col-12 col-sm-12 col-lg-12">
            <div id="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
            <div class="card">
            <div class="card-header">
                <h4>Permohonan Cuti yang Masuk</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive table-invoice">
                <table class="table table-striped" id="table-1">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Tanggal Mohon</th>
                        <th>Nama Pegawai</th>
                        <th>Alasan Cuti</th>
                        <th>Mulai Cuti</th>
                        <th>Berakhir Cuti</th>
                        <th>Durasi Cuti</th>
                        <th class="text-center">#</th>
                    </tr>
                    @foreach($permohonan as $i => $p)
                    <tr>
                        <td class="p-0 text-center">{{$i+1}}</td>
                        <td class="align-middle">{{$p->tgl_memohon}}</td>
                        <td class="font-weight-600">{{$p->name}}</td>
                        <td class="text-truncate">{{$p->alasan_cuti}}</td>
                        <td class="align-middle">{{$p->tgl_mulai}}</td>
                        <td class="align-middle">{{$p->tgl_akhir}}</td>
                        <td class="font-weight-600 text-center">{{$p->durasi_cuti}}</td>
                        <td>
                            <a class="btn btn-action bg-purple mr-1" href="{{route('permohonan.setuju',['id' => $p->id])}}" >Setuju</a> 
                            {{-- <a data-id="{{$p->id}}" href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#tolakModal" data-backdrop="false">Tolak</a> --}}
                            <a data-id="{{$p->id}}" class="btn btn-danger btn-action" data-toggle="modal" data-backdrop="true" href="#" data-target="#tolakModalLeader">Tolak</a>

                            
                            {{-- <a class="btn btn-danger btn-action" href="{{route('permohonan.tolak',['id' => $p->id])}}">Tolak</a> --}}
                            
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
    <div class="modal fade" id="tolakModalLeader" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="formModal">Masukan Alasan Penolakan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" action="{{route('permohonan.tolak')}}" method="post" >
            
            @csrf
                <div class="form-group">
                <label>Alasan Penolakan Cuti</label>
                <textarea class="form-control" name="ket_tolak" required ></textarea>
                </div>
                <div class="form-group">
                  <input type="hidden" id="tolakModalLeaderUser" name="custId">
                </div>
                <button type="submit" class="btn btn-danger m-t-15 waves-effect">Tolak</button>
            {{-- <a type="submit" class="btn btn-danger btn-action" href=""></a> --}}
            
        </form>
        
        
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endsection