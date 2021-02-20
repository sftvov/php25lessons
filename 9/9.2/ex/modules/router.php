<?php
$request_path = $_GET['route'];
if ($request_path == '')
    require $base_path . 'modules\list.php';
else {
    $index = (integer)$request_path;
    require $base_path . 'modules\item.php';
}
