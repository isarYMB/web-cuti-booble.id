{{-- @extends('layouts/index') --}}
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Booble.id - Admin Dashboard Template</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/jqvmap/dist/jqvmap.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/weather-icon/css/weather-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/weather-icon/css/weather-icons-wind.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/datatables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/bootstrap-daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/jquery-selectric/selectric.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('bundles/izitoast/css/iziToast.min.css')}}">
    
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/components.css')}}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet" type="text/css" >
    <link rel='shortcut icon' type='image/x-icon' href="{{asset('https://i.ibb.co/q5S0Gsp/LOGO-KOTAK-1.png')}}" />
    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>

        <!-- FullCalendar -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
        <script type="text/javascript">
          document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
              initialView: 'dayGridMonth',
              headerToolbar: {
                left: 'prev',
                center: 'title',
                right: 'next',
              },
              events: [
                @foreach($permohonanTerima as $c)
                {
                    title: "{{ $c->name }} ({{ $c->divisi }})", // a property!
                    start: "{{ $c->tgl_mulai }}", // a property!
                    end: "{{ \Carbon\Carbon::parse($c->tgl_akhir)->addDays(1) }}",
                    color: "{{ $c->warna_cuti }}",
                    allDay:true,
                },
                @endforeach
              ],
              editable: false
            });
            calendar.render();
          });
        </script>

  </head>
  <body>
    <div id="app">
      <div class="main-wrapper main-wrapper-1">
        <div class="main-sidebar sidebar-style-1 sidebar d-flex flex-column flex-shrink-0">
          <aside id="sidebar-wrapper">
              <ul class="sidebar-menu">
                  <li>
                      <a class="nav-link" href="#"> 
                          <img class="logo-name" src="{{ ('https://i.ibb.co/1XC1GTF/Logo2-2.png') }}" >
                      </a>
                  </li>
              </ul>
              
              <ul class="sidebar-menu">
                  <li>
                  <div class="sidebar-user-details nav-link">
                  <div class="logo-name user-name font-weight-bold">{{Auth::user()->name}}</div>
                  <div class="logo-name user-role">{{Auth::user()->role}}</div>
                  </li>
              </ul>
          <ul class="sidebar-menu">
              @if(Auth::user()->role === "karyawan")
                  <li>
                      <a class="nav-link" href="{{ route('karyawan.dashboard')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                          <span>Permohonan Cuti</span>
                      </a>
                  </li>
                  <li>
                      <a class="nav-link" href="{{ route('karyawan.editUser')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                          <span>Ubah Profil</span>
                      </a>
                  </li>
              @elseif(Auth::user()->role === "HRD")
                  <li>
                      <a class="nav-link" href="{{ route('admin.dashboard')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                          <span>Dashboard</span>
                      </a>
                  </li>
                  {{-- <li>
                      <a class="nav-link" href="{{ route('permohonan.index')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder-plus"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>
                          <span>Pengajuan Cuti</span>
                      </a>
                  </li> --}}
                  <li>
                      <a class="nav-link" href="{{ route('karyawan.dashboard')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                          <span>Buat Permohonan Cuti</span>
                      </a>
                  </li>
                  <li>
                      <a class="nav-link" href="{{ route('divisi.index')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                          <span>Master Divisi</span>
                      </a>
                  </li>
                  <li>
                      <a class="nav-link" href="{{ route('karyawan.index')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                          <span>Master Pegawai</span>
                      </a>
                  </li>
                  <li>
                      <a class="nav-link" href="{{ route('karyawan.editUser')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                          <span>Ubah Profil</span>
                      </a>
                  </li>
                  @elseif(Auth::user()->role === "Kepala Divisi")
                      <li>
                          <a class="nav-link" href="{{ route('kadivisi.dashboard')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                              <span>Dashboard</span>
                          </a>
                      </li>
                      <li>
                          <a class="nav-link" href="{{ route('permohonan.index')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                              <span>Pengajuan Cuti</span>
                          </a>
                      </li>
                      <li>
                          <a class="nav-link" href="{{ route('karyawan.dashboard')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                              <span>Buat Permohonan Cuti</span>
                          </a>
                      </li>
                      <li>
                          <a class="nav-link" href="{{ route('karyawan.editUser')}}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                              <span>Ubah Profil</span>
                          </a>
                      </li>
                  @elseif(Auth::user()->role === "Leader")
                  {{-- <li>
                      <a class="nav-link" href="{{ route('admin.dashboard')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                          <span>Dashboard</span>
                      </a>
                  </li> --}}
                  <li>
                      <a class="nav-link" href="{{ route('permohonan.index')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                          <span>Pengajuan Cuti</span>
                      </a>
                  </li>
                  {{-- <li>
                      <a class="nav-link" href="{{ route('divisi.index')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                          <span>Master Divisi</span>
                      </a>
                  </li> --}}
                  {{-- <li>
                      <a class="nav-link" href="{{ route('karyawan.index')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                          <span>Master Pegawai</span>
                      </a>
                  </li> --}}
                  <li>
                      <a class="nav-link" href="{{ route('karyawan.editUser')}}">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                          <span>Ubah Profil</span>
                      </a>
                  </li>
              @endif
              <li class="mobileSidebar">
                  <a class="nav-link" href="{{ route('logout')}}">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                      <span class="">Keluar</span>
                  </a>
              </li>     
          </ul>
          
          </aside>
        </div>
@if(Auth::user()->role === "Kepala Divisi")
{{-- @section('content') --}}
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
                        <th style="min-width: 100px;">Tgl Mohon</th>
                        <th>Nama Pegawai</th>
                        <th>Alasan Cuti</th>
                        <th style="min-width: 100px;">Mulai</th>
                        <th style="min-width: 100px;">Berakhir</th>
                        <th style="min-width: 100px;">Durasi</th>
                        <th class="text-center">#</th>
                    </tr>
                    @if($permohonan->isEmpty())
                        <tr>
                        <td colspan="8" class="p-0 text-center">Data Pengajuan Cuti Kosong</td>
                        </tr>
                    @else
                    @foreach($permohonan as $i => $p)
                    <tr>
                        <td class="p-0 text-center">{{$i+1}}</td>
                        <td class="align-middle text-center">{{$p->tgl_memohon}}</td>
                        <td class="font-weight-600">{{$p->name}}</td>
                        <td class="text-truncate">{{$p->alasan_cuti}}</td>
                        <td class="align-middle text-center">{{$p->tgl_mulai}}</td>
                        <td class="align-middle text-center">{{$p->tgl_akhir}}</td>
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
                    @endif
                </table>
                <br>
                        {{ $permohonan->links() }}
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
{{-- @endsection --}}


@elseif(Auth::user()->role === "Leader")
{{-- @section('content') --}}
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
                        <th style="min-width: 100px;">Tgl Mohon</th>
                        <th>Nama Pegawai</th>
                        <th>Alasan Cuti</th>
                        <th style="min-width: 100px;">Mulai</th>
                        <th style="min-width: 100px;">Berakhir</th>
                        <th>Durasi</th>
                        <th class="text-center">#</th>
                    </tr>
                    @if($permohonan->isEmpty())
                        <tr>
                        <td colspan="8" class="p-0 text-center">Data Pengajuan Cuti Kosong</td>
                        </tr>
                    @else
                    @foreach($permohonan as $i => $p)
                    <tr>
                        <td class="p-0 text-center">{{$i+1}}</td>
                        <td class="align-middle text-center">{{$p->tgl_memohon}}</td>
                        <td class="font-weight-600">{{$p->name}}</td>
                        <td class="text-truncate">{{$p->alasan_cuti}}</td>
                        <td class="align-middle text-center">{{$p->tgl_mulai}}</td>
                        <td class="align-middle text-center">{{$p->tgl_akhir}}</td>
                        <td class="font-weight-600 text-center">{{$p->durasi_cuti}}</td>
                        <td>
                            <a class="btn btn-action bg-purple mr-1" href="{{route('permohonan.setuju',['id' => $p->id])}}" >Setuju</a> 
                            {{-- <a data-id="{{$p->id}}" href="#" class="btn btn-danger btn-action" data-toggle="modal" data-target="#tolakModal" data-backdrop="false">Tolak</a> --}}
                            <a data-id="{{$p->id}}" class="btn btn-danger btn-action" data-toggle="modal" data-backdrop="true" href="#" data-target="#tolakModalLeader">Tolak</a>

                            
                            {{-- <a class="btn btn-danger btn-action" href="{{route('permohonan.tolak',['id' => $p->id])}}">Tolak</a> --}}
                            
                        </td>
                    </tr>

                    
                    @endforeach
                    @endif
                </table>
                <br>
                        {{ $permohonan->links() }}
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-12 col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
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

{{-- @endsection --}}
@endif
</div>
</div>
<!-- General JS Scripts -->
<script src="{{asset('js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('bundles/echart/echarts.js')}}"></script>
  <script src="{{asset('bundles/chartjs/chart.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('js/page/index.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{asset('js/scripts.js')}}"></script>
  
  <!-- myscript -->
  <!-- Custom JS File -->
  <script src="{{asset('js/custom.js')}}"></script>
  <script src="{{asset('bundles/cleave-js/dist/cleave.min.js')}}"></script>
  <script src="{{asset('bundles/cleave-js/dist/addons/cleave-phone.us.js')}}"></script>
  <script src="{{asset('bundles/jquery-pwstrength/jquery.pwstrength.min.js')}}"></script>
  <script src="{{asset('bundles/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
  <script src="{{asset('bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
  <script src="{{asset('bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
  <script src="{{asset('bundles/select2/dist/js/select2.full.min.js')}}"></script>
  <script src="{{asset('bundles/jquery-selectric/jquery.selectric.min.js')}}"></script>
  

  <script src="{{asset('js/page/forms-advanced-forms.js')}}"></script>
  <script src="{{asset('bundles/izitoast/js/iziToast.min.js')}}"></script>

  <script>
    $('#tolakModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);

    var recipient = button.data('id') // Target data-id
    console.log(recipient); // Here you can see the data-id value from a element
    var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)
    // modal.find('.modal-body input').val(recipient)
    modal.find('#userTolak').val(recipient); // set input value
})
</script>

<script>
  $('#tolakModalAdmin').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);

  var recipient = button.data('id') // Target data-id
  console.log(recipient); // Here you can see the data-id value from a element
  var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
  // modal.find('.modal-body input').val(recipient)
  modal.find('#userTolakAdmin').val(recipient); // set input value
})
</script>

<script>
  $('#ketTolakAdmin').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);

  var recipient = button.data('id') // Target data-id
  console.log(recipient); // Here you can see the data-id value from a element
  var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
  // modal.find('.modal-body input').val(recipient)
  modal.find('#ketTolakAdminUser').val(recipient); // set input value
})
</script>

<script>
  $('#tolakModalLeader').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);

  var recipient = button.data('id') // Target data-id
  console.log(recipient); // Here you can see the data-id value from a element
  var modal = $(this)
  // modal.find('.modal-title').text('New message to ' + recipient)
  // modal.find('.modal-body input').val(recipient)
  modal.find('#tolakModalLeaderUser').val(recipient); // set input value
})
</script>

<script type="text/javascript">
  // Daterangepicker
  jQuery(function($) {
  var someDate = new Date();
  someDate.setDate(someDate.getDate() + 14); //number  of days to add, e.x. 15 days
  var dateFormated = someDate.toISOString().substr(0,10);  

  if (jQuery().daterangepicker) {
    if ($(".datepicker").length) {
      $(".datepicker").daterangepicker({
        locale: { format: "YYYY-MM-DD" },
        singleDatePicker: true,
        minDate: dateFormated,
        isInvalidDate: function(date) {
            var dateRanges = [
                { 'start': moment('2022-10-10'), 'end': moment('2022-10-10') },
                // { 'start': moment('2022-10-25'), 'end': moment('2022-10-30') },
            ];
            return dateRanges.reduce(function(bool, range) {
                return bool || (date >= range.start && date <= range.end || date.day() == 0);
            }, false);
        }
        // isInvalidDate: function(date) {
        //   if (date.day() == 0) {
        //     return true;
        // } else {
        //     return false;
        // }
        // }
      });
    }
  }
});
</script>


  <script>
  
  $(document).ready(function() {
    const flashData = $("#flash-data").data('flashdata');
    console.log('flash-data',flashData);
    // if(flashData === "Maaf sisa cuti anda sudah habis"){
        
    //     iziToast.error({
    //         title: 'Error!',
    //         message: flashData,
    //         position: 'topRight'
    //     });

    // }
    if(flashData){
        iziToast.success({
            title: 'Success !!',
            message: flashData,
            position: 'topRight'
        });
    }
  });
  
  </script>
</body>


<!-- Mirrored from radixtouch.com/templates/admin/aegis/source/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Jul 2021 09:55:44 GMT -->
</html>