<?php
namespace Controllers;
class APIComments extends BaseController {
    function list(int $picture_index) {
        \Helpers\api_headers();
        $comments = new \Models\Comment();
        $coms = $comments->get_all('comments.id, contents, ' .
            'users.name AS user_name', ['users'], 'picture = ?',
            [$picture_index]);
        echo json_encode($coms, JSON_UNESCAPED_UNICODE);
    }

    private function get_user() {
        $username = $_POST['name'];
        if (hash_hmac('ripemd256', $username,
            \Settings\SECRET_KEY) != $_POST['token'])
            return FALSE;
        else {
            $users = new \Models\User();
            return $users->get($username, 'name');
        }
    }

    function add(int $picture_index) {
        \Helpers\api_headers();
        if (!($user = $this->get_user()))
            http_response_code(403);
        else {
            $comment_form =
                \Forms\Comment::get_normalized_data($_POST);
            if (isset($comment_form['__errors'])) {
                http_response_code(400);
                $comment = ['errors' => $comment_form['__errors']];
                echo json_encode($comment, JSON_UNESCAPED_UNICODE);
            } else {
                $comment_form['picture'] = $picture_index;
                $comment_form['user'] = $user['id'];
                $comments = new \Models\Comment();
                $comments->insert($comment_form);
                http_response_code(201);
            }
        }
    }

    function edit(int $picture_index, int $comment_index) {
        \Helpers\api_headers();
        if (!($user = $this->get_user()))
            http_response_code(403);
        else {
            $comments = new \Models\Comment();
            $comment = $comments->get($comment_index);
            if (!$comment)
                http_response_code(404);
            else if ($comment['user'] != $user['id'])
                http_response_code(403);
            else {
                $comment_form =
                    \Forms\Comment::get_normalized_data($_POST);
                if (isset($comment_form['__errors'])) {
                    http_response_code(400);
                    $comment =
                        ['errors' => $comment_form['__errors']];
                    echo json_encode($comment,
                        JSON_UNESCAPED_UNICODE);
                } else {
                    $comments = new \Models\Comment();
                    $comments->update($comment_form, $comment_index);
                    http_response_code(200);
                }
            }
        }
    }

    function delete(int $picture_index, int $comment_index) {
        \Helpers\api_headers();
        if (!($user = $this->get_user()))
            http_response_code(403);
        else {
            $comments = new \Models\Comment();
            $comment = $comments->get($comment_index);
            if (!$comment)
                http_response_code(404);
            else if ($comment['user'] != $user['id'])
                http_response_code(403);
            else {
                $comments = new \Models\Comment();
                $comments->delete($comment_index);
                http_response_code(204);
            }
        }
    }
}
