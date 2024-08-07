<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return User::where('is_admin', false)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->login = $request->login;
        $user->email = $request->email;
        $user->password = Hash::make(123);
        $user->save();

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'login' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
    public function allTrainings(User $user)
    {
        $trainings = Training::all();
        $enrolledTrainings = $user->trainings()->get();

        $trainings = $trainings->map(function ($training) use ($enrolledTrainings) {
            $enrolledTraining = $enrolledTrainings->firstWhere('id', $training->id);
            $training->is_enrolled = $enrolledTraining ? true : false;
            $training->status = $enrolledTraining ? $enrolledTraining->pivot->status : null;
            return $training;
        });

        return response()->json($trainings);
    }

    public function completedTrainings(User $user)
    {
        $completedTrainings = $user->trainings()->wherePivot('status', 'completed')->get();
        return response()->json($completedTrainings);
    }

}
