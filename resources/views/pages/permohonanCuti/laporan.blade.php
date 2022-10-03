<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laporan Cuti Booble.id</title>

    <style>
        table.table-bordered {
            border: 1px solid black;
        }

        table.table-bordered>thead>tr>th {
            border: 1px solid black;
        }

        table.table-bordered>tbody>tr>td {
            border: 1px solid black;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>

<body>

    <div class="container">

        @if ($bulanLaporan_akhir == $bulanLaporan_mulai && $jumlah_durasi > 28)
            <br />
            <center>
                <h5><b>Laporan Cuti Karyawaan Booble Mitra Kreatif</b></h5>
                <h5><b>Bulan {{ $bulanLaporan }} <b></h5>
            </center>
            <br />
        @elseif ($bulanLaporan_akhir != $bulanLaporan_mulai)
            <br />
            <center>
                <h5><b>Laporan Cuti Karyawaan Booble Mitra Kreatif</b></h5>
                <h5><b>{{ $bedaBulanLaporan_mulai }} - {{ $bedaBulanLapora_akhir }} <b></h5>
            </center>
            <br />
        @elseif ($jumlah_durasi < 28 && $bulanLaporan_akhir == $bulanLaporan_mulai)
            <br />
            <center>
                <h5><b>Laporan Cuti Karyawaan Booble Mitra Kreatif</b></h5>
                <h5><b>{{ $hari_mulai }} - {{ $hari_akhir }} {{ $bulanLaporan }} <b></h5>
            </center>
            <br />
        @endif

        <table style="margin-left: -240px" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="min-width: 5px; font-size: 11pt;">No</th>
                    <th class="text-center" style="min-width: 130px; font-size: 11pt;">Nama</th>
                    <th class="text-center" style="min-width: 80px; font-size: 11pt;">Divisi</th>
                    <th class="text-center" style="min-width: 80px; font-size: 11pt;">Jabatan</th>
                    <th class="text-center" style="min-width: 80px; font-size: 11pt;">Pengajuan</th>
                    <th class="text-center" style="min-width: 80px; font-size: 11pt;">Mulai Cuti</th>
                    <th class="text-center" style="min-width: 80px; font-size: 11pt;">Akhir Cuti</th>
                    <th class="text-center" style="min-width: 130px; font-size: 11pt;">Alasan Cuti</th>
                    <th class="text-center" style="min-width: 50px; font-size: 11pt;">Status</th>
                    <th class="text-center" style="min-width: 20px; font-size: 11pt;">Sisa</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permohonan as $i => $p)
                    <tr>
                        <td style="font-size: 11pt;" class="text-center">{{ $i + 1 }}</td>
                        <td style="font-size: 11pt;">{{ $p->name }}</td>
                        <td class="text-center" style="font-size: 11pt;">{{ $p->divisi }}</td>
                        <td class="text-center" style="font-size: 11pt;">{{ $p->jabatan }}</td>
                        <td class="text-center" style="font-size: 11pt;">{{ $p->tgl_memohon }}</td>
                        <td class="text-center" style="font-size: 11pt;">{{ $p->tgl_mulai }}</td>
                        <td class="text-center" style="font-size: 11pt;">{{ $p->tgl_akhir }}</td>
                        <td class="text-center" style="font-size: 11pt;">{{ $p->alasan_cuti }}</td>
                        <td class="text-center" style="font-size: 11pt;">{{ $p->status }}</td>
                        <td class="text-center" style="font-size: 11pt;">{{ $p->jumlah_cuti }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>

</body>

</html>
