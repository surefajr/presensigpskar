@extends('layouts.presensi')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        .datepicker-modal {
            max-height: 430px !important;
        }

        .datepicker-date-display {
            background-color: aqua !important;
        }

        #keterangan {
            height: 8rem !important;
        }
    </style>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="arrow-back-circle-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Edit Izin Absen</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top:70px">
        <div class="col">
            <form method="POST" action="/izinabsen/{{$dataizin->kode_izin}}/update" id="frmizin">
                @csrf
                <div class="form-group">
                    <input type="text" id="tgl_izin_dari" value="{{$dataizin->tgl_izin_dari}}" name="tgl_izin_dari" class="form-control datepicker"
                        autocomplete="off" placeholder="Dari Tanggal">
                </div>
                <div class="form-group">
                    <input type="text" id="tgl_izin_sampai" value="{{$dataizin->tgl_izin_sampai}}" name="tgl_izin_sampai" class="form-control datepicker"
                        autocomplete="off" placeholder="Sampai Tanggal">
                </div>
                <div class="form-group">
                    <input type="text" id="jml_hari" name="jml_hari" class="form-control " placeholder="Jumlah Hari"
                        autocomplete="off" readonly>
                </div>
                <div class="form-group">
                    <input name="keterangan" id="keterangan" value="{{$dataizin->keterangan}}" name="keterangan" class="form-control" placeholder="Keterangan"
                        autocomplete="off">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({


                format: "yyyy-mm-dd"
            });

            function loadjumlahhari() {
                var dari = $("#tgl_izin_dari").val();
                var sampai = $("#tgl_izin_sampai").val();
                var date1 = new Date(dari);
                var date2 = new Date(sampai);

                var Difference_In_Time = date2.getTime() - date1.getTime();
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                if (dari == "" || sampai == "") {
                    var jmlhari = 0;
                } else {
                    var jmlhari = Difference_In_Days + 1;
                }

                $("#jml_hari").val(jmlhari + " Hari");
            }
            loadjumlahhari();
            $("#tgl_izin_dari,#tgl_izin_sampai").change(function(e) {
                loadjumlahhari();
            });






            //$("#tgl_izin").change(function(e) {
            //    var tgl_izin = $(this).val();
            //    $.ajax({
            //        type: 'POST',
            //        url: '/presensi/cekpengajuanizin',
            //        data: {
            //            _token: "{{ csrf_token() }}",
            //            tgl_izin: tgl_izin
            //        },
            //        cache: false,
            //        success: function(respond) {
            //            if (respond == 1) {
            //                Swal.fire({
            //                    title: 'Oops!',
            //                    text: 'Anda Sudah Melakukan Pengajuan Pada Tanggal Tersebut',
            //                    icon: 'warning',
            //                }).then((result) => {
            //                    $("#tgl_izin").val("");
            //                });
            //            }
            //        }
            //    });
            //});

            $("#frmizin").submit(function() {
                var tgl_izin_dari = $("#tgl_izin_dari").val();
                var tgl_izin_sampai = $("#tgl_izin_sampai").val();
                var keterangan = $("#keterangan").val();
                if (tgl_izin_dari == "" || tgl_izin_sampai == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal harus di isi',
                        icon: 'warning',
                    });
                    return false;
                } else if (keterangan == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Keterangan harus di isi',
                        icon: 'warning',
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
