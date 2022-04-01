<<<<<<< HEAD
<?php
return [
	'api' => [
		'endpoint_vclaim'  => env('API_VCLAIM_BPJS','ENDPOINT-KAMU'),
		'endpoint_antrol'  => env('API_ANTROL_BPJS','ENDPOINT-KAMU'),
		'consid'  => env('CONS_ID','API-KAMU'),
		'seckey' => env('SECRET_ID', 'API-KAMU'),
	]
=======
<?php
return [
	'api' => [
		'endpoint'  => env('API_BPJS','ENDPOINT-KAMU'),
		'consid'  => env('CONS_ID','API-KAMU'),
		'seckey' => env('SECRET_ID', 'API-KAMU'),
	]
>>>>>>> af0453c07bd5b1ca28aea1665f1a2fec9adf0e26
];