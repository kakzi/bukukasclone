{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        var socket = io();

        socket.on('message', function(msg) {
            $('.logs').prepend($('<li>').text(msg));
        });

        socket.on('qr', function(src) {
            $('#qrcode').attr('src', src);
            $('#qrcode').show();
        });

        socket.on('ready', function(data) {
            $('#qrcode').hide();
        });

        socket.on('authenticated', function(data) {
            $('#qrcode').hide();
        });
    });
</script> --}}

<script src="{{ mix('js/app.js') }}"></script>

<script src="{{ asset('/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('/vendors/tinymce/tinymce.min.js') }}"></script>


<script src="{{ asset('/js/bootstrap.bundle.min.js') }}"></script>

@livewireScripts
<script src="{{ asset('/js/main.js') }}"></script>



{{ $script ?? ''}}