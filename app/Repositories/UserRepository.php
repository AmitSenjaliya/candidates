<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository
 *
 * @category App\Repositories
 */
class UserRepository
{
    public function __construct(public User $user)
    {
    }


    public function createOrUpdateUser($response, $request)
    {
        $user = $response['user'];
        return $this->user->updateOrCreate(
            ['email' => $user['email']],
            [
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'password' => Hash::make($request->password),
                'api_token' => $response['token_key'],
            ],
        );
    }
}