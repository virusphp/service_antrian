<?php

namespace App\Http\Traits;

trait ImageTrait 
{
	protected function getBio($noRm, $namaFile)
	{
		return url('storage/pasien') .DIRECTORY_SEPARATOR . $noRm . DIRECTORY_SEPARATOR . $namaFile;
	}
}