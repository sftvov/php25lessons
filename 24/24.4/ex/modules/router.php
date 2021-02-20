<?php
$request_path = $_GET['route'];
if ($request_path && $request_path[-1] == '/')
    $request_path = substr($request_path, 0,
        strlen($request_path) - 1);
$result = [];
if (preg_match('/^cats\/(\w+)$/', $request_path, $result) === 1) {
    $ctr = new \Controllers\Images();
    $ctr->by_cat($result[1]);
} else if (preg_match('/^users\/(\w+)$/', $request_path, $result) === 1) {
    $ctr = new \Controllers\Images();
    $ctr->by_user($result[1]);
} else if (preg_match('/^(\d+)$/', $request_path, $result) === 1) {
    $index = (integer)$result[1];
    $ctr = new \Controllers\Images();
    $ctr->item($index);
} else if (preg_match('/^users\/(\w+)\/pictures\/add$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Images();
    $ctr->add($result[1]);
} else if (preg_match('/^users\/(\w+)\/pictures\/(\d+)\/edit$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Images();
    $ctr->edit($result[1], (integer)$result[2]);
} else if (preg_match('/^users\/(\w+)\/pictures\/(\d+)\/delete$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Images();
    $ctr->delete($result[1], (integer)$result[2]);
} else if (preg_match('/^(\d+)\/comments\/(\d+)\/edit$/',
    $request_path, $result) === 1) {
    $picture_index = (integer)$result[1];
    $comment_index = (integer)$result[2];
    $ctr = new \Controllers\Comments();
    $ctr->edit($picture_index, $comment_index);
} else if (preg_match('/^(\d+)\/comments\/(\d+)\/delete$/',
    $request_path, $result) === 1) {
    $picture_index = (integer)$result[1];
    $comment_index = (integer)$result[2];
    $ctr = new \Controllers\Comments();
    $ctr->delete($picture_index, $comment_index);
} else if (preg_match('/^users\/(\w+)\/account\/delete$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Account();
    $ctr->delete($result[1]);
} else if (preg_match('/^users\/(\w+)\/account\/edit$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Account();
    $ctr->edit($result[1]);
} else if (preg_match('/^users\/(\w+)\/account\/editpassword$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Account();
    $ctr->edit_password($result[1]);
} else if ($request_path == 'login') {
    $ctr = new \Controllers\Login();
    $ctr->login();
} else if ($request_path == 'logout') {
    $ctr = new \Controllers\Login();
    $ctr->logout();
} else if ($request_path == 'register') {
    $ctr = new \Controllers\Login();
    $ctr->register();
} else if ($request_path == 'register/complete') {
    $ctr = new \Controllers\Login();
    $ctr->register_complete();
} else if (preg_match('/^users\/(\w+)\/account\/activation\/(\w+)$/',
    $request_path, $result) === 1) {
    $ctr = new \Controllers\Account();
    $ctr->activate($result[1], $result[2]);
} else if (preg_match('/^api\/images\/(\d+)$/', $request_path,
    $result) === 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $ctr = new \Controllers\APIImages();
        $ctr->item($result[1]);
    } else
        http_response_code(405);
} else if (preg_match('/^api\/images\/(\d+)\/comments$/',
    $request_path, $result) === 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $ctr = new \Controllers\APIComments();
        $ctr->list($result[1]);
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ctr = new \Controllers\APIComments();
        $ctr->add($result[1]);
    } else
        http_response_code(405);
} else if (preg_match('/^api\/images\/(\d+)\/comments\/(\d+)$/',
    $request_path, $result) === 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
        ($_POST['__method'] == 'PUT' ||
        $_POST['__method'] == 'PATCH')) {
        $ctr = new \Controllers\APIComments();
        $ctr->edit($result[1], $result[2]);
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
        $_POST['__method'] == 'DELETE') {
        $ctr = new \Controllers\APIComments();
        $ctr->delete($result[1], $result[2]);
    } else
        http_response_code(405);
} else if ($request_path == 'api/login') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ctr = new \Controllers\APILogin();
        $ctr->check();
    } else
        http_response_code(405);
} else if ($request_path == '') {
    $ctr = new \Controllers\Images();
    $ctr->list();
} else {
    throw new Page404Exception();
}
