<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use \Symfony\Component\HttpFoundation\Cookie;

class LoginController extends Controller
{
	protected $host;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
	    $host = $request->getHost();
	    $parts = explode('.', $host);
	    unset($parts[0]);
	    $this->host = join('.', $parts);
    }



    public function login(Request $request)
    {
	    $login = $request->get('login', false);
	    $password = $request->get('password', false);

	    if (
		    $login !== 'user' or
		    $password !== 'secret'
	    ) {
		    return "Bad creds";
	    }
	    $permissions = ['perm-1', 'perm-2', 'perm-3', 'perm-4'];
	    $signer = new Sha256();
	    $token = (new Builder())
		    ->setIssuedAt(time())
		    ->setNotBefore(time() + 60)
		    ->setExpiration(time() + 3600)
		    ->set('login', $login)
		    ->set('permissions', $permissions)
		    ->sign($signer, env('JWT_SECRET', 'testing'))
		    ->getToken();

	    return redirect('http://'.$this->host.'/service', 302)->withCookie(new Cookie('jwt', (string) $token, 0, '/', $this->host));

//	    $decodedToken = (new Parser())->parse((string)$token);
//	    return [
//	    	'token' => (string)$token,
//		    'decodedToken' => $decodedToken->getClaims()
//	    ];
    }
    //
}
