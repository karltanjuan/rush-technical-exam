<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return Inertia::render('Dashboard', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Create');
    }

    public function edit(User $user)
    {
        return Inertia::render('User/Edit', [
            'user' => $user
        ]);
    }
}
