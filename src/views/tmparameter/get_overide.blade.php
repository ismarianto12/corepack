<select class="form-control select2" multiple="multiple" name="{{ $name }}" style="width: 100%">
    @foreach ($data as $datas)
        @php
            if (strpos($parclass, $datas->id) === false) {
                $selected = '';
            } else {
                $selected = 'selected';
            }
        @endphp

        <option value="{{ $datas->id }}" {{ $selected }}>{{ $datas->name }} - {{ $datas->permision }}
        </option>
    @endforeach
</select>
