<?php

namespace App\Repositories;

use App\Models\Training;

class TrainingRepository implements TrainingRepositoryInterface
{
    public function all()
    {
        return Training::all();
    }

    public function create(array $data)
    {
        return Training::create($data);
    }

    public function find(int $id)
    {
        return Training::findOrFail($id);
    }

    public function update(Training $training, array $data)
    {
        $training->update($data);
        return $training;
    }

    public function delete(Training $training)
    {
        $training->delete();
    }

    public function enrollUser(Training $training, int $userId)
    {
        $training->subordinates()->attach($userId, ['status' => 'not_started']);
    }

    public function cancelEnrollment(Training $training, int $userId)
    {
        $training->subordinates()->detach($userId);
    }

    public function updateStatus(Training $training, int $userId, string $status)
    {
        $training->subordinates()->updateExistingPivot($userId, ['status' => $status]);
    }
}
