<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{$title}}</h4>       
        {!!Sideveloper::breadcrumb($breadcrumbs)!!}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form>
                        <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-center" id="pills-tab-with-icon" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab-icon" data-toggle="pill" href="#pills-home-icon" role="tab" aria-controls="pills-home-icon" aria-selected="true">
                                    <i class="flaticon-agenda"></i>
                                    Formulir
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab-icon" data-toggle="pill" href="#pills-profile-icon" role="tab" aria-controls="pills-profile-icon" aria-selected="false">
                                    <i class="flaticon-graph-2"></i>
                                    Paket Pekerjaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab-icon" data-toggle="pill" href="#pills-contact-icon" role="tab" aria-controls="pills-contact-icon" aria-selected="false">
                                    <i class="flaticon-file-1"></i>
                                    Informasi Kinerja
                                </a>
                            </li>
                        </ul>
                        
                        <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                            <div class="tab-pane fade show active" id="pills-home-icon" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!!Sideveloper::formHidden('id', $tipe == 2 ? Crypt::encryptString($data->id_transaksi) : '')!!}
                                            {!!Sideveloper::formHidden('tipe_form', $tipe)!!}
                                            {!!Sideveloper::formInput('Nomor Surat', 'text', 'nomor_surat', $tipe == 2 ? $data->nomor_surat : '')!!}
                                            {!!Sideveloper::formInput('Tanggal Surat', 'text', 'tanggal_surat', $tipe == 2 ? Sideveloper::defaultDate($data->tanggal_surat) : '', 'readonly')!!}
                                        </div>
                                        <div class="col-md-6">
                                            {!!Sideveloper::formInput('Hal Surat', 'text', 'hal_surat', $tipe == 2 ? $data->hal_surat : '')!!}
                                            {!!Sideveloper::formSelect('Penyedia', $penyedia, 'id_penyedia', $tipe == 2 ? $data->id_penyedia : '')!!}
                                        </div>
                                    </div>
                                    {!!Sideveloper::formSubmit('Next','next')!!}
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="pills-profile-icon" role="tabpanel" aria-labelledby="pills-profile-tab-icon">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!!Sideveloper::formSelect('Nama Pekerjaan', $pekerjaan, 'id_pekerjaan', $tipe == 2 ? $data->id_pekerjaan : '')!!}
                                            {!!Sideveloper::formInput('Nilai Kontrak', 'number', 'nilai_kontrak', $tipe == 2 ? $data->nilai_kontrak : '')!!}
                                            {!!Sideveloper::formInput('Nilai Total HPS', 'number', 'nilai_kontrak_hps', $tipe == 2 ? $data->nilai_kontrak_hps : '')!!}
                                        </div>
                                        <div class="col-md-6">
                                            {!!Sideveloper::formSelect('Tahun Paket', $year, 'tahun_paket', $tipe == 2 ? $data->tahun_paket : date('Y'))!!}
                                            {!!Sideveloper::formInput('Persentase Realisasi', 'number', 'persentase_realisasi', $tipe == 2 ? $data->persentase_realisasi : '')!!}
                                            {!!Sideveloper::formInput('Nomor Kontrak', 'text', 'nomor_kontrak', $tipe == 2 ? $data->nomor_kontrak : '')!!}
                                        </div>
                                    </div>
                                    {!!Sideveloper::formSubmit('Next','next2')!!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact-icon" role="tabpanel" aria-labelledby="pills-contact-tab-icon">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!!Sideveloper::formInput('Biaya', 'number', 'biaya', $tipe == 2 ? $data->biaya : '')!!}
                                            {!!Sideveloper::formInput('Realisasi', 'text', 'realisasi', $tipe == 2 ? $data->realisasi : '')!!}
                                            {!!Sideveloper::formSelect('Kualitas', $kualitas, 'kualitas', $tipe == 2 ? $data->kualitas : '')!!}
                                            {!!Sideveloper::formSelect('Ketepatan Waktu', $waktu, 'ketepatan_waktu', $tipe == 2 ? $data->ketepatan_waktu : '')!!}
                                            {!!Sideveloper::formSelect('Tingkat Layanan', $layanan, 'tingkat_layanan', $tipe == 2 ? $data->tingkat_layanan : '')!!}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
												<label class="form-label d-block">Nilai Biaya</label>
												<div class="selectgroup selectgroup-secondary selectgroup-pills">
													<label class="selectgroup-item">
                                                        <input type="radio" name="biaya_nilai" value="5" class="selectgroup-input" 
                                                            {{$tipe == 2 && $data->biaya_nilai == 5 ? 'checked' : ''}}
                                                            {{$tipe == 1 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">5</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="biaya_nilai" value="10" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->biaya_nilai == 10 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">10</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="biaya_nilai" value="15" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->biaya_nilai == 15 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">15</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="biaya_nilai" value="20" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->biaya_nilai == 20 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">20</span>
                                                    </label>
												</div>
                                            </div>
                                            <div class="form-group">
												<label class="form-label d-block">Nilai Realisasi</label>
												<div class="selectgroup selectgroup-secondary selectgroup-pills">
													<label class="selectgroup-item">
                                                        <input type="radio" name="realisasi_nilai" value="5" class="selectgroup-input" 
                                                            {{$tipe == 2 && $data->realisasi_nilai == 5 ? 'checked' : ''}}
                                                            {{$tipe == 1 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">5</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="realisasi_nilai" value="10" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->realisasi_nilai == 10 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">10</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="realisasi_nilai" value="15" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->realisasi_nilai == 15 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">15</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="realisasi_nilai" value="20" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->realisasi_nilai == 20 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">20</span>
                                                    </label>
												</div>
											</div>
                                            <div class="form-group">
												<label class="form-label d-block">Nilai Kualitas</label>
												<div class="selectgroup selectgroup-secondary selectgroup-pills">
													<label class="selectgroup-item">
                                                        <input type="radio" name="kualitas_nilai" value="5" class="selectgroup-input" 
                                                            {{$tipe == 2 && $data->kualitas_nilai == 5 ? 'checked' : ''}}
                                                            {{$tipe == 1 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">5</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="kualitas_nilai" value="10" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->kualitas_nilai == 10 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">10</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="kualitas_nilai" value="15" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->kualitas_nilai == 15 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">15</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="kualitas_nilai" value="20" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->kualitas_nilai == 20 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">20</span>
                                                    </label>
												</div>
											</div>
                                            <div class="form-group">
												<label class="form-label d-block">Nilai Ketepatan Waktu</label>
												<div class="selectgroup selectgroup-secondary selectgroup-pills">
													<label class="selectgroup-item">
                                                        <input type="radio" name="ketepatan_waktu_nilai" value="5" class="selectgroup-input" 
                                                            {{$tipe == 2 && $data->ketepatan_waktu_nilai == 5 ? 'checked' : ''}}
                                                            {{$tipe == 1 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">5</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="ketepatan_waktu_nilai" value="10" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->ketepatan_waktu_nilai == 10 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">10</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="ketepatan_waktu_nilai" value="15" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->ketepatan_waktu_nilai == 15 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">15</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="ketepatan_waktu_nilai" value="20" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->ketepatan_waktu_nilai == 20 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">20</span>
                                                    </label>
												</div>
                                            </div>                                            
                                            <div class="form-group">
												<label class="form-label d-block">Nilai Tingkat Layanan</label>
												<div class="selectgroup selectgroup-secondary selectgroup-pills">
													<label class="selectgroup-item">
                                                        <input type="radio" name="tingkat_layanan_nilai" value="5" class="selectgroup-input" 
                                                            {{$tipe == 2 && $data->tingkat_layanan_nilai == 5 ? 'checked' : ''}}
                                                            {{$tipe == 1 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">5</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="tingkat_layanan_nilai" value="10" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->tingkat_layanan_nilai == 10 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">10</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="tingkat_layanan_nilai" value="15" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->tingkat_layanan_nilai == 15 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">15</span>
													</label>
													<label class="selectgroup-item">
                                                        <input type="radio" name="tingkat_layanan_nilai" value="20" class="selectgroup-input"
                                                            {{$tipe == 2 && $data->tingkat_layanan_nilai == 20 ? 'checked' : ''}}
                                                        >
														<span class="selectgroup-button selectgroup-button-icon">20</span>
                                                    </label>
												</div>
											</div>
                                            {!!Sideveloper::formSubmit($tipe == 2 ? 'Ubah' : 'Simpan', 'submit')!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        @if($tipe == 1)
        $("#pills-profile-tab-icon").hide();
        $("#pills-contact-tab-icon").hide();
        @endif
        $('#id_penyedia').select2();
    });
    $("#next").click(function(e){
        e.preventDefault();
        let hasil = cekForm($(this));
        if(hasil){
            $('#pills-profile-tab-icon').show(); 
            $('#pills-profile-tab-icon').trigger('click'); 
        }
    });
    $("#next2").click(function(e){
        e.preventDefault();
        let hasil = cekForm($(this));
        if(hasil){
            $('#pills-contact-tab-icon').show(); 
            $('#pills-contact-tab-icon').trigger('click'); 
        }
    });

    function cekForm(value){
        var btn = value;
        var form = value.closest('form');
        form.validate({
            rules: {
                nomor_surat: {
                    maxlength: 100,
                    required: true,
                },
                tanggal_surat: {
                    required: true,
                },
                hal_surat: {
                    maxlength: 100,
                    required: true,
                },
                id_pekerjaan: {
                    required: true,
                },
                nilai_kontrak: {
                    min: 0,
                    required: true,
                },
                nilai_kontrak_hps: {
                    min: 0,
                    required: true,
                },
                persentase_realisasi: {
                    min: 0,
                    max: 100,
                    required: true,
                },
                nomor_kontrak: {
                    maxlength: 100,
                    required: true,
                },
                biaya: {
                    min: 0,
                    max: 100,
                    required: true,
                },
                realisasi: {
                    maxlength: 100,
                    required: true,
                },
                biaya_nilai: {
                    required: true,
                },
                realisasi_nilai: {
                    required: true,
                },
                kualitas_nilai: {
                    required: true,
                },
                ketepatan_waktu_nilai: {
                    required: true,
                },
                tingkat_layanan_nilai: {
                    required: true,
                },
            }
        });
        return form.valid();
        // if (!form.valid()) {
        //     return;
        // }
    }
    $('#tanggal_surat').datepicker({
        autoclose  : true,
        format     : 'yyyy-mm-dd',
        orientation: "bottom left",
    });
    $('#tahun_paket').datepicker({
        autoclose  : true,
        format     : 'yyyy',
        orientation: "bottom left",
        maxViewMode: 'year',
    });
    $('#submit').click(function(e) {
        e.preventDefault();
        var btn = $(this);
        var form = $(this).closest('form');
        let hasil = cekForm($(this));
        if(hasil){
            apiLoading(true, btn);            
            form.ajaxSubmit({
                url : "{{url()->current()}}",
                data: { _token: "{{ csrf_token() }}" },
                type: 'POST',
                success: function(response) {
                    apiLoading(false, btn);
                    apiRespone(response,
                        false
                        ,
                        (res) => {
                            window.location = "{{Sideveloper::selfUrl('')}}";
                        }
                    );
                },
                error: function(error){
                    apiLoading(false, btn);
                    swal(error.statusText);
                }
            });
        }
    });
</script>