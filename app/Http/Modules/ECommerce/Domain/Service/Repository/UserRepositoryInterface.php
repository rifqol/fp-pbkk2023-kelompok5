<?php
namespace App\Http\Modules\ECommerce\Domain\Service\Repository;

use App\Http\Modules\ECommerce\Domain\Models\User;

interface UserRepositoryInterface
{
    public function getById(int $user_id);
    public function persist(User $user);
}