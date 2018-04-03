<?php

namespace app\commands;

use app\rbac\AuthorRule;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Query;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $createNews = $auth->createPermission('createNews');
        $createNews->description = 'Create a news';
        $auth->add($createNews);

        $updateNews = $auth->createPermission('updateNews');
        $updateNews->description = 'Update news';
        $auth->add($updateNews);

        $rule = new AuthorRule();
        $auth->add($rule);

        $updateOwnNews = $auth->createPermission('updateOwnNews');
        $updateOwnNews->description = 'Update own news';
        $updateOwnNews->ruleName = $rule->name;
        $auth->add($updateOwnNews);

        $auth->addChild($updateOwnNews, $updateNews);

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $createNews);
        $auth->addChild($manager, $updateOwnNews);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updateNews);
        $auth->addChild($admin, $manager);

        return ExitCode::OK;
    }

    public function actionAssign($userId = 1, $role = 'admin')
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole($role);
        if (!$role) {
            echo "Role not found\n";
            return ExitCode::IOERR;
        }
        $user = (new Query())
            ->from('user')
            ->where([
                'id' => $userId,
            ])
            ->exists();
        if (!$user) {
            echo "User not found\n";
            return ExitCode::IOERR;
        }

        $auth->assign($role, $userId);

        echo "Assigned\n";
        return ExitCode::OK;
    }
}
