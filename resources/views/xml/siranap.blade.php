<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<xml version="1.0">
@foreach($listTempatTidur as $key => $val)
<data>
    <kode_ruang>{{ $val->kode_ruang }}</kode_ruang>
    <tipe_pasien>{{ $val->tipe_pasien }}</tipe_pasien>
    <total_TT>{{ $val->total_TT }}</total_TT>
    <terpakai_male>{{ $val->terpakai_male }}</terpakai_male>
    <terpakai_female>{{ $val->terpakai_female }}</terpakai_female>
    <kosong_male>{{ $val->kosong_male }}</kosong_male>
    <kosong_female>{{ $val->kosong_female }}</kosong_female>
    <waiting>{{ $val->waiting }}</waiting>
    <tgl_update>{{ $val->tgl_update }}</tgl_update>
</data>
@endforeach
</xml>
