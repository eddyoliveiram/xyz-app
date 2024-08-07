<?php

namespace App\Repositories;

use App\Models\Training;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function allNonAdminUsers()
    {
        return User::where('is_admin', false)->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make(123);
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        $user->delete();
    }

    public function allTrainingsForUser(User $user)
    {
        $trainings = Training::all();
        $enrolledTrainings = $user->trainings()->get();

        $trainings = $trainings->map(function ($training) use ($enrolledTrainings) {
            $enrolledTraining = $enrolledTrainings->firstWhere('id', $training->id);
            $training->is_enrolled = $enrolledTraining ? true : false;
            $training->status = $enrolledTraining ? $enrolledTraining->pivot->status : null;
            return $training;
        });

        return $trainings;
    }

    public function completedTrainingsForUser(User $user)
    {
        return $user->trainings()->wherePivot('status', 'completed')->get();
    }
}
