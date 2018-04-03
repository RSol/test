<?php

namespace app\models;

class User extends \dektrium\user\models\User
{
    /**
     * Confirms the user by setting 'confirmed_at' field to current time.
     */
//    public function confirm()
//    {
//        $result = parent::confirm();
//        if ($result) {
//            $auth = \Yii::$app->authManager;
//            $role = $auth->getRole('author');
//            $auth->assign($role, $this->id);
//        }
//        return $result;
//    }
}
