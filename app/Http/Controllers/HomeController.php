<?php

namespace App\Http\Controllers;

use App\Model\User;
use Exception;
use Kernel\Application\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        throw new Exception('Error');
        abort(404, 'Сторінка не знайдена');

        $users = User::paginate(5);

        return view('home', [
            'users'        => $users['data'],
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
