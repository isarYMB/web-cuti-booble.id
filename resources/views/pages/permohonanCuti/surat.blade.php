<!DOCTYPE html>
<head>
    <title>Contoh Surat Pernyataan</title>
    <meta charset="utf-8">
    <style>
        #judul{
            text-align:center;
        }

        #halaman{
            width: 190mm; 
            height: auto; 
            padding-top: 30px; 
            padding-left: 30px; 
            padding-right: 30px; 
            padding-bottom: 80px;
            margin: auto;
        }

        .border {
            border: 1px solid black;
            border-collapse: collapse;
          }

    </style>

</head>

<body>
    <div id=halaman>
        <h3 style="text-decoration: underline; margin-left:-50px" id=judul>FORM PENGAJUAN CUTI</h3>
        <br>
        <br>
        
        
        
        @foreach($dataSurat as $i => $p)
        <p>Saya yang bertanda tangan di bawah ini :</p>
        <table>
            <tr>
                <td style="width: 150px;">Nama</td>
                <td style="width: 10px">:</td>
                <td>{{$p->name}}</td>
            </tr>
            <tr>
                <td style="width: 150px;">NIK</td>
                <td style="width: 10px;">:</td>
                <td>{{$p->nik}}</td>
            </tr>
            <tr>
                <td style="width: 150px; vertical-align: top;">Jabatan</td>
                <td style="width: 10px; vertical-align: top;">:</td>
                <td>{{$p->jabatan}}</td>
            </tr>
            <tr>
                <td style="width: 150px;">Divisi</td>
                <td style="width: 10px">:</td>
                <td style="">{{$p->divisi}}</td>
            </tr>
        </table>
        <br>

        <p>Dengan ini mengajukan cuti tahunan :</p>
        <table>
            <tr>
                <td style="width: 150px;">Untuk selama</td>
                <td style="width:10px;">:</td>
                <td>{{$p->durasi_cuti}} Hari</td>
            </tr>
            <tr>
                <td style="width: 150px;">Hari/Tanggal</td>
                <td style="width: 10px;">:</td>
                <td>
                    {{$hariMulai}} sd {{$hariAkhir}} / {{$tglMulai}} - {{$tglAkhir}}
                </td>
            </tr>
            <tr>
                <td style="width: 150px; vertical-align: top;">Alasan cuti</td>
                <td style="width: 10px; vertical-align: top;">:</td>
                <td>{{$p->alasan_cuti}}</td>
            </tr>
            <tr>
                <td style="width: 150px;">No. Telpon</td>
                <td style="width: 10px;">:</td>
                <td>{{$p->no_telpon}}</td>
            </tr>
        </table>
        <br>

        
        <p>Makassar, {{$hariIni}}</p>
        <br>
        

        <table class="border" style="width: 170mm; ">
            <tr class="border">
                <td class="border" style="width: 32%;text-align: center;font-weight: bold; padding:5px">Diajukan,</td>
                <td class="border" style="width: 32%;text-align: center;font-weight: bold;padding:5px">Disetujui Oleh,</td>
                <td class="border" style="width: 32%;text-align: center;font-weight: bold;padding:5px">Mengetahui,</td>
            </tr>
            <tr class="border">
                <td class="border" style="width: 32%;text-align: center; padding-top: 100px;">
                    <p style="text-decoration: underline;font-weight: bold;">{{$p->name}}</p>
                    <p style="margin-top:-10px;">{{$p->jabatan}}</p>
                </td>
                <td class="border" style="width: 32%;text-align: center; padding-top: 100px;">
                    <p style="text-decoration: underline;font-weight: bold;">{{$namaAtasan}}</p>
                    <p style="margin-top:-10px;">Atasan Langsung</p>
                </td>
                <td class="border" style="width: 32%;text-align: center; padding-top: 100px;"><p style="text-decoration: underline;font-weight: bold;">{{$mengetahuiOleh}}</p>
                    <p style="margin-top:-10px;">HRD</p></td>
            </tr>
        </table>

        @endforeach

    </div>
</body>

</html>