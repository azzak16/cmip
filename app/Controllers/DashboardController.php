<?php 
namespace App\Controllers;

use Core\Auth;
use Core\Controller;
use Core\Router;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            $this->redirect('/cmip/login');
        }

        $this->view('Dashboard/index', ['title' => 'Dashboard'], 'layouts/main');
    }
}
