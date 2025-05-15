<?php 
namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Database;
use Core\Env;
use Exception;

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

        // if (Auth::attempt($username, $password)) {
        //     $this->redirect('/cmip/');
        // } else {
        //     $_SESSION['error'] = 'Username atau Password salah!';
        //     $this->redirect('/cmip/login');
        // }

        try {

            if (!$username || !$password) {
                throw new Exception("Username atau password harus diisi!");
            }

            Auth::attempt($username, $password);

            echo json_encode([
                'status' => true, 
                'message' => 'Login Berhasil.',
                'redirect' => Env::get('BASE_URL') . '/'
            ], JSON_UNESCAPED_SLASHES);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        Auth::logout();
        $this->redirect('/cmip/login');
    }
}
