@include('ismarianto::tmparameter.css')

<section class="section">
    <div class="row">
        <div class="col-12">
            <br />
            @include('ismarianto::otorisasi.form_kelengkapan_part')
        </div>
    </div>
</section>

<script type="text/javascript">
    (function() {
        'use strict';
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

    })();
</script>
