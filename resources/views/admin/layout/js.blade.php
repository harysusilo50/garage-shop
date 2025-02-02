<!-- Vendor JS Files -->
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('vendor/croppie/croppie.js') }}"></script>
<script src="{{ asset('admin/vendor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/splide/dist/js/splide.min.js') }}"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert')

@yield('js')
<script src="{{ asset('admin/js/main.js') }}"></script>
<script type="text/javascript">
    function delete_data(id) {
        var text = "Data akan dihapus dan tidak bisa dikembalikan"
        var url = "{{ url('/' . \Request::segment(1) . '/') }}";
        var _token = "{{ csrf_token() }}";
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url + "/" + id,
                    type: 'DELETE',
                    data: {
                        _token: _token
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        table.ajax.reload();
                        if (data.status == 'success') {
                            Swal.fire(
                                'Terhapus!',
                                data.message,
                                'success'
                            )
                        } else {
                            Swal.fire(
                                'Gagal!',
                                data.message,
                                'error'
                            )
                        }
                        console.log(data)
                    },
                    error: function(ajaxContext) {
                        table.ajax.reload();
                        Swal.fire(
                            'Oops...',
                            'Terjadi kesalahan',
                            'error',
                        )
                    }
                });
            }
        })
    };
</script>
<script>
    function toggleFullscreen(elem) {
        elem = elem || document.documentElement;
        if (!document.fullscreenElement && !document.mozFullScreenElement &&
            !document.webkitFullscreenElement && !document.msFullscreenElement) {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
            $('#fullscreen_btn').removeClass('bi-arrows-fullscreen');
            $('#fullscreen_btn').addClass('bi-fullscreen-exit');
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
            $('#fullscreen_btn').addClass('bi-arrows-fullscreen');
            $('#fullscreen_btn').removeClass('bi-fullscreen-exit');
        }
    }
</script>
