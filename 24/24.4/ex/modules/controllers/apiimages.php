<?php
namespace Controllers;
class APIImages extends BaseController {
    function item(int $index) {
        \Helpers\api_headers();
        $picts = new \Models\Picture();
        $pict = $picts->get_or_404($index, 'id',
            'title, description, filename');
        $pict['url'] = 'http://' . $_SERVER['SERVER_NAME'] .
            \Settings\IMAGE_PATH . $pict['filename'];
        echo json_encode($pict, JSON_UNESCAPED_UNICODE);
    }
}
