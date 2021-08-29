<section class="section">
    @php
        $a = 1;
        
    @endphp
    @if ($data->count() > 0)

        @foreach ($data as $data_penerima_manfaat)
            <h3 class="section-title"><i class="fas fa-user"></i> Penerima manfaat {{ $a }}</h3>
            <table class="table table-striped">
                <tr>
                    <td>Nama Penerima Manfaat</td>
                    <td>{{ $data_penerima_manfaat['nama'] }}</td>
                    <td>Usia Penerima Manfaat</td>
                    <td>{{ $data_penerima_manfaat['usia'] }}</td>
                </tr>

                <tr>
                    <td>Jenis Hubungan</td>
                    <td>{{ $data_penerima_manfaat['hubungan'] }}</td>
                </tr>

                <tr>
                    <td>Pilihan Hadiah</td>
                    <td>{{ $data_penerima_manfaat['jenis_hadiah'] }}</td>
                    <td>No handphone</td>
                    <td>{{ $data_penerima_manfaat['no_hp'] }}</td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td>{{ $data_penerima_manfaat['email'] }}</td>
                    <td>Alamat</td>
                    <td>{{ $data_penerima_manfaat['alamat'] }}</td>
                </tr>
            </table>
            @php
                $a++;
            @endphp
        @endforeach
    @else
        <div class="alert alert-danger"><i class="fas fa-info"></i> Tidak ada penerima manfaat</div>
    @endif

</section>
