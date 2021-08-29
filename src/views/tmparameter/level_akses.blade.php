<select class="form-control select2" multiple="multiple" name="{{ $name }}" style="width: 100%">

    @foreach ($data as $datas)
        <option value="{{ $datas->username }}">{{ $datas->name }} - {{ $datas->permision }}</option>
    @endforeach
</select>
