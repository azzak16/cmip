<?php 
namespace Core;

use App\Models\User;

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
            return true;
        }

        return false;
    }

    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }

    public static function check()
    {
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
