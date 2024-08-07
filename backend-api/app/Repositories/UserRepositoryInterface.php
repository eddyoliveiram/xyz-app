<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface
{
    public function allNonAdminUsers();
    public function findById($id);
    public function create(array $data);
    public function update(User $user, array $data);
    public function delete(User $user);
    public function allTrainingsForUser(User $user);
    public function completedTrainingsForUser(User $user);
}
