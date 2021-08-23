<?php

namespace App\Http\Controllers\ApiSIMRS;

use App\Http\Controllers\Controller;
use App\Http\Resources\DokumenResource;
use App\Repository\DokumenPasien as AppDokumenPasien;
use App\Validation\DokumenPasien;
use App\Validation\UpdateDokumenPasien;
use Illuminate\Http\Request;
use File;

class DokumenPasienController extends Controller
{
    protected $dokumenPasien;

    public function __construct()
    {
       $this->dokumenPasien = new AppDokumenPasien;
    }

    /**
     * Simpan Dokumen
     */
    public function simpanDokumen(Request $r, DokumenPasien $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonSimrs(422, implode(",",$message));    
        }
        $data = $this->handleFile($r);
        $respon = $this->dokumenPasien->simpan($data);

        if (!$respon) {
            return response()->jsonSimrs(201, "Terjadi kesalahan data input masih salah");
        }

        $transform = new DokumenResource($respon);

        return response()->jsonSimrs(200, "OK", $transform);
    }

    /**
     * Update Dokumen
     */
    public function updateDokumen(Request $r, UpdateDokumenPasien $valid)
    {
        $validate = $valid->rules($r);

        if ($validate->fails()) {
            $message = $valid->messages($validate->errors());
            return response()->jsonSimrs(422, implode(",",$message));    
        }

        $checkData = $this->dokumenPasien->checkData($r->id_file);

        $oldFile = $checkData->file_pasien;

        $data = $this->handleFile($r);

        $respon = $this->dokumenPasien->update($data);

        if (!$respon) {
            return response()->jsonSimrs(201, "Terjadi kesalahan data input masih salah");
        }

        if ($oldFile !== $respon->file_pasien) {
           $this->deleteImage($data['no_rm'], $oldFile); 
        }

        $transform = new DokumenResource($respon);

         return response()->jsonSimrs(200, "OK", $transform);
    }

    /**
     * Show Dokumen
     */
    public function showDokumen($idFile)
    {
        $checkData = $this->dokumenPasien->checkData($idFile);
        if (!$checkData) {
            return response()->jsonSimrs(201, "Data tidak di temukan!!");
        }

        $transform = new DokumenResource($checkData);
        
        return response()->jsonSimrs(200, "OK", $transform);
    }

    /**
     * Delete Dokumen
     */
    public function deleteDokumen(Request $r)
    {
        $checkData = $this->dokumenPasien->checkData($r->id_file);
  
        if (!$checkData) {
            return response()->jsonSimrs(201, "Data tidak di temukan!!");
        }

        $dokumenPasien = $this->dokumenPasien->deleteDokumen($r->id_file);

        if (!$dokumenPasien) {
            return response()->jsonSimrs(201, "Data tidak di temukan!!");
        }

        return response()->jsonSimrs(200, "Data $r->id_file berhasil di hapus!");

    }

    /**
     * Delete Image
     */
    protected function deleteImage($noRm, $oldFile)
    {
        $path = storage_path() . DIRECTORY_SEPARATOR . $this->getDestination($noRm) . $oldFile;
        return File::delete($path);
    }

    protected function handleFile($request)
    {
        $data = $request->all();
        if (!isset($data['id_file'])) {
            $data['id_file'] = $this->handleId();
        } 
        $data['id_file'] = $data['id_file'];


        if ($request->hasFile('file_pasien')) {
            $file =  $request->file('file_pasien');
            $extensi = $file->getClientOriginalExtension();
            $formatName = $data['no_rm'] .'_'. $data['id_file'] . '.' . $extensi;
            $pathFile = $this->getDestination($data['no_rm']);

            $urlPath = $data['no_rm'] .'/' . $formatName;
            $file->storeAs($pathFile, $formatName);
            

            $data['file_pasien'] = $formatName;
            $data['full_path'] = $urlPath;
        }

        return $data;
    }

    private function getDestination($noRm)
    {
        return 'public'. DIRECTORY_SEPARATOR. 'pasien'. DIRECTORY_SEPARATOR .$noRm . DIRECTORY_SEPARATOR;
    }


    private function handleId()
    {
        $dok = new AppDokumenPasien;
        $prefix = "FILE";
        $maxNumber = trim($dok->getMaxNumber($prefix));

        if (!$maxNumber) {
            
            $start = 1;
            $noUrut = $prefix . date('ymd') . sprintf("%03s", $start);

            return $noUrut;
        }

        $noUrut = (int) substr($maxNumber, -3);
        $noUrut++;
        $newNoUrut = $prefix. date('ymd'). sprintf("%03s", $noUrut);
        return $newNoUrut;
    }

}
