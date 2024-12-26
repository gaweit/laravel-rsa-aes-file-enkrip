<?php

namespace App\Http\Controllers\Main;

use App\Models\User;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Pengetahuan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index()
    {
        // $data['userCount'] = User::count();
        // $data['gejalaCount'] = Gejala::count();
        // $data['penyakitCount'] = Penyakit::count();
        // $data['pengetahuanCount'] = Pengetahuan::count();
        $data['title'] = 'Dashboard';
        return view('main.home.home', $data);
    }
    function test()
    {
        // $data['user'] = User::findAll();
        $data['title'] = 'Test';
        return view('main.home.test', $data);
    }
}
