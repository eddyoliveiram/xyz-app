<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    public function index()
    {
        return Training::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $training = new Training($request->all());
        $training->user_id = Auth::id();
        $training->save();

        return response()->json($training, 201);
    }

    public function show(Training $training)
    {
        return $training;
    }

    public function update(Request $request, Training $training)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        ]);

        $training->update($request->all());

        return response()->json($training, 200);
    }

    public function destroy(Training $training)
    {
        $training->delete();

        return response()->json(null, 204);
    }

    public function enroll(Request $request, Training $training)
    {
        $user = Auth::user();
        $training->subordinates()->attach($user, ['status' => 'not_started']);

        return response()->json(['message' => 'Enrolled successfully'], 200);
    }

    public function cancelEnrollment(Request $request, Training $training)
    {
        $user = Auth::user();
        $training->subordinates()->detach($user);

        return response()->json(['message' => 'Enrollment cancelled successfully'], 200);
    }

    public function updateStatus(Request $request, Training $training)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $user = Auth::user();
        $training->subordinates()->updateExistingPivot($user->id, ['status' => $request->status]);

        return response()->json(['message' => 'Status updated successfully'], 200);
    }

}
