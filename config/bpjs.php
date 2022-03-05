<?php
return [
	'api' => [
		'endpoint_vclaim'  => env('API_VCLAIM_BPJS','ENDPOINT-KAMU'),
		'endpoint_antrol'  => env('API_ANTROL_BPJS','ENDPOINT-KAMU'),
		'consid'  => env('CONS_ID','API-KAMU'),
		'seckey' => env('SECRET_ID', 'API-KAMU'),
	]
];