<?php
namespace App\Http\Modules\ECommerce\Infrastructure\Service;

use App\Http\Modules\ECommerce\Domain\Service\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function persist(User $user)
    {
        $data = $this->createPayload($user);

        DB::table('users')->upsert($data, 'id');
    }

    public function getById(int $user_id)
    {

    }

    public function createPayload(User $user)
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone(),
            'email_verified_at' => $user->getVerifiedAt(),
            'photo_url' => $user->photo_url(),
            'password' => Hash::make($user->getPassword()),
            'bank_actnumber' => $user->getBankActNumber(),
            'is_admin' => $user->isAdmin(),
        ]
    }
}