<?php 
namespace App\Controllers;

use Core\Controller;
use Core\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $this->redirect('/cmip/');
        }
        $this->view('auth/login');
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (Auth::attempt($username, $password)) {
            $this->redirect('/cmip/');
        } else {
            $_SESSION['error'] = 'Username atau Password salah!';
            $this->redirect('/cmip/login');
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('/cmip/login');
    }
}
