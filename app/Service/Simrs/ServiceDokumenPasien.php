<?php

namespace App\Service\Simrs;

use App\Repository\DokumenPasien;

class ServiceDokumenPasien 
{
	public function handleId()
	{
		$dok = new DokumenPasien;
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
	
	public function handleFile($params)
	{
		$data = $params->all();
        if (!isset($data['id_file'])) {
            $data['id_file'] = $this->handleId();
        } 
        $data['id_file'] = $data['id_file'];


        if ($params->hasFile('file_pasien')) {
            $file =  $params->file('file_pasien');
            $extensi = $file->getClientOriginalExtension();
            $formatName = $data['no_rm'] .'_'. $data['id_file'] . '.' . $extensi;
            $pathFile = $this->handleDestination($data['no_rm']);

            $urlPath = $data['no_rm'] .'/' . $formatName;
            $file->storeAs($pathFile, $formatName);
            

            $data['file_pasien'] = $formatName;
            $data['full_path'] = $urlPath;
        }

        return $data;
	}

	public function handleDestination($noRm)
	{
		 return 'public'. DIRECTORY_SEPARATOR. 'pasien'. DIRECTORY_SEPARATOR .$noRm . DIRECTORY_SEPARATOR;
	}

}