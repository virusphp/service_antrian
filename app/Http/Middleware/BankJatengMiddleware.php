<?php
namespace App\Http\Middleware;

use Closure;
use App\Repository\Access;

class BankJatengMiddleware
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
            'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With, X-API-Key'
        ];

        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        if(!$request->hasHeader('X-API-Key')) {
            return response()->jsonApiBPD(401, "Unautorized", ['messageError' => 'Need Token to Access this URL!']);
        }

        $token = $request->header('X-API-Key');
        $accessPlatform = $this->access->checkAccessApi($token);
        if (!$accessPlatform) {
            return response()->jsonApiBPD(402, "Not Matching", "Token tidak sesuai");
        }

        $response = $next($request);

        foreach($headers as $key => $value)
        {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}