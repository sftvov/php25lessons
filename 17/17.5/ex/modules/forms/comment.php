<?php
namespace Forms;
class Comment extends \Forms\Form {
    protected const FIELDS = [
        'user' => ['type' => 'integer'],
        'contents' => ['type' => 'string'],
        'uploaded' => ['type' => 'timestamp']
    ];
}
