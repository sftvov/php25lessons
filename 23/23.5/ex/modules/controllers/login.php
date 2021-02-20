<?php
namespace Controllers;
class Login extends BaseController {
    function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login_form = \Forms\Login::get_normalized_data($_POST);
            if (!isset($login_form['__errors'])) {
                $login_form =
                    \Forms\Login::get_prepared_data($login_form);
                $user_id = \Forms\Login::verify_user($login_form);
                if ($user_id) {
                    session_start();
                    $_SESSION['current_user'] = $user_id;
                    \Helpers\redirect('/users/' .
                        $login_form['name']);
                }
            }
        } else
            $login_form = \Forms\Login::get_initial_data();
        $ctx = ['form' => $login_form, 'site_title' => 'Вход'];
        $this->render('login', $ctx);
    }

    function logout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            unset ($_SESSION['current_user']);
            session_destroy();
            \Helpers\redirect('/');
        } else {
            $ctx = ['site_title' => 'Выход'];
            $this->render('logout', $ctx);
        }
    }

    function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $reg_form =
                \Forms\Register::get_normalized_data($_POST);
            if (!isset($reg_form['__errors'])) {
                $reg_form =
                    \Forms\Register::get_prepared_data($reg_form);
                $users = new \Models\User();
                $users->insert($reg_form);
                $values = ['title' => \Settings\SITE_NAME,
                    'name' => $reg_form['name'],
                    'url' => 'http://' . $_SERVER['SERVER_NAME'] .
                    '/users/' . $reg_form['name'] .
                    '/account/activation/' .
                    hash_hmac('ripemd256', $reg_form['name'],
                    \Settings\SECRET_KEY) . '/'];
                \Helpers\send_mail($reg_form['email'],
                    'activation_subject', 'activation_body',
                    $values);
                \Helpers\redirect('/register/complete/');
            }
        } else
            $reg_form = \Forms\Register::get_initial_data([]);
        $ctx = ['form' => $reg_form, 'site_title' => 'Регистрация'];
        $this->render('register', $ctx);
    }

    function register_complete() {
        $ctx = ['site_title' => 'Регистрация завершена'];
        $this->render('register_complete', $ctx);
    }
}
