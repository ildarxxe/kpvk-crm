<?php
namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepository $repository) {}

    public function getUserByPhone(string $phone)
    {
        return $this->repository->findByPhone($phone);
    }

    public function checkPassword($user, $password): bool
    {
        return Hash::check($password, $user->password);
    }

    public function create(array $data, $device_name): array
    {
        $user = $this->repository->create($data);
        $token = $user->createToken($device_name)->plainTextToken;

        return [
            'status' => 'success',
            'user' => $user,
            'token' => $token
        ];
    }
}
