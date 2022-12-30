<?php

namespace App\Http\Controllers\ApiSIMRS\Apm;

use App\Http\Controllers\Controller;
use App\Repository\Antrian;
use App\Repository\Apm\Sep;
use App\Repository\Registrasi;
use App\Models\SepBpjs;
use App\Models\Pendaftaran;
use App\Models\Rujukan as AppRujukan;
use App\Models\Task;
use App\Transform\TransformRegistrasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApmController extends Controller
{
    protected $registrasi;
    protected $antrian;
    protected $transform;
    protected $serviceBpjs;

    public function __construct()
    {
        $this->registrasi = new Registrasi;
        $this->antrian = new Antrian;
        $this->transform = new TransformRegistrasi;
        $this->serviceBpjs = new Sep;
    }

    public function dataRegistrasi($noRm)
    {
        $dataRegistrasi = $this->registrasi->dataRegistrasi($noRm);

        if (!$dataRegistrasi) {
            $error['messageError'] = "Data Registrasi pasien tidak ditemukan!!";
            return response()->jsonApi("201", $error['messageError']);
        }

        $dataAntrian = $this->antrian->dataAntrian($dataRegistrasi);
        $checkSKU = $this->registrasi->checkSuratKontrol($noRm, $dataRegistrasi->kd_poli_dpjp);
        $sku = $checkSKU == null ? '0' : '1';
        $transform = $this->transform->mapDataRegistrasi($dataRegistrasi, $dataAntrian, $sku);

        return response()->jsonApi("200", "OK", $transform);
    }

    public function dataSuratKontrol($code)
    {
        $dataSuratkontrol = $this->registrasi->dataSuratkontrol($code);
        if (!$dataSuratkontrol) {
            $error['messageError'] = "Code surat rencana kontrol tidak ditemukan!!";
            return response()->jsonApi("201", $error['messageError']);
        }

        $transform = $this->transform->mapDataSuratkontrol($dataSuratkontrol);
        return response()->jsonApi("200", "OK", $transform);
    }

    public function jumlahSep($jnsRujukan, $noRujukan)
    {
        return $this->serviceBpjs->jumlahSep($jnsRujukan, $noRujukan);
    }

    public function insertSep(Request $request)
    {
        $requestSep = $request->all();
        $result = $this->serviceBpjs->insertSep($requestSep);
        $res = json_decode($result);
        $requestSep = $requestSep['request'];
        if ($res->metaData->code == 200) {
            if ($res->response->sep->peserta->noKartu == $requestSep['t_sep']['noKartu'] && $res->response->sep->peserta->noMr == $requestSep['t_sep']['noMR']) {
                DB::beginTransaction();
                try {
                    // dd($requestSep, $res->response->sep);
                    $dataInsert = $this->handleRequestData($requestSep, $res->response->sep);
                    // dd($dataInsert);
                    $this->simpanSep($dataInsert);
                    $this->simpanRujukan($requestSep, $dataInsert);
                    $this->simpanTask($dataInsert['task']);
                    DB::commit();
                    return $result;
                } catch (Exception $e) {
                    DB::rollback();
                    if ($e->getCode() == "23000") {
                        return $result;
                    }
                }
            } else {
                $message = $this->getMessage($result);
                return $message;
            }
        } else {
            return $result;
        }
    }

    protected function simpanSep($params)
    {
        $simpanSep = SepBpjs::create($params['sep_bpjs']);
        if ($simpanSep) {
            Pendaftaran::where('no_reg', $params['sep_bpjs']['no_reg'])->update($params['update_sep']);
        }
        return $simpanSep;
    }

    protected function simpanRujukan($request, $data)
    {
        if ($request['t_sep']['jnsPelayanan'] == 2) {
            $uRujukan = AppRujukan::where('no_reg', '=', $request['sep_internal']['no_reg'])
                ->update($data['update_rujukan']);

            if (!$uRujukan) {
                $uRujukan = AppRujukan::create($data['rujukan']);
            }
        } else {
            $uRujukan = AppRujukan::where('no_reg', '=', $request['sep_internal']['no_reg'])
                ->first();

            if (!$uRujukan) {
                $uRujukan = AppRujukan::create($data['rujukan']);
            }
        }

        return $uRujukan;
    }

    protected function simpanTask($data)
    {
        return Task::upsert($data, ['kodebooking', 'taskid']);
    }

    protected function getMessage($result)
    {
        $data['metaData'] = [
            'code' => 201,
            'message' => 'Sep Dengan No : ' . $result->response->sep->noSep . ' Adalah jaminan A/N : ' . $result->response->sep->peserta->nama
            // 'message' => 'Sep Dengan No : XXXX Adalah jaminan A/N : UUUU'
        ];
        $data['response'] = null;

        return $data;
    }

    protected function handleRequestData($params, $responseSep)
    {
        // dd($params, $responseSep);
        date_default_timezone_set('Asia/Jakarta');
        $data['sep_bpjs'] = [
            'no_reg' => $params['sep_internal']['no_reg'],
            'no_sjp' => $responseSep->noSep,
            'cob' => $params['t_sep']['cob']['cob'],
            'kd_faskes' => $params['t_sep']['rujukan']['ppkRujukan'],
            'nama_faskes' => $params['sep_internal']['nama_faskes'],
            'kd_diagnosa' => $params['t_sep']['diagAwal'],
            'nama_diagnosa' => $responseSep->diagnosa,
            'kd_poli' => $params['t_sep']['poli']['tujuan'],
            'nama_poli' => $params['sep_internal']['nama_poli'],
            'kd_kelas_rawat' => "3",
            'nama_kelas_rawat' => $responseSep->peserta->hakKelas,
            'no_rujukan' => $params['t_sep']['rujukan']['noRujukan'],
            'asal_faskes' => $params['t_sep']['rujukan']['asalRujukan'],
            'tgl_rujukan' => $params['t_sep']['rujukan']['tglRujukan'],
            'lakalantas' => $params['t_sep']['jaminan']['lakaLantas'],
            'no_surat_kontrol' => $params['sep_internal']['no_sku'],
            'kd_dpjp' => $params['t_sep']['skdp']['kodeDPJP'],
            'tujuan_kunjungan' => $params['t_sep']['tujuanKunj'],
            'flag_prosedur' => $params['t_sep']['flagProcedure'],
            'kode_penunjang' => $params['t_sep']['kdPenunjang'],
            'assesment_pelayanan' => $params['t_sep']['assesmentPel'],
            'dpjp_pelayanan' => $params['t_sep']['dpjpLayan'],
            'catatan' => $params['t_sep']['catatan'],
            'tgl_sep' => $params['t_sep']['tglSep'],
            'tgl_kejadian' => $params['t_sep']['jaminan']['penjamin']['tglKejadian'],
            'suplesi' => $params['t_sep']['jaminan']['penjamin']['suplesi']['suplesi'],
            'no_suplesi' => $params['t_sep']['jaminan']['penjamin']['suplesi']['noSepSuplesi'],
            'kd_prop' => $params['t_sep']['jaminan']['penjamin']['suplesi']['lokasiLaka']['kdPropinsi'],
            'kd_kab' => $params['t_sep']['jaminan']['penjamin']['suplesi']['lokasiLaka']['kdKabupaten'],
            'kd_kec' => $params['t_sep']['jaminan']['penjamin']['suplesi']['lokasiLaka']['kdKecamatan'],
        ];

        $data['update_sep'] = [
            'no_sjp' => $responseSep->noSep,
        ];

        $data['rujukan'] = [
            'no_rujukan' => $params['t_sep']['rujukan']['noRujukan'],
            'no_reg' => $params['sep_internal']['no_reg'],
            'no_rm' => $params['t_sep']['noMR'],
            'tgl_rujukan' => $params['t_sep']['rujukan']['tglRujukan'],
            'kd_instansi' => $params['sep_internal']['kode_instansi'],
            'nama_pengirim' => '-',
            'kd_icd' => '-',
            'kd_smf' => '-',
            'diagnosa_sementara' => ""
        ];

        $data['update_rujukan'] = [
            'no_rujukan' => $params['t_sep']['rujukan']['noRujukan'],
            'kd_instansi' => $params['sep_internal']['kode_instansi']
        ];

        $data['task']  = [
            'kodebooking' => $params['sep_internal']['no_reg'],
            'taskid' => 3,
            'waktu' => time() * 1000,
            'code' => 200,
            'message' => "belum di kirim",
            'status' => 0
        ];

        return $data;
    }
}
