<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{$title}}</h4>
        {!!Sideveloper::breadcrumb($breadcrumbs)!!}
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4>Rincian</h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Dinas</th>
                                <td>:</td>
                                <td>{{$data->nama_dinas}}</td>
                            </tr>
                            <tr>
                                <th>Nomor Surat</th>
                                <td>:</td>
                                <td>{{$data->nomor_surat}}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Surat</th>
                                <td>:</td>
                                <td>{{Sideveloper::date($data->tanggal_surat)}}</td>
                            </tr>
                            <tr>
                                <th>Hal Surat</th>
                                <td>:</td>
                                <td>{{$data->hal_surat}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4>Identitas Penyedia</h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Nama Penyedia</th>
                                <td>:</td>
                                <td>{{$data->nama_penyedia}}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>:</td>
                                <td>{{$data->alamat}}</td>
                            </tr>
                            <tr>
                                <th>NPWP</th>
                                <td>:</td>
                                <td>{{$data->npwp}}</td>
                            </tr>
                            <tr>
                                <th>Nomor SIUP</th>
                                <td>:</td>
                                <td>{{$data->nomor_siup}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4>Paket Pekerjaan</h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Nama Paket Pekerjaan</th>
                                <td>:</td>
                                <td>{{$data->nama_pekerjaan}}</td>
                            </tr>
                            <tr>
                                <th>Nilai Kontrak / Nilai Total HPS</th>
                                <td>:</td>
                                <td>{{Sideveloper::rupiah_format($data->nilai_kontrak)}} / {{Sideveloper::rupiah_format($data->nilai_kontrak_hps)}}</td>
                            </tr>
                            <tr>
                                <th>Tahun Paket Pekerjaan</th>
                                <td>:</td>
                                <td>{{$data->tahun_paket}}</td>
                            </tr>
                            <tr>
                                <th>Persentase Realisasi Pekerjaan</th>
                                <td>:</td>
                                <td>{{$data->persentase_realisasi}} %</td>
                            </tr>
                            <tr>
                                <th>Nomor Kontrak</th>
                                <td>:</td>
                                <td>{{$data->nomor_kontrak}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4>Informasi Kinerja</h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Biaya</th>
                                <td>:</td>
                                <td>{{$data->biaya}} % dari nilai HPS</td>
                                <td><i>( Nilai: {{$data->biaya_nilai}} )</i></td>
                            </tr>
                            <tr>
                                <th>Realisasi Pekerjaan</th>
                                <td>:</td>
                                <td>{{$data->realisasi}}</td>
                                <td><i>( Nilai: {{$data->realisasi_nilai}} )</i></td>
                            </tr>
                            <tr>
                                <th>Kualitas Pekerjaan</th>
                                <td>:</td>
                                <td>{{$data->kualitas}}</td>
                                <td><i>( Nilai: {{$data->kualitas_nilai}} )</i></td>
                            </tr>
                            <tr>
                                <th>Ketepatan Waktu</th>
                                <td>:</td>
                                <td>{{$data->ketepatan_waktu}}</td>
                                <td><i>( Nilai: {{$data->ketepatan_waktu_nilai}} )</i></td>
                            </tr>
                            <tr>
                                <th>Tingkat Layanan</th>
                                <td>:</td>
                                <td>{{$data->tingkat_layanan}}</td>
                                <td><i>( Nilai: {{$data->tingkat_layanan_nilai}} )</i></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Total Nilai</th>
                                <th>{{$data->nilai}}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>