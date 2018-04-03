<?php

namespace app\modules\notify\controllers;

use yii\web\Controller;

/**
 * Default controller for the `notify` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param $id
     * @throws \yii\db\Exception
     */
    public function actionCloseNotifyAlert($id)
    {
        \Yii::$app->db->createCommand()
            ->update('{{%notify_alert_process}}', [
                'status' => 0
            ], [
                'id' => $id
            ])
        ->execute();
    }
}
