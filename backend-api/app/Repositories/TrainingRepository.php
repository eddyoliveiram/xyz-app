<?php

namespace App\Repositories;

use App\Models\Training;
use App\Models\User;

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

    public function getTrainingSummary(int $id)
    {
        $training = Training::with(['subordinates' => function ($query) {
            $query->select('users.id', 'users.name', 'subordinate_training.training_id', 'subordinate_training.subordinate_id', 'subordinate_training.status');
        }])->findOrFail($id);

        $subordinates = $training->subordinates;
        $statusCounts = $subordinates->groupBy('pivot.status')->map->count();

        return [
            'title' => $training->title,
            'subordinates_count' => $subordinates->count(),
            'statuses' => [
                'not_started' => $statusCounts->get('not_started', 0),
                'in_progress' => $statusCounts->get('in_progress', 0),
                'aproved' => $statusCounts->get('aproved', 0),
                'reproved' => $statusCounts->get('reproved', 0),
            ]
        ];
    }

    public function getTrainingsBySubordinate(int $id)
    {
        $user = User::findOrFail($id);

        $trainings = $user->trainings()->select('trainings.id', 'trainings.title', 'trainings.description', 'subordinate_training.status')->get();

        return $trainings->map(function ($training) {
            return [
                'id' => $training->id,
                'title' => $training->title,
                'description' => $training->description,
                'status' => $training->pivot->status,
            ];
        });
    }
}
