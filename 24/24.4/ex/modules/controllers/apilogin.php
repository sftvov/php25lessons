<?php
namespace Controllers;
class APILogin extends BaseController {
    function check() {
        \Helpers\api_headers();
        $login_form = \Forms\Login::get_normalized_data($_POST);
        if (isset($login_form['__errors']) ||
            !\Forms\Login::verify_user($login_form)) {
            http_response_code(400);
            $user = ['errors' => $login_form['__errors']];
        } else {
            $user = ['name' => $login_form['name'],
                'token' => hash_hmac('ripemd256',
                $login_form['name'], \Settings\SECRET_KEY)];
        }
        echo json_encode($user, JSON_UNESCAPED_UNICODE);
    }
}
