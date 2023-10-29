<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>

<script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.all.js') }}"></script>

@stack('js')

<script>
    $(document).ready(function() {
        $("body").on('keyup', '.form-control', function() {
            $(this).removeClass('is-invalid')
        })

        $("body").on('keyup', '.ck-editor__editable_inline', function() {
            $(".invalid-ckeditor").remove()
        })

        $("body").on('change', '.form-control', function() {
            $(this).removeClass('is-invalid')
        })
    })

    $(".btn-delete").click(function(e) {
        e.preventDefault();

        let form = $(this).closest("form");

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Anda tidak akan dapat mengembalikannya!",
            icon: 'warning',
            showDenyButton: true,
            denyButtonText: 'Hapus',
            confirmButtonText: 'Batal',
            confirmButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isDenied) {
                form.submit()
            }
        })
    })
</script>
<script>
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>

</body>

</html>
