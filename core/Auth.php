<?php 
namespace Core;

use App\Models\User;
use Exception;

class Auth
{
    public static function attempt($username, $password)
    {
        $userModel = new User();
        $user = $userModel->findByUser($username);      

        if ($user && password_verify($password, $user['PASSWORD'])) {
            $_SESSION['user'] = [
                'NO_ID' => $user['NO_ID'],
                'username' => $user['USERNAME'],
                'role_id' => $user['role_id']
            ];
            $_SESSION['login_time'] = time();
            $_SESSION['expire_time'] = 10800;
            return true;
        }

        throw new Exception("Username atau password salah!");

        // return false;
    }

    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check()
    {
        if (isset($_SESSION['user'])) {
            if (time() - $_SESSION['login_time'] > $_SESSION['expire_time']) {
                // Waktu sesi habis
                Auth::logout();
            } else {
                // Perbarui waktu login agar terus aktif saat user aktif
                $_SESSION['login_time'] = time();
            }
        }

        return isset($_SESSION['user']);
    }

    public static function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function is($role)
    {
        return self::check() && $_SESSION['user']['role'] === $role;
    }
}
