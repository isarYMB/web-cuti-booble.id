@extends('layouts/index')

@section('content')
    <div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
            <ul class="navbar-nav">
                <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn text-dark mr-3">
                        <i data-feather="align-justify"></i></a></li>
            </ul>

            <ul class="navbar-nav font-weight-bold h6">
                Edit Profil
            </ul>

        </div>
    </nav>
    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div id="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <Form method="post" action="{{ route('karyawan.updateUser') }}">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Profil</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>No Whatsapp</label>
                                        <input type="hidden" class="form-control" name="id"
                                            value="{{ Auth::user()->id }}">
                                        <input type="number" class="form-control @error('no_telpon') is-invalid @enderror"
                                            name="no_telpon" value="{{ Auth::user()->no_telpon }}">
                                        @error('no_telpon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Inputan nomor telepon minimal 12 sampai 13 angka</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ Auth::user()->email }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Input email dengan benar</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Inputan password minimal 6 karakter</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Konfirmasi Password</label>
                                        <input class="form-control @error('password') is-invalid @enderror" type="password"
                                            class="form-control" name="password_confirmation">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Password yang dimasukkan tidak sama</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div id='loader'></div>
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
