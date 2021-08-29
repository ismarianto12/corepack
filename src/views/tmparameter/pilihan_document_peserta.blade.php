     <select name="{{ $name }}" class="form-control select2" multiple="" required>
         <option value="">Pilih Jenis Document</option>
         @foreach ($tmparater_doc as $param)
             <option value="{{ $param->id }}">{{ $param->nama_doc }}</option>
         @endforeach
     </select>
