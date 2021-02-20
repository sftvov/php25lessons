<?php
namespace Controllers;
class Images extends BaseController {
    function list() {
        $cats = new \Models\Category();
        $cats->select();
        $picts = new \Models\Picture();
        $picts->select('pictures.id, title, filename, uploaded, ' .
            'users.name AS user_name, categories.name AS cat_name, ' .
            'categories.slug, (SELECT COUNT(*) FROM comments ' .
            'WHERE comments.picture = pictures.id) AS comment_count',
            ['users', 'categories'], '', NULL, '', 0, 3);
        $ctx = ['cats' => $cats, 'picts' => $picts];
        $this->render('list', $ctx);
    }

    function item(int $index) {
        $item = \Models\Image::get_image($index);
        $ctx = ['item' => $item, 'site_title' => $item['desc']];
        $this->render('item', $ctx);
    }

    function by_cat(string $slug) {
        $cats = new \Models\Category();
        $cat = $cats->get_or_404($slug, 'slug', 'id, name');
        $picts = new \Models\Picture();
        $picts->select('pictures.id, title, filename, uploaded, ' .
            'users.name AS user_name, ' .
            '(SELECT COUNT(*) FROM comments WHERE ' .
            'comments.picture = pictures.id) AS comment_count',
            ['users'], 'category = ?', [$cat['id']]);
        $ctx = ['cat' => $cat, 'picts' => $picts];
        $this->render('by_cat', $ctx);
    }
}
