@if ($fkode == 1)
    @php
        $submit = '_savedocpsrta';
        $form = 'form_savedocpsrta';
        $load_form = 'thadiah_peserta';
        $val = 'Peserta';
    @endphp
@else
    @php
        $submit = '_savedocpmanfaat';
        $form = 'form_savedocpmanfaat';
        $load_form = 'thadiah_pmanfaat';
        
        $val = 'Pmanfaat';
    @endphp
@endif
<form class="form-horizontal" method="POST" id="{{ $submit }}">
    <div class="form-group row">
        <label for="kode" class="col-md-2 text-left">Kode </label>
        <div class="col-md-4">
            <input type="hidden" name="kode" value="{{ $val }}">
            <input type="hidden" name="tmhadiah_id" value="{{ $tmhadiah_id }}">

            <input type="text" class="form-control" value="{{ $val }}" readonly>
        </div>
        <label for="kode" class="col-md-2 text-left">Nama Document</label>
        <div class="col-md-4">
            <input type="text" name='nama_doc' class="form-control" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="kode" class="col-md-2 text-left">Kode Document</label>
        <div class="col-md-4">
            <input type="hidden" name="category" class="form-control" value="{{ $category }}">
            <input type="text" class="form-control" value="{{ ucfirst($category) }}" readonly>
        </div>

        <label for="kode" class="col-md-2 text-left">Status</label>
        <div class="col-md-4">
            <select class="form-control" name="status" required>
                <option value="Wajib">Wajib</option>
                <option value="Opsional">Opsional</option>
            </select>
        </div>
    </div>


    <div class="form-group row">
        <div class="col-md-4">
            <button class="btn btn-primary" style="color:#ffff">Tambah Document</button>
            <button type="reset" class="btn btn-danger" id="resetfom" style="color :#fff">Reset</button>
        </div>
    </div>
</form>
<hr />

<script>
    $(function() {
        $('#{{ $submit }}').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('parameterdocument.store') }}",
                method: "POST",
                data: $(this).serialize(),
                chace: false,
                asynch: false,
                success: function(data) {
                    $.post('{{ route('gettable_document') }}', {
                        category: '{{ $category }}',
                        kode: '{{ $val }}',
                        parameter: 'add',
                        tmhadiah_id: '{{ $tmhadiah_id }}',
                    }, function(data) {
                        $('#{{ $load_form }}').html(data);
                    });
                    $('#{{ $load_form }}').hide().slideDown();
                },
                error: function(data) {}
            })

        });
    });
</script>
