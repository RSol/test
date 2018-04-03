<?php

namespace app\rbac;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    public function execute($user, $item, $params)
    {
        if (\Yii::$app->user->can('admin')) {
            return true;
        }
        return isset($params['news']) ? $params['news']->user_id == $user : false;
    }
}