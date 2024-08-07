<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->userRepository->allNonAdminUsers();
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make(123);

        $user = $this->userRepository->create($validated);
        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return $this->userRepository->findById($user->id);
    }

    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        $updatedUser = $this->userRepository->update($user, $validated);
        return response()->json($updatedUser, 200);
    }

    public function destroy(User $user)
    {
        $this->userRepository->delete($user);
        return response()->json(null, 204);
    }

    public function allTrainings(User $user)
    {
        $trainings = $this->userRepository->allTrainingsForUser($user);
        return response()->json($trainings);
    }

    public function completedTrainings(User $user)
    {
        $completedTrainings = $this->userRepository->completedTrainingsForUser($user);
        return response()->json($completedTrainings);
    }
}
