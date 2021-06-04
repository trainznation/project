<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * DashboardController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function dashboard()
    {
        $user = $this->user->newQuery()->find(auth()->user()->id);
        //dd($user->projects);

        return view('dashboard', compact('user'));
    }
}
