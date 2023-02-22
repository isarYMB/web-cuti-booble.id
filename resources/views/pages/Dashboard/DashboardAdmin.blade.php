<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Web Cuti Booble.id</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('bundles/izitoast/css/iziToast.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link href="{{ asset('css/mobile.css') }}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/booble.ico') }}">

    <style>
        .resizeformc {
            width: 150px;
            height: 200px;
        }
    </style>

    <script>
        $(document).ready(function() {
            const flashData = $("#flash-data").data('flashdata');
            console.log('flash-data', flashData);
            // if(flashData === "Maaf sisa cuti anda sudah habis"){

            //     iziToast.error({
            //         title: 'Error!',
            //         message: flashData,
            //         position: 'topRight'
            //     });

            // }
            if (flashData) {
                iziToast.success({
                    title: 'Success !!',
                    message: flashData,
                    position: 'topRight'
                });
            }
        });
    </script>


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
                    @foreach ($permohonanTerima as $c)
                        {
                            title: "{{ $c->name }} ({{ $c->divisi }})", // a property!
                            start: "{{ $c->tgl_mulai }}", // a property!
                            end: "{{ \Carbon\Carbon::parse($c->tgl_akhir)->addDays(1) }}",
                            color: "{{ $c->warna_cuti }}",
                            allDay: true,
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
                                <img class="logo-name" src="{{ 'http://simpanfile.sisiadmin.skom.id/Logo2-2.png' }}">
                            </a>
                        </li>
                    </ul>

                    <ul class="sidebar-menu">
                        <li>
                            <div class="sidebar-user-details nav-link">
                                <div class="logo-name user-name font-weight-bold">{{ Auth::user()->name }}</div>
                                <div class="logo-name user-role">{{ Auth::user()->role }}</div>
                        </li>
                    </ul>
                    <ul class="sidebar-menu">
                        @if (Auth::user()->role === 'HRD')
                            <li>
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor">
                                        <rect x="2" y="3" width="20" height="14" rx="2"
                                            ry="2"></rect>
                                        <line x1="8" y1="21" x2="16" y2="21"></line>
                                        <line x1="12" y1="17" x2="12" y2="21"></line>
                                    </svg>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('karyawan.dashboard') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-plus-square">
                                        <rect x="3" y="3" width="18" height="18"
                                            rx="2" ry="2"></rect>
                                        <line x1="12" y1="8" x2="12" y2="16"></line>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                    <span>Buat Permohonan Cuti</span>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('divisi.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-airplay">
                                        <path
                                            d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                                        </path>
                                        <polygon points="12 15 17 21 7 21 12 15"></polygon>
                                    </svg>
                                    <span>Master Divisi</span>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('karyawan.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    <span>Master Pegawai</span>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('karyawan.editUser') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span>Ubah Profil</span>
                                </a>
                            </li>
                        @elseif(Auth::user()->role === 'Direktur')
                            <li>
                                <a class="nav-link" href="{{ route('permohonan.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-list">
                                        <line x1="8" y1="6" x2="21" y2="6"></line>
                                        <line x1="8" y1="12" x2="21" y2="12"></line>
                                        <line x1="8" y1="18" x2="21" y2="18"></line>
                                        <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                        <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                        <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                    </svg>
                                    <span>Pengajuan Cuti</span>
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('karyawan.editUser') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <span>Ubah Profil</span>
                                </a>
                            </li>
                        @endif
                        <li class="mobileSidebar">
                            <a class="nav-link" href="{{ route('logout') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="">Keluar</span>
                            </a>
                        </li>
                    </ul>

                </aside>
            </div>
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav">
                        <li><a href="#" data-toggle="sidebar"
                                class="nav-link nav-link-lg
			collapse-btn text-dark mr-3"> <i
                                    data-feather="align-justify"></i></a></li>
                    </ul>

                    <ul class="navbar-nav font-weight-bold h6">
                        Dashboard
                    </ul>

                </div>
            </nav>
            <div class="main-content">
                <section class="section">
                    <div class="row ">
                        <div class="col">
                            <div class="card l-bg-purple-dark">
                                <div class="card-statistic-3">
                                    <div class="card-icon card-icon-large"><i class="fa fa-spinner"></i></div>
                                    <div class="card-content">
                                        <h4 class="card-title">Diproses</h4>
                                        <span>{{ $jmlTotalPengajuan }} Pengajuan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card l-bg-green-dark">
                                <div class="card-statistic-3">
                                    <div class="card-icon card-icon-large"><i class="fa fa-check"></i></div>
                                    <div class="card-content">
                                        <h4 class="card-title">Diterima</h4>
                                        <span>{{ $jmlPermohonanDisetujui }} Diterima</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card l-bg-orange-dark">
                                <div class="card-statistic-3">
                                    <div class="card-icon card-icon-large"><i class="fa fa-times"></i></div>
                                    <div class="card-content">
                                        <h4 class="card-title">Ditolak</h4>
                                        <span>{{ $jmlPermohonanDitolak }} Ditolak</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card l-bg-cyan-dark">
                                <div class="card-statistic-3">
                                    <div class="card-icon card-icon-large"><i class="fa fa-fire"></i></div>
                                    <div class="card-content">
                                        <h4 class="card-title">Dibatalkan</h4>
                                        <span>{{ $jmlBatal }} Dibatalkan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-lg-12">
                            @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-header">
                                        <h4>Riwayat Cuti</h4>
                                    </div>

                                    <tr>

                                        <th class="d-flex p-2 bd-highlight">
                                            <Form method="get" action="{{ route('admin.changeStatusBaru') }}">
                                                @csrf
                                                <select
                                                    style=" margin-left: 10px; margin-bottom: 10px;  height: 40px; width:190px; "
                                                    name="namaStatus"
                                                    class="custom-select resizeformc form-control rounded-3"
                                                    onchange='this.form.submit()'>
                                                    <option value="Semua"
                                                        {{ request()->input('namaStatus') == 'Semua' ? 'selected' : '' }}>
                                                        Semua
                                                        Status</option>
                                                    <option value="Di Ka.Divisi"
                                                        {{ request()->input('namaStatus') == 'Di Ka.Divisi' ? 'selected' : '' }}>
                                                        Di Ka.Divisi</option>
                                                    <option value="Diterima"
                                                        {{ request()->input('namaStatus') == 'Diterima' ? 'selected' : '' }}>
                                                        Diterima</option>
                                                    <option value="Di Direktur"
                                                        {{ request()->input('namaStatus') == 'Di Direktur' ? 'selected' : '' }}>
                                                        Di Direktur</option>
                                                    <option value="Dibatalkan"
                                                        {{ request()->input('namaStatus') == 'Dibatalkan' ? 'selected' : '' }}>
                                                        Dibatalkan</option>
                                                    <option value="Ditolak"
                                                        {{ request()->input('namaStatus') == 'Ditolak' ? 'selected' : '' }}>
                                                        Ditolak</option>
                                                </select>
                                            </Form>
                                            </center>
                                        </th>

                                        <th class="ml-4 mt-3 text-right">
                                            <Form method="get" action="{{ route('admin.searchNameAdmin') }}">
                                                @csrf
                                                <input
                                                    style="font-size: 15px; margin-left: 10px; margin-bottom: 5px; height: 40px; width:190px; "
                                                    class="form-control" type="search"
                                                    placeholder="Cari Nama Karyawan" name="searchName"
                                                    value="{{ request()->input('searchName') }}">
                                            </Form>
                                        </th>
                                        <th class="ml-4 mt-3 form-inline">
                                            <form id="filterDate" class=""
                                                style="margin-left: 10px; margin-bottom: 5px;"
                                                action="{{ route('admin.filterDateReport') }}" method="get">
                                                @csrf
                                                <input type="text" style="height: 40px; width:190px;"
                                                    name="daterange" required class="form-control datepicker"
                                                    id="book_date" value="{{ request()->input('daterange') }}">
                                            </form>
                                        </th>
                                        <th class=" form-inline">
                                            <form class="" style="margin-left: 5px; margin-bottom: 10px;"
                                                action="{{ route('permohonan.laporanCuti') }}" method="get">
                                                @csrf
                                                <input type="hidden" class="form-control" name="dateRangeReport"
                                                    id="data_laporan" value="{{ request()->input('daterange') }}">
                                                <button formtarget="_blank" type="submit"
                                                    style="height: 40px; margin-left: 5px; width:70px;"
                                                    class="btn ml-2 btn-warning m-t-15 waves-effect">Cetak</button>
                                            </form>
                                        </th>
                                    </tr>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-invoice">
                                        <table class="table table-striped" id="table_id">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center" style="min-width: 100px;">Tgl Memohon</th>
                                                <th class="text-center" style="min-width: 100px;">Nama Pegawai</th>
                                                <th class="text-center" style="min-width: 100px;">Alasan Cuti</th>
                                                <th class="text-center" style="min-width: 100px;">Mulai</th>
                                                <th class="text-center" style="min-width: 100px;">Berakhir</th>
                                                <th class="text-center">Durasi</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Hapus</th>
                                            </tr>
                                            @if ($permohonan->isEmpty())
                                                <tr>
                                                    <td colspan="8" class="p-0 text-center">Data Pengajuan Cuti
                                                        Kosong</td>
                                                </tr>
                                            @else
                                                @foreach ($permohonan as $i => $p)
                                                    <tr>
                                                        <td class="p-0 text-center">{{ $i + 1 }}</td>
                                                        <td class="align-middle text-center">{{ $p->tgl_memohon }}
                                                        </td>
                                                        <td class="font-weight-600">{{ $p->name }}</td>
                                                        <td class="text-truncate">{{ $p->alasan_cuti }}</td>
                                                        <td class="align-middle text-center">{{ $p->tgl_mulai }}</td>
                                                        <td class="align-middle text-center">{{ $p->tgl_akhir }}</td>
                                                        <td class="font-weight-600 text-center">{{ $p->durasi_cuti }}
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            @if ($p->status === 'Di Ka.Divisi')
                                                                <span class="badge baru">Diproses</span>
                                                            @elseif($p->status === 'Diterima')
                                                                <span
                                                                    class="badge diterima">{{ $p->status }}</span>
                                                            @elseif($p->status === 'Di Direktur')
                                                                <span class="badge diatasan">Diproses</span>
                                                            @elseif($p->status === 'Dibatalkan')
                                                                <span class="badge batal">{{ $p->status }}</span>
                                                            @elseif($p->status === 'Ditolak')
                                                                <span class="badge ditolak">{{ $p->status }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($p->status === 'Diterima')
                                                                <form class=""
                                                                    action="{{ route('dataSurat.cuti') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" class="form-control"
                                                                        name="custId" value="{{ $p->id }}">
                                                                    <input type="hidden" class="form-control"
                                                                        name="divisiKaryawan"
                                                                        value="{{ $p->divisi }}">
                                                                    <input type="hidden" class="form-control"
                                                                        name="roleKaryawan"
                                                                        value="{{ $p->role }}">
                                                                    <button formtarget="_blank" type="submit"
                                                                        class="badge cetakSurat">Cetak Surat</button>
                                                                </form>
                                                            @elseif($p->status === 'Ditolak')
                                                                <a data-id="{{ $p->ket_tolak }}" class="badge detail"
                                                                    data-toggle="modal" data-backdrop="true"
                                                                    href="#"
                                                                    data-target="#ketTolakAdmin">Detail..</a>
                                                            @else
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="min-width: 100px;">
                                                            <a class="hoverHapus" data-id="{{ $p->id }}"
                                                                data-target="#hapusPengajuan" data-toggle="modal"
                                                                data-backdrop="true" href="#">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash-2">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path
                                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                    </path>
                                                                    <line x1="10" y1="11"
                                                                        x2="10" y2="17">
                                                                    </line>
                                                                    <line x1="14" y1="11"
                                                                        x2="14" y2="17">
                                                                    </line>
                                                                </svg>
                                                            </a>
                                                        </td>
                                    </div>
                                    </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    </table>
                                    <br>
                                    {{ $permohonan->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-lg-12">
                        <div class="card">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div id="calendar"></div>
                                </li>
                                <li class="list-group-item">
                                    <div style="vertical-align: middle; font-weight: bold;">Keterangan : </div>
                                    <ul style="list-style: none;">
                                        <li style="margin-left: -40px">
                                            <div style="background-color: #929090;"
                                                class="rectangleKeteranganFirst square">
                                            </div>
                                            <span style="vertical-align: middle;">Pengajuan di Kepala Divisi</span>
                                        </li>
                                        <li style="margin-left: -40px">
                                            <div style="background-color: #6900c7;"
                                                class="rectangleKeteranganFirst square">
                                            </div>
                                            <span style="vertical-align: middle;">Pengajuan di Direktur</span>
                                        </li>
                                        <li style="margin-left: -40px">
                                            <div style="background-color: #00ac69;"
                                                class="rectangleKeteranganFirst square">
                                            </div>
                                            <span style="vertical-align: middle;">Pengajuan Disetujui</span>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    </div>

                </section>

                <!-- modal hapus -->
                <div class="modal fade" id="hapusPengajuan" tabindex="-1" role="dialog"
                    aria-labelledby="formModal" aria-hidden="true">
                    <div class="modal-dialog-centered modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="formModal">Anda Yakin Menghapus Pengajuan Cuti Ini?
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form class="" action="{{ route('cuti.destroy') }}" method="get">
                                    @csrf
                                    <div id='loader'></div>
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-block btn-danger m-t-15 waves-effect">Hapus</button>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" id="hapusCutiModal" name="custId">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="ketTolakAdmin" tabindex="-1" role="dialog"
                    aria-labelledby="formModal" aria-hidden="true">
                    <div class=" modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="formModal">Alasan Ditolak</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="texDaftar Riwayat Cutit" readonly class="form-control-plaintext"
                                        id="ketTolakAdminUser">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            {{-- @endsection --}}
        </div>
    </div>



    <!-- General JS Scripts -->
    <script src="{{ asset('js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('bundles/echart/echarts.js') }}"></script>
    <script src="{{ asset('bundles/chartjs/chart.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>

    <!-- myscript -->
    <!-- Custom JS File -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('bundles/cleave-js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('bundles/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('bundles/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
    <script src="{{ asset('bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    <script>
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
        });

        $(function() {
            $('#book_date').on('apply.daterangepicker', function(ev, picker) {
                $('#filterDate').submit();
            });
        });
    </script>

    <script>
        const table = $('#table_id').DataTable({
            "responsive": true,
            "autowidth": true,
        });
    </script>


    <script src="{{ asset('js/page/forms-advanced-forms.js') }}">
        < /scrip> <
        script src = "{{ asset('bundles/izitoast/js/iziToast.min.js') }}" >
    </script>
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            var recipient = button.data('id') // Target data-id
            console.log(recipient); // Here you can see the data-id value from a element
            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            // modal.find('.modal-body input').val(recipient)
            modal.find('#input-customer-id').val(recipient); // set input value
        })
    </script>

    <script>
        function filter() {
            table.ajax.reload(null, false)
        }
    </script>

    <script>
        $('#hapusPengajuan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            var recipient = button.data('id') // Target data-id
            console.log(recipient); // Here you can see the data-id value from a element
            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            // modal.find('.modal-body input').val(recipient)
            modal.find('#hapusCutiModal').val(recipient); // set input value
        })
    </script>

    <script>
        $('#ketTolakAdmin').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            var recipient = button.data('id') // Target data-id
            console.log(recipient); // Here you can see the data-id value from a element
            var modal = $(this)
            // modal.find('.modal-title').text('New message to ' + recipient)
            // modal.find('.modal-body input').val(recipient)
            modal.find('#ketTolakAdminUser').val(recipient); // set input value
        })
    </script>

</body>


<!-- Mirrored from radixtouch.com/templates/admin/aegis/source/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Jul 2021 09:55:44 GMT -->

</html>
