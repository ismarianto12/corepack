if ($this->request->overide == 1) {
$f = new Tmoveride();
$f->no_aplikasi = $this->request->no_aplikasi;
// ini yang ke nasabah
$data->tmstatus_aplikasi = $this->request->overide;
} else {
// proses pembukaan rekening induk
//init
$parameter = Tmparameter::find($data->tmparameter_id);
if ($parameter['otomatis_slik'] == 1) {
// cek otomatis slik
} else {
// tidak pakai slik
// $reknas = new NasabahApirek();
$this->doprocessRekInduk($data->no_aplikasi);
$this->doprocessSMS($data->no_aplikasi);
}
// sms gateway proses dana awal
}



//

<a hre="#" class="statappr_ btn bg-green btn-flat btn-sm margin"
    to="http://cfos.paninbanksyariah.co.id/load_action/KPR400080721693?parsing=wait">

    $(".statappr_").on("click", function() {
    url_data = $(this).attr('to');
    $.dialog({
    title: 'Detail status approve Ismarianto',
    content: 'url:' + url_data,
    animation: 'scale',
    columnClass: 'large',
    closeAnimation: 'scale',
    backgroundDismiss: true,
    });

    });

    });
