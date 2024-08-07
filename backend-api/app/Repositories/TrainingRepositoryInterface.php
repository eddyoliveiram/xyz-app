<?php

namespace App\Repositories;

use App\Models\Training;

interface TrainingRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function find(int $id);
    public function update(Training $training, array $data);
    public function delete(Training $training);
    public function enrollUser(Training $training, int $userId);
    public function cancelEnrollment(Training $training, int $userId);
    public function updateStatus(Training $training, int $userId, string $status);
    public function getTrainingSummary(int $id);
    public function getTrainingsBySubordinate(int $id);
}
