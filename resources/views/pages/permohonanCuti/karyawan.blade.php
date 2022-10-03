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
                Pengajuan Cuti
            </ul>

        </div>
    </nav>
    <div class="main-content">
        <section class="section">
            @if (Session::get('error'))
                <div class="row">
                    <div class="col-12 col-sm-12 col-lg-12">
                        <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert">
                                    <span>×</span>
                                </button>
                                {{ Session::get('error') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div id="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Pengajuan Cuti</h4>
                        </div>
                        <div class="ml-4 mt-3">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Buat Pengajuan
                                Cuti</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped" id="table-1">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Alasan Cuti</th>
                                        <th style="min-width: 100px;">Mulai</th>
                                        <th style="min-width: 100px;">Berakhir</th>
                                        <th>Status</th>
                                    </tr>
                                    @foreach ($permohonan as $i => $p)
                                        <tr>
                                            <td class="p-0 text-center">{{ $i + 1 }}</td>
                                            <td class="text-truncate">{{ $p->alasan_cuti }}</td>
                                            <td class="align-middle text-center">{{ $p->tgl_mulai }}</td>
                                            <td class="align-middle text-center">{{ $p->tgl_akhir }}</td>
                                            <td class="align-middle"><span
                                                    class="badge badge-warning">{{ $p->status }}</span></td>
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
                        <form class="" action="{{ route('permohonan.insert') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Alasan Cuti</label>
                                <textarea class="form-control" name="alasan_cuti" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Mulai Cuti</label>
                                <input type="text" name="tgl_mulai" required class="form-control datepicker">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Berahir Cuti</label>
                                <input type="text" name="tgl_akhir" required class="form-control datepicker">
                            </div>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
