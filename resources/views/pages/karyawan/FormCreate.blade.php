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
                Tambah Karyawan
            </ul>
        </div>
    </nav>
    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <Form method="POST" action="{{ route('karyawan.store') }}">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Karyawan</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama Pegawai</label>
                                        <input type="text" class="@error('name') is-invalid @enderror form-control"
                                            name="name" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Masukan Inputan Nama dengan Benar</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="number" class="@error('nik') is-invalid @enderror form-control"
                                            name="nik" value="{{ old('nik') }}">
                                        @error('nik')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Inputkan NIK dengan 16 angka</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Divisi</label>
                                        <select name="divisi" class="custom-select">
                                            @foreach ($divisi as $row)
                                                <option value="{{ $row->nama_divisi }}"
                                                    {{ old('divisi') == $row->nama_divisi ? 'selected' : '' }}>
                                                    {{ $row->nama_divisi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select name="jabatan" class="custom-select">
                                            @foreach ($jabatan as $row)
                                                <option value="{{ $row->nama_jabatan }}"
                                                    {{ old('jabatan') == $row->nama_jabatan ? 'selected' : '' }}>
                                                    {{ $row->nama_jabatan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>No Whatsapp</label>
                                        <input type="number" value="{{ old('no_telpon') }}"
                                            class="@error('no_telpon') is-invalid @enderror form-control" name="no_telpon">
                                        @error('no_telpon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Inputan nomor Whatsapp minimal 12 sampai 13 angka</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah Cuti</label>
                                        <input type="text"
                                            class="@error('jumlah_cuti') is-invalid @enderror  form-control"
                                            name="jumlah_cuti" value="{{ old('jumlah_cuti') }}">
                                        @error('jumlah_cuti')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Inputan cuti minimal 1 sampai 2 angka</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" class="custom-select">
                                            @foreach ($role as $row)
                                                <option value="{{ $row->nama_role }}"
                                                    {{ old('role') == $row->nama_role ? 'selected' : '' }}>
                                                    {{ $row->nama_role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="@error('email') is-invalid @enderror form-control"
                                            name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>Masukan Inputan Email dengan Benar</strong>
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
