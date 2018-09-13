<?php

namespace App\Auth;


use App\Models\User;

class Auth
{

    public function user()
    {
        return $this->check() ? User::find($_SESSION['user_id']) : null;
    }

    public function check()
    {
        return isset($_SESSION['user_id']);
    }

    public function attempt($email, $password)
    {
        $User = User::where('email', $email)->first();
        if ( ! $User ) return false;
        if ( password_verify($password, $User->password) ) {
            $_SESSION['user_id'] = $User->id;
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
    }
}