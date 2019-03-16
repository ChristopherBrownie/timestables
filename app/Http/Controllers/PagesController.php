<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    // GET
    public function showLeaderboard(User $user = null)
    {
        //$users = User::all();
        $fullUsersCollection = User::orderBy('completionTime', 'asc')->latest()->get();
        $users = User::orderBy('completionTime', 'asc')->latest()->paginate(20);

        $player = null;
        if (!is_null($user)) {
            $player = $user;
            $player->rank = $fullUsersCollection->search($user) + 1;
        }

        return view('leaderboard')->with(['users' => $users, 'player' => $player]);
    }

    // POST
    public function storeUser(Request $request)
    {
        $attributes = ['completionTime' => $request->input('truth')];
        $user = User::create($attributes);
        $token = $user->id . "-" . str_random(20);
        User::where('id', $user->id)->update(['token' => $token]);
        return $token;
    }

    // POST
    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'userToken' => 'required'
        ]);
        $token = $request->userToken;
        $name = $request->name;
        User::where('token', $token)->update(['name' => $name]);

        $player = explode("-", $token);
        return redirect('/leaderboard/' . $player[0]);
    }
}
