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
                Dashboard
            </ul>

        </div>
    </nav>
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div id="flash-data" data-flashdata="{{ Session::get('success') }}"></div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Riwayat Pengajuan Cuti Ditolak</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped" id="table-1">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Alasan Cuti</th>
                                        <th>Mulai</th>
                                        <th>Berakhir</th>
                                        <th>Status</th>
                                    </tr>
                                    @foreach ($permohonan as $i => $p)
                                        <tr>
                                            <td class="p-0 text-center">{{ $i + 1 }}</td>
                                            <td class="font-weight-600">{{ $p->name }}</td>
                                            <td class="text-truncate">{{ $p->alasan_cuti }}</td>
                                            <td class="align-middle">{{ $p->tgl_mulai }}</td>
                                            <td class="align-middle">{{ $p->tgl_akhir }}</td>
                                            <td class="align-middle"><span
                                                    class="badge badge-danger">{{ $p->status }}</span></td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
