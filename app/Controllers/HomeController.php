<?php 
namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        
        $this->view('home/index', ['title' => 'Dashboard']);
    }
}
