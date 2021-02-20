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
            if (!$this->current_user)
                throw new \Page403Exception();
            \Helpers\check_token($_POST);
            $comment_form =
                \Forms\Comment::get_normalized_data($_POST);
            if (!isset($comment_form['__errors'])) {
                $comment_form =
                    \Forms\Comment::get_prepared_data($comment_form);
                $comment_form['picture'] = $index;
                $comment_form['user'] = $this->current_user['id'];
                $comments = new \Models\Comment();
                $comments->insert($comment_form);
                $pictures = new \Models\Picture();
                $user = $pictures->get($index, 'pictures.id',
                    'users.name, users.email, users.emailme',
                    ['users']);
                if ($user['emailme']) {
                    $values = ['title' => \Settings\SITE_NAME,
                        'name' => $user['name'],
                        'url' => 'http://' . $_SERVER['SERVER_NAME'] .
                        '/' . $index];
                    \Helpers\send_mail($user['email'],
                        'notification_subject', 'notification_body',
                        $values);
                }
                \Helpers\redirect('/' . $index .
                    \Helpers\get_GET_params(['page', 'filter',
                    'ref']));
            }
        } else
            $comment_form =
                \Forms\Comment::get_initial_data();
        $comment_form['__token'] = \Helpers\generate_token();
        $picts = new \Models\Picture();
        $pict = $picts->get_or_404($index, 'pictures.id', 'pictures.id, title, ' .
            'description, filename, uploaded, users.name AS user_name, ' .
            'categories.name AS cat_name, categories.slug, ' .
            '(SELECT COUNT(*) FROM comments WHERE ' .
            'comments.picture = pictures.id) AS comment_count',
            ['users', 'categories']);
        $comments = new \Models\Comment();
        $comments->select('comments.id, contents, ' .
            'users.name AS user_name, uploaded, ' .
            'users.id AS user_id', ['users'], 'picture = ?', [$index]);
        $ctx = ['pict' => $pict, 'site_title' => $pict['title'],
            'comments' => $comments, 'form' => $comment_form];
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
            'comments.picture = pictures.id) AS comment_count, ' .
            'pictures.user', ['categories'], $w, $p, '',
            $paginator->first_record_num, \Settings\RECORDS_ON_PAGE);
        $ctx = ['user' => $user, 'picts' => $picts,
            'paginator' => $paginator,
            'site_title' => $user['name'] . ' :: Пользователи'];
        $this->render('by_user', $ctx);
    }

    function add(string $username) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->current_user)
                throw new \Page403Exception();
            \Helpers\check_token($_POST);
            $picture_form =
                \Forms\Picture::get_normalized_data($_POST);
            if (!isset($picture_form['__errors'])) {
                $picture_form =
                    \Forms\Picture::get_prepared_data($picture_form);
                $users = new \Models\User();
                $user = $users->get_or_404($username, 'name', 'id');
                $picture_form['user'] = $user['id'];
                $pictures = new \Models\Picture();
                $pictures->insert($picture_form);
                \Helpers\redirect('/users/' . $username);
            }
        } else
            $picture_form =
                \Forms\Picture::get_initial_data();
        $picture_form['__token'] = \Helpers\generate_token();
        $categories = new \Models\Category();
        $categories->select();
        $ctx = ['site_title' => 'Добавление изображения',
            'username' => $username, 'form' => $picture_form,
            'categories' => $categories];
        $this->render('picture_add', $ctx);
    }

    private function check_user(int $picture_index) {
        $pictures = new \Models\Picture();
        $picture = $pictures->get_or_404($picture_index, 'id',
            'user');
        if (!($this->current_user &&
            ($this->current_user['id'] == $picture['user'] ||
            $this->current_user['admin'])))
            throw new \Page403Exception();
    }

    function edit(string $username, int $picture_index) {
        $this->check_user($picture_index);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Helpers\check_token($_POST);
            $picture_form =
                \Forms\Picture2::get_normalized_data($_POST);
            if (!isset($picture_form['__errors'])) {
                $picture_form =
                    \Forms\Picture2::get_prepared_data($picture_form);
                $pictures = new \Models\Picture();
                $pictures->update($picture_form, $picture_index);
                \Helpers\redirect('/users/' . $username .
                    \Helpers\get_GET_params(['page', 'filter']));
            }
        } else {
            $pictures = new \Models\Picture();
            $picture = $pictures->get_or_404($picture_index);
            $picture_form =
                \Forms\Picture2::get_initial_data($picture);
        }
        $picture_form['__token'] = \Helpers\generate_token();
        $categories = new \Models\Category();
        $categories->select();
        $ctx = ['form' => $picture_form, 'categories' => $categories,
            'username' => $username, 'site_title' => 'Правка изображения'];
        $this->render('picture_edit', $ctx);
    }

    function delete(string $username, int $picture_index) {
        $this->check_user($picture_index);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            \Helpers\check_token($_POST);
            $pictures = new \Models\Picture();
            $pictures->delete($picture_index);
            \Helpers\redirect('/users/' . $username .
                \Helpers\get_GET_params(['page', 'filter']));
        } else {
            $pictures = new \Models\Picture();
            $picture = $pictures->get_or_404($picture_index, 'id',
                'title, uploaded');
            $ctx = ['picture' => $picture, 'username' => $username,
                'site_title' => 'Удаление изображения',
                '__token' => \Helpers\generate_token()];
            $this->render('picture_delete', $ctx);
        }
    }
}
