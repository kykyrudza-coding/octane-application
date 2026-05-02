<?php

namespace App\Http\Controllers;

use App\Model\User;
use Kernel\Application\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $users = User::paginate(5);

        cache()->set('users', $users);

        return view('home', [
            'users'        => cache()->get('users'),
            'current_page' => $users['current_page'],
            'total_pages'  => $users['total_pages'],
        ]);
    }

    public function get(): View
    {
        return view('get', [
            'get' => 'Привіт, світ!',
        ]);
    }
}
