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
} else if ($request_path == '') {
    $ctr = new \Controllers\Images();
    $ctr->list();
} else {
    throw new Page404Exception();
}
