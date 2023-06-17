<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoginService;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $response = $this->loginService->logout($request);
        return response()->json($response);
    }
}
