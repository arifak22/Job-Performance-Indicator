<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <title>Cetak Berita Acara</title>
    <link rel="stylesheet" href="{{url('assets/_custom/css/style-report-pdf.css')}}">
</head>
    <body>
        <div id="content">

            <table width="100%">>
                <tr>
                    <td style="text-align:right;">Tanjung Balai Karimun, {{Sideveloper::date($data->tanggal_surat)}}</td>
                </tr>
            </table>

            <table>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>No</td>
                                <td>: {{$data->nomor_surat}}</td>
                            </tr>
                            <tr>
                                <td>Hal</td>
                                <td>: {{$data->hal_surat}}</td>
                            </tr>
                            <tr>
                                <td>Lampiran</td>
                                <td>: -</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    Kepada Yth.<br/>
                                    Direktur {{$data->nama_penyedia}} Kabupaten Karimun<br/>
                                    Di - Tempat
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                   <p>&emsp;&emsp;&emsp;
                                    Berdasarkan Peraturan Presiden Nomor 16 Tahun 2018 tentang Pengadaan Barang/Jasa Pemerintah dan aturan turunannya, dengan ini memberikan penilaian atas penyelesaian pekerjaan <b>{{$data->nama_pekerjaan}}</b> yang dilakukan oleh :
                                   </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td>a. </td>
                                            <td colspan="3">Identias Penyedia</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>1. </td>
                                            <td>Nama Penyedia</td>
                                            <td>:</td>
                                            <td>{{$data->nama_penyedia}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2. </td>
                                            <td>Alamat</td>
                                            <td>:</td>
                                            <td>{{$data->alamat}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>3. </td>
                                            <td>NPWP</td>
                                            <td>:</td>
                                            <td>{{$data->npwp}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>4. </td>
                                            <td>Nomor SIUP</td>
                                            <td>:</td>
                                            <td>{{$data->nomor_siup}}</td>
                                        </tr>
                                        <tr>
                                            <td>b. </td>
                                            <td colspan="3">Data Paket Pekerjaan</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>1. </td>
                                            <td>Nama Peket Pekerjaan</td>
                                            <td>:</td>
                                            <td>{{$data->nama_pekerjaan}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>2. </td>
                                            <td>Nilai Kontrak/nilai total HPS</td>
                                            <td>:</td>
                                            <td>{{Sideveloper::rupiah_format($data->nilai_kontrak)}} / {{Sideveloper::rupiah_format($data->nilai_kontrak_hps)}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>3. </td>
                                            <td>Tahun Paket Pekerajaan</td>
                                            <td>:</td>
                                            <td>{{$data->tahun_paket}}</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>4. </td>
                                            <td>Persentase Realisasi Pekerjaan</td>
                                            <td>:</td>
                                            <td>{{$data->persentase_realisasi}} %</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>5. </td>
                                            <td>Nomor Kontrak</td>
                                            <td>:</td>
                                            <td>{{$data->nomor_kontrak}}</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">c. </td>
                                            <td colspan="2">Informasi Kinerja Berdasarkan</td>
                                            <td rowspan="2">:</td>
                                            <td rowspan="2">Penawaran penyedia adalah sebesar {{$data->biaya}}% dari nilai HPS</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Biaya</td>
                                        </tr>
                                        
                                        <tr>
                                            <td rowspan="2">d. </td>
                                            <td colspan="2">Informasi Kinerja Berdasarkan</td>
                                            <td rowspan="2">:</td>
                                            <td rowspan="2">{{$data->realisasi}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Realisasi Pekerjaan</td>
                                        </tr>
                                        
                                        <tr>
                                            <td rowspan="2">e. </td>
                                            <td colspan="2">Informasi Kinerja Berdasarkan</td>
                                            <td rowspan="2">:</td>
                                            <td rowspan="2">{{$data->kualitas}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Kualitas Pekerjaan</td>
                                        </tr>

                                        
                                        <tr>
                                            <td rowspan="2">f. </td>
                                            <td colspan="2">Informasi Kinerja Berdasarkan</td>
                                            <td rowspan="2">:</td>
                                            <td rowspan="2">{{$data->ketepatan_waktu}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Ketepatan Waktu</td>
                                        </tr>
                                        
                                        <tr>
                                            <td rowspan="2">g. </td>
                                            <td colspan="2">Informasi Kinerja Berdasarkan</td>
                                            <td rowspan="2">:</td>
                                            <td rowspan="2">{{$data->tingkat_layanan}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Tingkat Layanan</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>
                                   <p>&emsp;&emsp;&emsp;
                                    Demikian kami sampaikan untuk dapat digunakan dengan sebagaimana mestinya.
                                   </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table width="100%">
                <tr>
                    <td width="60%"></td>
                    <td style="text-align:center;">
                        <table>
                            <tr>
                                <td>Pejabat Pembuat Komitmen pada</td>
                            </tr>
                            <tr>
                                <td>{{Sideveloper::date($data->tanggal_surat)}}</td>
                            </tr>
                            <tr>
                                <td style="height: 45px"><div></div></td>
                            </tr>
                            <tr>
                                <td>{{$data->nama_ppk}}</td>
                            </tr>
                            <tr>
                                <td>NIP.{{$data->nip}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <b><u>Tembusan</u></b> Kepada Yth :
            <ol style="padding-left: 15px; margin-top:3px">
                <li>Inspektur Daerah Kabupaten Karimun</li>
                <li>Bagian Pengadaan Barang dan Jasa Kabupaten Karimun</li>
                <li>Arsip</li>
            </ol>
        </div>
    </body>
</html>