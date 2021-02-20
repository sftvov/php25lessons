<?php
namespace Controllers;
class Images extends BaseController {
    function list() {
        $ctx = ['cnt' => \Models\Image::get_count()];
        $this->render('list', $ctx);
    }

    function item(int $index) {
        $item = \Models\Image::get_image($index);
        $ctx = ['item' => $item, 'site_title' => $item['desc']];
        $this->render('item', $ctx);
    }
}
