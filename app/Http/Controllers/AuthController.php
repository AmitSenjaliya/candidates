<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\CurlTrait;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;

class AuthController extends Controller
{
    use CurlTrait;

    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct(public UserRepository $userRepository)
    {
    }

    /**
     * Show login page.
     *
     * @return view
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login using Candidate API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $route = env('API_URL').'/api/v2/token';
            $data = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            $response = $this->callExternalPostApi($route, $data);
            if (isset($response['status']) && $response['status'] != 200) {
                return redirect()->route('login')->withErrors(['Invalid credentials. Please try again.']);
            }
            session(['api_token' => $response['token_key']]);

            $user = $this->userRepository->createOrUpdateUser($response, $request);
            session(['user' => $user->name]);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([$e->getMessage()]);
        }
    }
}