<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Presensi</title>

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
            background-color: #dbdbdb
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

<body class="A4">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width:100%">
            <tr>
                <td style="width:30px">
                    <img src="{{ asset('assets/img/smk.png') }}" width="70" height="70" alt="">
                </td>
                <td>
                    <span id="tittle">
                        Laporan Kehadiran Guru<br>
                        Periode {{ date('d-m-Y', strtotime($tanggal_mulai)) }} s/d
                        {{ date('d-m-Y', strtotime($tanggal_selesai)) }}<br>
                        SMK DHARMA SISWA TANGERANG<br>
                    </span>
                    <span>Jl. Teuku Umar No.76, RT.001/RW.001, Nusa Jaya, Kec. Karawaci, Kota Tangerang, Banten
                        15115</span>
                </td>
            </tr>
        </table>
        <table class="tabeldatakaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = Storage::url('uploads/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="" width="120px" height="150">
                </td>
            </tr>
            <tr>
                <td>NUPTK</td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            {{-- <tr>
                <td>Mata Pelajaran</td>
                <td>:</td>
                <td>{{ $karyawan->nama_dept }}</td>
            </tr> --}}
            <tr>
                <td>Telepon</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>
        <table class="tabelpresensi">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Keterangan</th>
                <th>Total Jam Kerja</th>
            </tr>
            @foreach ($presensi as $d)
                @if ($d->status == 'h')
                    @php
                        $path_in = Storage::url('uploads/absensi/' . $d->foto_in);
                        $path_out =
                            $d->jam_out != null
                                ? Storage::url('uploads/absensi/' . $d->foto_out)
                                : asset('assets/img/cameraoff.png');
                        $jamterlambat = hitungjamkerja($d->jam_masuk, $d->jam_in);

                        $tgl_masuk = $d->tgl_presensi;
                        $jam_masuk = $tgl_masuk . ' ' . $d->jam_in;
                        $tgl_pulang = $d->jam_out != null ? $tgl_masuk : null;
                        $jam_pulang = $tgl_pulang != null ? $tgl_pulang . ' ' . $d->jam_out : null;
                        $jmljamkerja = $tgl_pulang != null ? hitungjamkerja($jam_masuk, $jam_pulang) : 0;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_in }}</td>
                        <td><img src="{{ url($path_in) }}" alt="" class="foto"></td>
                        <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                        <td><img src="{{ url($path_out) }}" alt="" class="foto"></td>
                        <td style="text-align: center">{{ $d->status }}</td>
                        <td>
                            @if ($d->jam_in > $d->jam_masuk)
                                Terlambat {{ $jamterlambat }}
                            @else
                                Tepat Waktu
                            @endif
                        </td>
                        <td>
                            {{ $jmljamkerja }}
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center">{{ $d->status }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td></td>
                    </tr>
                @endif
            @endforeach
        </table>

        <table width="100%" style="margin-top: 100px">
            <tr>
                <td colspan="2" style="text-align:right">
                    @php
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
                    @endphp
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
