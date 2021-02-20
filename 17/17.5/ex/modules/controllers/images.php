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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comment_form =
                \Forms\Comment::get_normalized_data($_POST);
            if (!isset($comment_form['__errors'])) {
                $comment_form =
                    \Forms\Comment::get_prepared_data($comment_form);
                $comment_form['picture'] = $index;
                $comments = new \Models\Comment();
                $comments->insert($comment_form);
                \Helpers\redirect('/' . $index .
                    \Helpers\get_GET_params(['page', 'filter',
                    'ref']));
            }
        } else
            $comment_form =
                \Forms\Comment::get_initial_data(['uploaded' => time()]);
        $users = new \Models\User();
        $users->select('*', NULL, '', NULL, 'name');
        $picts = new \Models\Picture();
        $pict = $picts->get_or_404($index, 'pictures.id', 'pictures.id, title, ' .
            'description, filename, uploaded, users.name AS user_name, ' .
            'categories.name AS cat_name, categories.slug, ' .
            '(SELECT COUNT(*) FROM comments WHERE ' .
            'comments.picture = pictures.id) AS comment_count',
            ['users', 'categories']);
        $comments = new \Models\Comment();
        $comments->select('comments.id, contents, users.name AS user_name, ' .
            'uploaded', ['users'], 'picture = ?', [$index]);
        $ctx = ['pict' => $pict, 'site_title' => $pict['title'],
            'comments' => $comments, 'form' => $comment_form,
            'users' => $users];
        $this->render('item', $ctx);
    }

    function by_cat(string $slug) {
        $cats = new \Models\Category();
        $cat = $cats->get_or_404($slug, 'slug', 'id, name');
        $w = 'category = ?';
        $p = [$cat['id']];
        if (isset($_GET['filter']) && !empty($_GET['filter'])) {
            $w .= ' AND (title LIKE ? OR description LIKE ?)';
            $f = '%' . $_GET['filter'] . '%';
            $p[] = $f;
            $p[] = $f;
        }
        $picts = new \Models\Picture();
        $pict_count_rec = $picts->get_record('COUNT(*) AS cnt', NULL,
            $w, $p);
        $paginator = new \Paginator($pict_count_rec['cnt'],
            ['filter']);
        $picts->select('pictures.id, title, filename, uploaded, ' .
            'users.name AS user_name, ' .
            '(SELECT COUNT(*) FROM comments WHERE ' .
            'comments.picture = pictures.id) AS comment_count',
            ['users'], $w, $p, '',
            $paginator->first_record_num, \Settings\RECORDS_ON_PAGE);
        $ctx = ['cat' => $cat, 'picts' => $picts,
            'paginator' => $paginator,
            'site_title' => $cat['name'] . ' :: Категории'];
        $this->render('by_cat', $ctx);
    }

    function by_user(string $username) {
        $users = new \Models\User();
        $user = $users->get_or_404($username, 'name', 'id, name');
        $w = 'user = ?';
        $p = [$user['id']];
        if (isset($_GET['filter']) && !empty($_GET['filter'])) {
            $w .= ' AND (title LIKE ? OR description LIKE ?)';
            $f = '%' . $_GET['filter'] . '%';
            $p[] = $f;
            $p[] = $f;
        }
        $picts = new \Models\Picture();
        $pict_count_rec = $picts->get_record('COUNT(*) AS cnt', NULL,
            $w, $p);
        $paginator = new \Paginator($pict_count_rec['cnt'],
            ['filter']);
        $picts->select('pictures.id, title, filename, uploaded, ' .
            'categories.name AS cat_name, categories.slug, ' .
            '(SELECT COUNT(*) FROM comments WHERE ' .
            'comments.picture = pictures.id) AS comment_count',
            ['categories'], $w, $p, '',
            $paginator->first_record_num, \Settings\RECORDS_ON_PAGE);
        $ctx = ['user' => $user, 'picts' => $picts,
            'paginator' => $paginator,
            'site_title' => $user['name'] . ' :: Пользователи'];
        $this->render('by_user', $ctx);
    }
}
