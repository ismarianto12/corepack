@if ($fkode == 1)
    @php
        $form = 'form_savedocpsrta';
        $jenis_document = '#jenis_document_id';
        $title = 'Document Data Peserta';
        $jenis_hadiah = '#jenis_hadiah';
        $loadtable = 'thadiah_peserta';
        
    @endphp
@else
    @php
        $form = 'form_savedocpmanfaat';
        $jenis_document = '#jenis_document_manfaat_id';
        $jenis_hadiah = '#jenis_hadiah_manfaat';
        $title = 'Document Data Penerima manfaat';
        $loadtable = 'thadiah_pmanfaat';
    @endphp
@endif

<h3 class="section-title">{{ $title }}</h3>
<a href="#" class="btn btn-info add_{{ $form }}"><i class="fas fa-plus"></i></a>
<a href="#" class="btn btn-danger" id="remove_{{ $form }}"><i class="fas fa-minus"></i></a>
<hr />
<br />
<div class="clearfix"></div>
<div id="{{ $form }}"></div>

<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Nama File</th>
        <th>Ket</th>
        <th>Action</th>
    </tr>
    @php
        $j = 1;
    @endphp

    @if ($doc->count() == 0)
        <tr>
            <td colspan="4">Data Document kosong.</td>
        </tr>
    @else

    @endif
    @foreach ($doc as $documents)
        @php
            $badge = $j % 2 ? 'success' : 'warning';
        @endphp
        <tr>
            <th>{{ $j }}</th>
            <th>
                <div class="badge badge-{{ $badge }}"> {{ $documents->nama_doc }}</div>
            </th>
            <th>
                {{ $documents->status }}
            </th>


            <th>
                @if ($fkode == 1)
                    <a id="remove_biaya" class="btn btn-info btn-sm"
                        onclick="javascript:hapus_data({{ $documents->id }})"><i class="fas fa-trash"></i></a>

                @else
                    <a id="remove_biaya" class="btn btn-info btn-sm"
                        onclick="javascript:hapus_pmanfaat({{ $documents->id }})"><i class="fas fa-trash"></i></a>


                @endif

            </th>
        </tr>
        @php
            $j++;
        @endphp

    @endforeach
</table>
<script>
    $(function() {
        $('.add_{{ $form }}').on('click', function(event) {
            event.preventDefault();
            if ($('{{ $jenis_document }}').val() == '' || $('{{ $jenis_hadiah }}').val() ==
                '') {
                $.alert('Silahkan jenis doument dan jenis hadiah');
            } else {
                $.get('{{ route('parameterdocument.create') }}', {
                    no_apl: '',
                    token: '{{ csrf_token() }}',
                    fkode: '{{ $fkode }}',
                    category: '{{ $category }}',
                    kode: '{{ $kode }}',
                    parameter: 'add',
                    tmhadiah_id: '{{ $tmhadiah_id }}',
                }, function(data) {
                    $('#{{ $form }}').html(data).slideDown();
                }).fail(function() {});
            }
        })
    });

    function hapus_data(n) {
        $.ajax({
            url: "{{ route('parameterdocument.destroy', ':id') }}".replace(':id', n),
            method: "DELETE",
            data: 'id=' + n,
            asynch: false,
            chace: false,
            success: function(data) {
                $.post('{{ route('gettable_document') }}', {
                    category: '{{ $category }}',
                    kode: '{{ $kode }}',
                    parameter: 'add',
                    tmhadiah_id: '{{ $tmhadiah_id }}',
                }, function(data) {
                    $('#thadiah_peserta').html(data);
                });
            },
            error: function(data) {}
        })
    }

    function hapus_pmanfaat(n) {
        $.ajax({
            url: "{{ route('parameterdocument.destroy', ':id') }}".replace(':id', n),
            method: "DELETE",
            data: 'id=' + n,
            asynch: false,
            chace: false,
            success: function(data) {
                $.post('{{ route('gettable_document') }}', {
                    category: '{{ $category }}',
                    kode: '{{ $kode }}',
                    parameter: 'add',
                    tmhadiah_id: '{{ $tmhadiah_id }}',
                }, function(data) {
                    $('#thadiah_pmanfaat').html(data);
                });
            },
            error: function(data) {}
        })
    }
</script>
