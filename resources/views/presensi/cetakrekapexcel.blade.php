<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #tittle {
            font-family: 'Times New Roman';
            font-size: 15px;
            font-weight: bold;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
        }

        .tabeldatakaryawan tr td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #131212;
            padding: 8px;
            background-color: #dbdbdb;
            font-size: 10px;
        }

        .tabelpresensi tr td {
            border: 1px solid #131212;
            padding: 8px;
            font-size: 12px;
        }

        .foto {
            width: 40px;
            height: 30px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
    ?>
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width:100%">
            <tr>
                <td style="width:30px">

                </td>
                <td>
                    <span id="tittle">
                        Rekap Kehadiran Guru<br>
                        Periode {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        SMK DHARMA SISWA TANGERANG<br>
                    </span>
                    <span>Jl. Teuku Umar No.76, RT.001/RW.001, Nusa Jaya, Kec. Karawaci, Kota Tangerang, Banten
                        15115</span>
                </td>
            </tr>
        </table>
        <table class="tabelpresensi">
            <tr>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">TH</th>
                <th rowspan="2">TT</th>
            </tr>
            <tr>
                <?php
                    for ($i=1; $i<=31; $i++) {
                    ?>
                <th>{{ $i }}</th>
                <?php
                    }
                    ?>
            </tr>
            @foreach ($rekap as $d)
                <tr>
                    <td>{{ $d->nik }}</td>
                    <td>{{ $d->nama_lengkap }}</td>

                    <?php
    $totalhadir = 0;
    $totalterlambat = 0;

    for ($i = 1; $i <= 31; $i++) {
        $tgl = "tgl_" . $i;
        if (empty($d->$tgl)) {
            $hadir = ['', ''];
            $totalhadir += 0;
        } else {
            $hadir = explode("-", $d->$tgl);
            $totalhadir += 1;
            if ($hadir[0] > '07:00:00') {
                $totalterlambat += 1;
            }
        }
        ?>

                    <td>
                        <span style="color:{{ $hadir[0] > '07:00:00' ? 'red' : '' }}">{{ $hadir[0] }}</span><br>
                        <span style="color:{{ $hadir[1] > '16:00:00' ? 'red' : '' }}">{{ $hadir[1] }}</span>
                    </td>

                    <?php
    }
    ?>

                    <td>{{ $totalhadir }}</td>
                    <td>{{ $totalterlambat }}</td>
                </tr>
            @endforeach

        </table>

        <table width="100%" style="margin-top: 100px">
            <tr>
                <td colspan="2" style="text-align:right">
                    <?php
                    // Mendapatkan tanggal saat ini
                    $tanggal = date('d');
                    
                    // Mendapatkan nama bulan dalam Bahasa Indonesia
                    $nama_bulan = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ];
                    
                    // Mendapatkan bulan saat ini
                    $bulan = date('n');
                    
                    // Mendapatkan tahun saat ini
                    $tahun = date('Y');
                    
                    // Menampilkan tanggal dengan nama bulan dan tahun
                    echo 'Tangerang, ' . $tanggal . ' ' . $nama_bulan[$bulan] . ' ' . $tahun;
                    ?>
                    <br>
                    <b>Kepala Sekolah</b>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right" height="200px">
                    <u>Sari Lestari Nasution, S.pd</u><br>
                    NIP

                </td>
            </tr>
        </table>

    </section>
</body>

</html>
