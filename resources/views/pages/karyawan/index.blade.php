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
                Master Pegawai
            </ul>

        </div>
    </nav>
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div id="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
                    <div class="card">
                        <div class="d-flex justify-content-end">
                            <div class="card-footer text-right">
                                <a class="btn btn-warning mr-1" href="{{ route('karyawan.create') }}">
                                    <i class="fa fa-plus"></i> Tambah
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped" id="table-1">
                                    <tr>
                                        <th class="text-center">No</th>
                                        {{-- <th>Email</th> --}}
                                        <th>Nama Pegawai</th>
                                        <th>NIK</th>
                                        <th>Divisi</th>
                                        <th>Jabatan</th>
                                        <th>Role</th>
                                        <th>No Telpon</th>
                                        <th style="min-width: 100px;">Sisa Cuti</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                    @foreach ($karyawan as $i => $k)
                                        <tr>
                                            <td class="p-0 text-center">{{ $i + 1 }}</td>
                                            <td class="font-weight-600">{{ $k->name }}</td>
                                            <td class="align-middle">{{ $k->nik }}</td>
                                            <td class="font-weight-600">{{ $k->divisi }}</td>
                                            <td class="font-weight-600">{{ $k->jabatan }}</td>
                                            <td class="font-weight-600">{{ $k->role }}</td>
                                            <td class="align-middle">{{ $k->no_telpon }}</td>
                                            <td class="align-middle">{{ $k->jumlah_cuti }} Hari</td>
                                            <td class="text-center" style="min-width: 100px;">
                                                <a class="hoverEdit" href="{{ route('karyawan.edit', ['id' => $k->id]) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit">
                                                        <path
                                                            d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                        </path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                        </path>
                                                    </svg>
                                                </a>

                                                {{-- <a data-id="{{ $p->id }}" style="color: white !important"
                                                    class="badge batal" data-toggle="modal" data-backdrop="true"
                                                    href="#" data-target="#setujuiKaryawan">Setujui</a>
                                                href="{{ route('karyawan.destroy', ['id' => $k->user_id]) }}" --}}

                                                <a class="hoverHapus" data-id="{{ $k->id }}"
                                                    data-target="#hapusUser" data-toggle="modal" data-backdrop="true"
                                                    href="#">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-trash-2">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17">
                                                        </line>
                                                        <line x1="14" y1="11" x2="14" y2="17">
                                                        </line>
                                                    </svg>
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

        <!-- modal hapus -->
        <div class="modal fade" id="hapusUser" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
            <div class="modal-dialog-centered modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModal">Anda Yakin Menghapus User Ini?
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="" action="{{ route('karyawan.destroy') }}" method="get">
                            @csrf
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block btn-danger m-t-15 waves-effect">Hapus</button>
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="hapusUserModal" name="custId">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                        <form class="">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="nama">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>No Telpon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="no_telpon">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Cuti</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="jumlah_cuti">
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary m-t-15 waves-effect">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
