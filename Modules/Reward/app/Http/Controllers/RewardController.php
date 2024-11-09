<?php

namespace Modules\Reward\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Reward\Models\Reward;
use App\Models\User;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::with('user')->paginate(10);
        return view('reward::index', compact('rewards'));
    }

    public function create()
    {
        $users = User::all();
        return view('reward::create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer|min:0',
            'redeemed_points' => 'nullable|integer|min:0|max:' . $request->points,
        ]);

        Reward::create($request->all());

        return redirect()->route('rewards.index')->with('success', 'Recompensa creada exitosamente.');
    }

    public function edit($id)
    {
        $reward = Reward::findOrFail($id);
        $users = User::all();
        return view('reward::edit', compact('reward', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer|min:0',
            'redeemed_points' => 'nullable|integer|min:0|max:' . $request->points,
        ]);

        $reward = Reward::findOrFail($id);
        $reward->update($request->all());

        return redirect()->route('rewards.index')->with('success', 'Recompensa actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $reward = Reward::findOrFail($id);
        $reward->delete();

        return redirect()->route('rewards.index')->with('success', 'Recompensa eliminada exitosamente.');
    }
}
