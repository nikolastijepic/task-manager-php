<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->render('auth/login', [
            'title' => 'Prijava na sistem'
        ]);
    }

    public function showRegister(): void
    {
        $this->render('auth/register', [
            'title' => 'Registracija'
        ]);
    }

    public function register(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $this->render('auth/register', [
                'title' => 'Registracija',
                'error' => 'Sva polja su obavezna.'
            ]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('auth/register', [
                'title' => 'Registracija',
                'error' => 'Unesite ispravnu email adresu.'
            ]);
            return;
        }

        if (strlen($password) < 8) {
            $this->render('auth/register', [
                'title' => 'Registracija',
                'error' => 'Lozinka mora imati najmanje 8 karaktera.'
            ]);
            return;
        }

        if (User::findByEmail($email)) {
            $this->render('auth/register', [
                'title' => 'Registracija',
                'error' => 'Korisnik sa ovom email adresom već postoji.'
            ]);
            return;
        }

        if (User::create($name, $email, $password)) {
            $this->redirect('/login');
        } else {
            $this->render('auth/register', [
                'title' => 'Registracija',
                'error' => 'Došlo je do greške prilikom registracije.'
            ]);
        }
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->render('auth/login', [
                'title' => 'Prijava',
                'error' => 'Sva polja su obavezna.'
            ]);
            return;
        }

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->render('auth/login', [
                'title' => 'Prijava',
                'error' => 'Pogrešan email ili lozinka.'
            ]);
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        $this->redirect('/tasks');
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->redirect('/login');
    }
}
