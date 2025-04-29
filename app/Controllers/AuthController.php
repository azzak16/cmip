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
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (Auth::attempt($email, $password)) {
            $this->redirect('/');
        } else {
            $_SESSION['error'] = 'Email atau Password salah!';
            $this->redirect('/login');
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('/login');
    }
}
