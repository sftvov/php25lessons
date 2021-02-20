<?php
namespace Models;
class Picture extends \Models\Model {
    protected const TABLE_NAME = 'pictures';
    protected const DEFAULT_ORDER = 'uploaded DESC';
    protected const RELATIONS =
        ['categories' => ['external' => 'category', 'primary' => 'id'],
                 'users' => ['external' => 'user', 'primary' => 'id']];
}
