<?php
$request_path = $_GET['route'];
if ($request_path && $request_path[-1] == '/')
    $request_path = substr($request_path, 0,
        strlen($request_path) - 1);
$result = [];
if (preg_match('/^(\d+)$/', $request_path, $result) === 1) {
    $index = (integer)$result[1];
    $ctr = new \Controllers\Images();
    $ctr->item($index);
} else if ($request_path == '') {
    $ctr = new \Controllers\Images();
    $ctr->list();
} else {
    throw new Page404Exception();
}
