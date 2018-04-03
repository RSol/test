<?php

/**
 * @var $model \app\models\News
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= Yii::$app->user->isGuest ? $model->title : \yii\helpers\Html::a($model->title, ['news/view', 'id' => $model->id]) ?></h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <?= \yii\helpers\Html::img($model->getThumbFileUrl('image', 'thumb')) ?>
            </div>
            <div class="col-md-8">
                <?= \yii\widgets\DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'user.username',
                        [
                            'attribute' => 'description',
                            'format' => 'ntext',
                            'visible' => !Yii::$app->user->isGuest
                        ],
                        'created_at:date',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
