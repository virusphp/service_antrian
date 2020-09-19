<?php

namespace App\Repository;

use DB;
use Carbon\Carbon;
use Exception;

class Antrian
{
    public function postAntrian($params)
    {
        $dataPasien = $this->getDataPasien($params->nomorkartu);
    }

    private function getDataPasien($nomorKartu)
    {
        
    }
}
