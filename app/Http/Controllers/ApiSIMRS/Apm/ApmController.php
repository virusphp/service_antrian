<?php

namespace App\Http\Controllers\ApiSIMRS\Apm;

use App\Http\Controllers\Controller;
use App\Repository\Antrian;
use App\Repository\Registrasi;
use App\Transform\TransformRegistrasi;

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
        $this->serviceBpjs = new repoSep;
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

    public function insertSep(Request $request)
    {
        $requestSep = $request->all();
        $result = $this->serviceBpjs->insertSep($requestSep);
        $res = json_decode($result);
        $requestSep = json_decode($requestSep)->request->t_sep;
        if ($res->metaData->code == 200) {
            if ($res->response->sep->peserta->noKartu == $requestSep->noKartu && $res->response->sep->peserta->noMr == $requestSep->noMR) {
                DB::beginTransaction();
                try {
                    $dataInsert = $this->handleRequestData($requestSep, $res->response->sep->noSep);
                    // $dataInsert = $this->handleRequestData($params);
                    $this->simpanSep($dataInsert);
                    // dd($insert);
                    $this->simpanRujukan($requestSep, $dataInsert);

                    // $this->serviceTask->sendTask(json_encode($dataInsert["task"]));
                    DB::commit();
                    return $result;
                } catch (\Illuminate\Database\QueryException $e) {
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
}
