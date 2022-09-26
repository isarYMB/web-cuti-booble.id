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
            Edit Profil
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
          <div id="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <Form method="post" action="{{route('karyawan.updateUser')}}">
                @csrf
                    <div class="card">
                    <div class="card-header">
                        <h4>Profil</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                        <label>No Whatsapp</label>
                        <input type="hidden" class="form-control" name="id" value="{{Auth::user()->id}}">
                        <input type="number" class="form-control" name="no_telpon" value="{{Auth::user()->no_telpon}}">
                        </div>
                        <div class="form-group">
                          <label>Email</label>
                          <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                          </div>
                        <div class="form-group">
                          <label>Password</label>
                          <input type="password" class="form-control" name="password">
                        </div>
                        {{-- <div class="form-group">
                          <label>Konfirmasi Password</label>
                          <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" class="form-control" name="password_confirmation">
                          @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>Password yang dimasukkan tidak sama</strong>
                            </span>
                          @enderror
                        </div> --}}
                        {{-- <div class="form-group">
                          <label>Konfirmasi Password</label>
                          <input type="password" class="form-control" name="password_confirmation">
                        </div> --}}
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    </div>
                    </div>
                </Form>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection