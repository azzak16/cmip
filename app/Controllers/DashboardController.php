<?php 
namespace App\Controllers;

use Core\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // if (!\Core\Auth::check()) {
        //     header('Location: /login');
        //     exit;
        // }
        

        $this->view('Dashboard/index', ['title' => 'Dashboard']);
    }
}
