<button id="add_biaya" class="btn btn-primary btn-sm" onclick="javascript:create_biaya()">Add</button>
<button id="remove_biaya" class="btn btn-info btn-sm" onclick="javascript:hapus_biaya_del()">Remove</button>
<hr />
<table class="table table-striped">
    <tr>
        <td>#</td>
        <td>Dari Bulan </td>
        <td>Ke Bulan</td>
        <td>Nominal</td>
        <td>Action</td>
    </tr>
    @php
        $j = 1;
    @endphp

    @foreach ($data as $datas)
        @if ($datas->dari_bulan != null)
            <tr>
                <td><input type='checkbox' name='cbox[]' value='{{ $datas->id }}' /></td>
                <td> {{ $datas->dari_bulan }}</td>
                <td> {{ $datas->ke_bulan }}</td>
                <td> {{ $datas->nominal }}</td>
                <td>
                    <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                </td>
            </tr>
            @php
                $j++;
            @endphp
        @else
            <tr>
                <td colspan="5">
                    Data Kosong
                </td>
            </tr>

        @endif
    @endforeach

</table>
