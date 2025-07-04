<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;

class HomeController
{
    public function index(): RedirectResponse
    {
        return redirect()->to('admin/users');
    }
}
