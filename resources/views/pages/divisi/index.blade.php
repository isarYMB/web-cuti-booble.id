@extends('layouts/index')

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
            Master Divisi
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
            {{-- <div class="card-header">
                <div class="card-header">
                    <h4>Master Pegawai</h4>
                </div>
                
            </div> --}}
            <div class="d-flex justify-content-end">
                <div class="card-footer text-right">
                    <tr>
                        <th><button data-backdrop="true"  data-toggle="modal" href="#" data-target="#exampleModal1" class="btn btn-warning mr-1" type="submit"><i class="fa fa-plus"></i> Divisi</button>

                            
                        </th>
                        <th><button data-backdrop="true"  data-toggle="modal" href="#" data-target="#exampleModal2" class="btn btn-warning mr-1" type="submit"><i class="fa fa-plus"></i> Jabatan</button>

                            
                        </th>
                    </tr>

                    <tr>
                    </tr>
                    
                </div>           
            </div>
            <div class="card-body">
                <div class="table-responsive table-invoice">
                <table class="table table-striped" id="table-1">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Divisi</th>
                        <th>Jabatan</th>
                        <th class="text-center">#</th>
                    </tr>
                    @foreach($divisi as $i => $k)
                        <tr>
                            <td class="p-0 text-center">{{$i+1}}</td>
                            <td class="font-weight-600">{{$k->nama_divisi}}</td>
                            <td class="font-weight-600">{{$k->nama_jabatan}}</td>
                            <td class="text-center"> 
                                {{-- <a style="color: #69707A" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a> --}}

                                <a style="color: #69707A" href="{{route('jabatan.destroy',['id' => $k->id])}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>    
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
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="formModal">Tambah Divisi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            
            <form class="" action="{{route('divisi.store')}}" method="get" >
            @csrf
            <div class="form-group">
                <label>Nama Divisi</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-address-card"></i>
                    </div>
                    </div>
                    <input type="text" class="form-control" name="nama_divisi">
                </div>
                </div>
                <button type="submit" class="btn btn-warning m-t-15 waves-effect">Tambahkan</button>
        </form>
        </div>
    </div>
    </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog-centered modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="formModal">Tambah Jabatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form class="" action="{{route('jabatan.store')}}" method="get" >
            @csrf
                
                <div class="form-group">
                    <label>Divisi Jabatan</label>
                    <select name="id_divisi" class="custom-select">
                    @foreach($divisiAll as $row)
                        <option value="{{$row->id}}">{{$row->nama_divisi}}</option>
                    @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-id-badge"></i>
                        </div>
                        </div>
                        <input type="text" class="form-control"  name="nama_jabatan">
                    </div>
                    </div>
                <button type="submit" class="btn btn-warning m-t-15 waves-effect">Tambahkan</button>
        </form>
        
        
        </div>
    </div>
    </div>
    </div>
    
</div>
@endsection

