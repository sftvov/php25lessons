<?php
namespace Models;
class User extends \Models\Model {
    protected const TABLE_NAME = 'users';
    protected const DEFAULT_ORDER = 'name';

    protected function before_delete($value, $key_field = 'id') {
        if ($key_field != 'id') {
            $users = new \Models\User();
            $user = $users->get($value, $key_field, 'id');
            $value = $user['id'];
        }
        $pictures = new \MODELS\Picture();
        $pictures2 = new \MODELS\Picture();
        $pictures->select('id', NULL, 'user = ?', [$value]);
        foreach ($pictures as $picture)
            $pictures2->delete($picture['id']);
    }
}
