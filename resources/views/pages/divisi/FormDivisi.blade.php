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
            Edit Karyawan
          </ul>
          
        </div>
        {{-- <ul class="navbar-nav navbar-right">
          <a href="{{route('logout')}}" class="dropdown-item text-danger"> <i class="fas fa-sign-out-alt"></i>
            Logout
          </a>
        </ul> --}}
      </nav>
<div class="main-content" style="min-height: 562px;">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <Form method="POST" action="{{route('karyawan.create')}}">
                @csrf
                @foreach ($karyawan as $k)
                    <div class="card">
                    <div class="card-header">
                        <h4>Form Karyawan</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                        <label>Nama Pegawai</label>
                        {{-- <input type="hidden" class="form-control" name="id" value="{{$k->id}}"> --}}
                        <input type="text" class="form-control" name="name" value="{{$k->name}}">
                        </div>
                        <div class="form-group">
                        <label>NIK</label>
                        <input type="text" class="form-control" name="nik" value="{{$k->nik}}">
                        </div>
                        <div class="form-group">
                        <label>No Whatsapp</label>
                        <input type="text" class="form-control" name="no_telpon" value="{{$k->no_telpon}}">
                        </div>
                        <div class="form-group">
                          <label>Password</label>
                          <input type="text" class="form-control" name="password">
                        </div>
                        {{-- <div class="form-group">
                        <label>Jumlah Cuti</label>
                        <input type="text" class="form-control" name="jumlah_cuti" value="{{$k->jumlah_cuti}}">
                        </div> --}}
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    </div>
                    </div>
                @endforeach
                </Form>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection