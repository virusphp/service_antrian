<?php

namespace App\Repository;

use App\Helpers\BPJSHelper;
use App\Helpers\Waktu;
use App\Service\Bpjs\Bridging;
use DB;
use Carbon\Carbon;
use Exception;

class Antrian
{
    protected $dbsimrs = "sql_simrs";

    public function postAntrian($params)
    {
        try {
            $saveRegister = $this->simpanRegistrasi($params);
            if ($saveRegister) {
                return $saveRegister;
            }
            return $saveRegister;
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    // --- TABEL REGISTRASI
    private function simpanRegistrasi($params)
    {
        $dataPasien = $this->getDataPasien($params->nomorkartu);
        if ($dataPasien == null) {
            $res['code']  = 201;
            $res['error'] = "Pasien tersebut belom terdaftar di rumah sakit kami!";
            return $res;
        }

        $dokterPoli = $this->getDokterPoli($params->kodepoli, $params->tanggalperiksa);
        if ($dokterPoli == null) {
            $res['code']  = 201;
            $res['error'] = "Poli tujuan yang terpilih salah!!!";
            return $res;
        }

        $checkRegister = $this->checkRegister($dataPasien->no_rm, $params->tanggalperiksa, $dokterPoli->kd_sub_unit);
        if ($checkRegister)
        {
            $res['code']  = 201;
            $res['error'] = "Pasien dengan pembayaran Bpjs/Asuransi lain hanya dapat mendaftar 1 x perhari!!";
            return $res;
        }
       
        $dataPasien->waktu = date('H:i:s');
        $tarif             = $this->getTarif($dokterPoli->kd_sub_unit);
        $noBukti           = $this->getNoBukti($params->tanggalperiksa);
        $estimasidilayani  = $this->getEstimasi($params->tanggalperiksa);
        $noReg             = $this->generateNomor($params->tanggalperiksa);
        $statusPengunjung  = $this->getStatusPengunjung($dataPasien->no_rm);
        $asalPasien        = $this->asalPasien($params->jenisreferensi, $params->nomorreferensi);
        $kodePenjamin      = $this->getKodePenjamin($params->nomorkartu, $params->tanggalperiksa);

        DB::beginTransaction();
        try{
            $saveRegister = DB::connection($this->dbsimrs)->table('registrasi')->insert([
                'no_reg' => $noReg,
                'no_RM' => $dataPasien->no_rm,
                'tgl_reg' => $params->tanggalperiksa,
                'waktu' => $dataPasien->waktu,
                'kd_asal_pasien' => $asalPasien,
                'status_pengunjung' => $statusPengunjung,
                'kd_cara_bayar' => 8,
                'jenis_pasien' => 0,
                'no_reg_pembayar' => $noReg,
                'kd_penjamin' => $kodePenjamin,
                'no_SJP' => '-',
                'user_id' => '0000000'
            ]);
    
            if (!$saveRegister) {
                DB::rollback();
                $res['code']  = 201;
                $res['error'] = "Pasien tersebut belom terdaftar di rumah sakit kami!";
            } else {
                $rajal         = $this->saveRajal($noReg, $dokterPoli, $statusPengunjung, $dataPasien);
                $tagihan       = $this->saveTagihan($noBukti, $dokterPoli, $tarif, $noReg, $params, $dataPasien, $kodePenjamin);
                $rujukan       = $this->saveRujukan($noReg, $dataPasien->no_rm, $params);
                $nomorAntrian  = $this->getAntrian($noReg, $params->tanggalperiksa, $dokterPoli->kd_sub_unit);
                $updateTelepon = $this->putTelepon($dataPasien->no_rm, $params->notelp);

                $res['code'] = 200;
                $res['nomorantrean'] = $nomorAntrian;
                $res['kodebooking'] = $noReg;
                $res['jenisantrean'] = 2;
                $res['estimasidilayani'] = $estimasidilayani;
                $res['namapoli'] = $tarif->nama_sub_unit;
                $res['namadokter'] = $dokterPoli->nama_pegawai;
            }
            DB::commit();
            return $res;
        } catch (Exception $e) {
            DB::rollback();
            $res['code'] = 201;
            $res['error'] = 'Registrasi gagal silahkan cek kembali data anda! ' . $e->getMessage();
            return $res;
        }
    }

    private function saveRujukan($noReg, $noRm, $params)
    {
        $rujukan = DB::connection($this->dbsimrs)->table('rujukan')->insert([
            'no_rujukan' => "-",
            'no_reg' => $noReg,
            'tgl_rujukan' => $params->tanggalperiksa,
            'no_RM' => $noRm
        ]);

        return $rujukan;
    }

    private function saveTagihan($noBukti, $dokterPoli, $tarif, $noReg, $params, $dataPasien, $kodePenjamin)
    {
        return DB::connection($this->dbsimrs)->table('tagihan_pasien')
        ->insert([
            'no_bukti' => $noBukti,
            'no_RM' => $dataPasien->no_rm,
            'no_reg' => $noReg,
            'tgl_tagihan' => $params->tanggalperiksa,
            'kd_sub_unit' => $dokterPoli->kd_sub_unit,
            'kd_sub_unit_asal' => $dokterPoli->kd_sub_unit,
            'kd_penjamin' => $kodePenjamin,
            'idx' => $tarif->idx,
            'kd_tarif' => $tarif->kd_tarif,
            'nama_tarif' => $tarif->nama_tarif,
            'kd_klp_biaya' => $tarif->kd_klp_biaya,
            'kd_kelas' => $tarif->kd_kelas,
            'kd_level' => $tarif->kd_level,
            'hak_kelas' => 3,
            'ba' => $tarif->ba,
            'js' => $tarif->js,
            'jp' => $tarif->jp,
            'anastesi' => $tarif->anastesi,
            'anastesi_cito' => $tarif->anastesi_cito,
            'harga' => $tarif->harga,
            'jumlah' => 1,
            'harga' => $tarif->harga,
            'biaya_jaminan' => $tarif->harga,
            'tunai' => 0,
            'piutang' => $tarif->harga,
            'tagihan' => $tarif->harga,
            'kd_dokter' => $dokterPoli->kd_pegawai,
            'kd_dokter_anastesi' => '-',
            'Asisten_Anastesi' => '-',
            'Asisten_Operasi' => '-',
            'status_bayar' => 'BELUM',
            'user_id' => '00000',
            'tgl_insert' => Carbon::now(),
            'Status_Tagihan' => '1',
            'Rek_P' => $tarif->rek_p
        ]);
    }

    private function saveRajal($noReg, $dokterPoli, $statusKunjungan, $dataPasien)
    {
        $waktuAnamnesa = date("Y-m-d h:i:s");

        return DB::connection($this->dbsimrs)->table('rawat_jalan')->insert([
            'no_reg' => $noReg,
            'no_rm' => $dataPasien->no_rm,
            'kd_poliklinik' => $dokterPoli->kd_sub_unit,
            'kd_cara_kunjungan' => 1,
            'status_kunjungan' => $statusKunjungan,
            'waktu_anamnesa' => $waktuAnamnesa,
            'kd_dokter' => $dokterPoli->kd_pegawai,
            'reg_sms' => 3
        ]);
    }

    private function checkRegister($noRm, $tanggal, $kdPoli)
    {
        return DB::connection($this->dbsimrs)->table('registrasi as r')
                    ->select('r.no_reg','r.no_rm','rj.kd_poliklinik','r.kd_cara_bayar','r.tgl_reg')
                    ->join('rawat_jalan as rj', 'r.no_reg', '=', 'rj.no_reg')
                    ->where([
                        ['r.tgl_reg', '=', $tanggal],
                        ['r.no_rm', '=', $noRm]
                    ])
                    ->where(function($query){
                        $query->where('r.kd_cara_bayar', '=', 8)
                                ->orWhere('r.kd_cara_bayar', '=', 3);
                    })
                    ->first();
    }

    private function getEstimasi($tanggal)
    {
        $estimasi = $tanggal." 08:00:00";
        return strtotime($estimasi);
    }

    private function putTelepon($noRm, $noTelp)
    {
        return DB::connection($this->dbsimrs)->table('pasien')->where('no_rm', '=', $noRm)->update(['no_telp' => $noTelp]);
    }

    private function getAntrian($noReg, $tanggal, $kodePoli)
    {
        $nomorAntrian = DB::connection($this->dbsimrs)->table('rawat_jalan AS RJ')
                        ->join('registrasi AS R', function($join) {
                            $join->on('RJ.no_reg','=', 'R.no_reg');
                        })
                        ->select('RJ.no_reg','RJ.no_RM','R.status_keluar','R.waktu','R.tgl_reg','RJ.kd_poliklinik') 
                        ->where('RJ.kd_poliklinik', '=', $kodePoli)
                        ->where('R.tgl_reg', '=', $tanggal)
                        ->get();
        $nomorAntrian = $nomorAntrian->count();

        $saveAntrian = DB::connection($this->dbsimrs)->table('antrian')->insert([
            'no_reg' => $noReg,
            'no_antrian' => $nomorAntrian,
            'kd_poliklinik' => $kodePoli
        ]);

        return $nomorAntrian;
    }

    private function getTarif($subUnit)
    {
        $dataTarif = DB::connection($this->dbsimrs)->table('tarif_karcis_rj as tkr')->select(
            'tkr.kd_sub_unit','tkr.nama_sub_unit','tkr.harga','tkr.rek_p','tkr.kd_tarif','tkr.nama_tarif',
            'tkr.ba','tkr.js','tkr.jp','t.idx','t.kd_klp_biaya','t.kd_kelas','t.kd_level','t.anastesi',
            't.anastesi_cito'
        )
        ->join('sub_unit as s', function($join) {
            $join->on('tkr.kd_sub_unit', '=', 's.kd_sub_unit')
                ->where('s.enabled', '=', 1); 
        })
        ->join('tarif as t', function($join){
            $join->on('tkr.kd_tarif','=','t.kd_tarif');
        })
        ->where('tkr.kd_sub_unit', '=', $subUnit)
        ->first();
        return $dataTarif;
    }

    private function getNoBukti($tanggal)
    {
        $nomorBukti = "IRJ". date('dmy', strtotime($tanggal));
        $noTagihan = DB::connection($this->dbsimrs)->table('tagihan_pasien')
                    ->where('no_bukti', 'like', $nomorBukti .'%')
                    ->max('no_bukti');
        $urutTagihan = (int) substr($noTagihan, -4);
        $urutTagihan++;
        $newTagihan = $nomorBukti . sprintf("%04s", $urutTagihan);
        return $newTagihan;
    }

    private function getKodePenjamin($nomorKartu, $tanggal)
    {
        $serviceBPjS = new Bridging(config('bpjs.api.consid'), BPJSHelper::timestamp(), BPJSHelper::signature(config('bpjs.api.consid'), config('bpjs.api.seckey')));
        $endpoint = 'Peserta/nokartu/'. $nomorKartu . "/tglSEP/" . $tanggal;
        $result = json_decode($serviceBPjS->getRequest($endpoint));
        if ($result->response != null) {
            $jenisPeserta = $result->response->peserta->jenisPeserta->keterangan;
            $pecah = explode(" ", $jenisPeserta);
            $search = array_search("PBI", $pecah);
            if ($search === false) {
                $kodePenjamin = 24;
            } else {
                $kodePenjamin = 23;
            }
            $kodePenjamin = $kodePenjamin;
        }
        return $kodePenjamin;
    }

    private function generateNomor($tglReg)
    {
        $dataReg = "01". date('dmy', strtotime($tglReg));
        $noReg = DB::connection($this->dbsimrs)->table('registrasi')
                    ->where('no_reg', 'like', $dataReg . '%')
                    ->max('no_reg');
        $noUrut = (int) substr($noReg, -4);
        $noUrut++;
        $newCode = $dataReg . sprintf("%04s", $noUrut);
        return $newCode;
    }

    private function asalFaskes($kodeFaskes)
    {
        $kode = substr($kodeFaskes, 0, 8);
        return DB::connection($this->dbsimrs)->table('faskes_bpjs')->select('jenis_faskes')
                ->where('kode', $kode)->first();
    }

    private function asalPasien($jenisRujukan, $noRujukan)
    {
        if ($jenisRujukan == 1)
        {
            $faskes = $this->asalFaskes($noRujukan); 
            if ($faskes) {
                $asalPasien = (int) $faskes->jenis_faskes;
            } else {
                $asalPasien = 0;
            }
        } else {
            $asalPasien = 0;
        }

        return $asalPasien;
    }

    private function getDataPasien($nomorKartu)
    {
        return DB::connection($this->dbsimrs)->table('penjamin_pasien')->select('no_rm','no_kartu')
                ->where('no_kartu', $nomorKartu)->first();
    }

    private function getDokterPoli($kodePoli, $tanggal)
    {
        return DB::connection($this->dbsimrs)->table('jadwal_dokter_poli_rj as j')
                ->select('j.kd_sub_unit','j.kd_pegawai', 'p.nama_pegawai')
                ->join('sub_unit as s', 'j.kd_sub_unit', '=', 's.kd_sub_unit')
                ->join('pegawai as p', 'j.kd_pegawai', '=', 'p.kd_pegawai')
                ->where([
                    ['s.kd_poli_dpjp', $kodePoli],
                    ['j.kd_hari', Waktu::tanggalToNilai($tanggal)]
                ])
                ->first();
    }

    private function getStatusPengunjung($noRm)
    {
        $data = DB::connection($this->dbsimrs)->table('registrasi')->select('no_rm')
                ->where('no_rm', $noRm)->get();
        
        if ($data->count() != 0) {
            $statusPenunjung = 0;
        } else {
            $statusPenunjung = 1;
        }

        return $statusPenunjung;
    }
}
