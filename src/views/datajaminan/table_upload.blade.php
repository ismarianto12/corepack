<table class="table table-striped">

    <tr>
        <th>#</th>
        <th>Nama File</th>
        <th>Ket</th>
        <th>Action</th>
    </tr>
    @php
        $j = 1;
    @endphp
    @foreach ($document as $documents)
        @php
            $badge = $j % 2 ? 'success' : 'warning';
        @endphp
        <tr>
            <th>{{ $j }}</th>
            <th>
                <div class="badge badge-{{ $badge }}"> {{ str_replace('', ',', $documents->nama_doc) }}</div>
            </th>
            <th>
                {{ $documents->status }}
            </th>
            <th>
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <input type="hidden" name="tmparameter_doc_id" value="{{ $documents->id }}">
                    <input class="filenya" type="file" name="file" id="{{ $documents->nama_doc }}">
                    <a href="{{ $documents->nama_file }}" class="btn btn-success">View</a>
                </div>
            </th>
        </tr>
        @php
            $j++;
        @endphp

    @endforeach

</table>
