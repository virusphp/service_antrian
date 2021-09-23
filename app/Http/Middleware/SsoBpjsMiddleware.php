<?php
namespace App\Http\Middleware;

use Closure;
use App\Repository\Access;
use Illuminate\Support\Facades\Hash;

class SsoBpjsMiddleware
{
    protected $access;

    public function __construct()
    {
        $this->access = new Access;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With, X-Token, X-Signature'
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        if(!$request->hasHeader('x-username') && !$request->hashHeader('x-password')) {
            return response()->jsonApiBpjs(401, "Unautorized", ['messageError' => 'Username atau password salah!']);
        }
        // BELUM DI TERUSKAN
        $param['username'] = $request->header('x-username');
        $param['password'] = $request->header('x-password');
        $accessPlatform = $this->access->checkAccess($param);

        if (!$accessPlatform) {
            return response()->jsonApiBpjs(402, "Not Matching", "Token tidak sesuai");
        }
        if (!Hash::check($param['password'], $accessPlatform->password)) {
            $message = [
                "messageError" => "Password tidak cocok silahkan ulangi!"
            ];
            return response()->jsonApi(403, $message["messageError"]);
        } 

        $response = $next($request);


        foreach($headers as $key => $value)
        {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}