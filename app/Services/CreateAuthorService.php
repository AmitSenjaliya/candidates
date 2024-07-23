<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Traits\CurlTrait;

/**
 * Class CreateAuthorService
 *
 * @category App\Repositories
 */
class CreateAuthorService
{
    use CurlTrait;

    public function __construct()
    {
    }


    public function createAuthor($data)
    {
        $route = env('API_URL').'/api/v2/token';
        $params = [
            'email' => env('USER_EMAIL'),
            'password' => env('USER_PASSWORD'),
        ];
        $response = $this->callExternalPostApi($route, $params);
        if (isset($response['code']) && $response['code'] != 200) {
            return ['error' => 1, 'msg' => 'Error from token Api.'];
        }
        $token = $response['token_key'];
        $route = env('API_URL').'/api/v2/authors';
        $book = $this->callExternalPostWithHeaderApi($route, $token, $data);
        if (isset($book['code']) && $book['code'] != 200) {
            return ['error' => 1, 'msg' => 'Error from Api.'];
        }
        return ['error' => 0, 'msg' => 'Author created successfully.'];
    }
}