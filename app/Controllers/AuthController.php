<?php 
namespace App\Controllers;

use Core\Controller;
use Core\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            $this->redirect('/');
        }
        $this->view('auth/login');
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = hash('sha256', $_POST['password']);

        if (Auth::attempt($username, $password)) {
            $this->redirect('/');
        } else {
            $_SESSION['error'] = 'Username atau Password salah!';
            $this->redirect('/login');
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('/login');
    }
}
