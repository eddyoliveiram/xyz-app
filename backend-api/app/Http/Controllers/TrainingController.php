<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingRequest;
use App\Repositories\TrainingRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    protected $trainingRepository;

    public function __construct(TrainingRepositoryInterface $trainingRepository)
    {
        $this->trainingRepository = $trainingRepository;
    }

    public function index()
    {
        return $this->trainingRepository->all();
    }

    public function store(TrainingRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $training = $this->trainingRepository->create($data);

        return response()->json($training, 201);
    }

    public function show($id)
    {
        return $this->trainingRepository->find($id);
    }

    public function update(TrainingRequest $request, $id)
    {
        $training = $this->trainingRepository->find($id);
        $training = $this->trainingRepository->update($training, $request->validated());

        return response()->json($training, 200);
    }

    public function destroy($id)
    {
        $training = $this->trainingRepository->find($id);
        $this->trainingRepository->delete($training);

        return response()->json(null, 204);
    }

    public function enroll(Request $request, $id)
    {
        $training = $this->trainingRepository->find($id);
        $this->trainingRepository->enrollUser($training, Auth::id());

        return response()->json(['message' => 'Enrolled successfully'], 200);
    }

    public function cancelEnrollment(Request $request, $id)
    {
        $training = $this->trainingRepository->find($id);
        $this->trainingRepository->cancelEnrollment($training, Auth::id());

        return response()->json(['message' => 'Enrollment cancelled successfully'], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $training = $this->trainingRepository->find($id);
        $this->trainingRepository->updateStatus($training, Auth::id(), $request->status);

        return response()->json(['message' => 'Status updated successfully'], 200);
    }
}
