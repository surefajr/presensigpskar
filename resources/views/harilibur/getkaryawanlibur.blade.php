@foreach ($karyawanlibur as $d)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->nik }}</td>
        <td>{{ $d->nama_lengkap }}</td>
        <td>{{ $d->jabatan }}</td>
        <td>
            <a href="#" class="btn btn-danger btn-sm cancelibur" nik="{{ $d->nik }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18 6l-12 12" />
                    <path d="M6 6l12 12" />
                </svg>
            </a>
        </td>
    </tr>
@endforeach

<script>
    $(function() {

        function loadkaryawanlibur() {
            var kode_libur = "{{ $kode_libur }}";
            $("#loadkaryawanlibur").load('/konfigurasi/harilibur/' + kode_libur + '/getkaryawanlibur');
        }
        $(".cancelibur").click(function(e) {
            e.preventDefault();
            var kode_libur = "{{ $kode_libur }}";
            var nik = $(this).attr('nik');
            $.ajax({
                type: 'POST',
                url: '/konfigurasi/harilibur/batalkanliburkaryawan',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_libur: kode_libur,
                    nik: nik
                },
                cache: false,
                success: function(respond) {
                    if (respond === '0') {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Guru berhasil dihapus !!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });

                        loadkaryawanlibur();
                    } else if (respond === '1') {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Guru sudah ditambahkan !!',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: respond,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    });
</script>
