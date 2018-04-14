<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Symfony\Component\HttpFoundation\Cookie;

class ServiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function serve(Request $request)
    {
	    $host = $request->getHost();

    	$token = $request->cookie('jwt', false);
    	if (! $token) {
    		return redirect('http://auth.'.$host.'/login.html');
	    }

	    $decodedToken = (new Parser())->parse((string)$token);
	    $signer = new Sha256();
    	if (! $decodedToken->verify($signer, env('JWT_SECRET', 'testing'))) {
    		return "Fake token";
	    }
	    $login = $decodedToken->getClaim('login');
    	$permissions = $decodedToken->getClaim('permissions');
	    $message = "
		This is service 2. </br>
		Your JWT: $token </br></br>
		Hi, <b>{$login}</b>! Your permissions: <b>" . join(',', $permissions) . '</b> <br/>
		<a href="/logout">Logout</a>
		';
	    return $message;
    }

    public function logOut(Request $request)
    {
	    $host = $request->getHost();
	    return redirect('http://'.$host.'/service', 302)->withCookie(new Cookie('jwt', false, 0, '/', $host));
    }

    //
}
