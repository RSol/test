<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('news', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="news-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('news', 'Create News'), ['create'], [
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalForm',
            ]) ?>
        </p>

        <div class="modal remote fade" id="modalForm">
            <div class="modal-dialog">
                <div class="modal-content loader-lg"></div>
            </div>
        </div>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'user.username',
                'title',
                'description:ntext',
                [
                    'attribute' => 'status',
                    'filter' => \app\models\News::getStatusList(),
                    'value' => function ($model) {
                        if (!Yii::$app->user->can('updateOwnNews', ['news' => $model])) {
                            return $model->statusLabel;
                        }
                        if ($model->status === \app\models\News::STATUS_DISABLED) {
                            return $model->statusLabel . ' ' . Html::a('<span class="glyphicon glyphicon-thumbs-up">', ['block', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-success change-status',
//                            'data-method' => 'post',
//                            'data-confirm' => Yii::t('news', 'Are you sure you want to unblock this news?'),
                                ]);
                        } else {
                            return $model->statusLabel . ' ' . Html::a('<span class="glyphicon glyphicon-thumbs-down">', ['block', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-danger change-status',
//                            'data-method' => 'post',
//                            'data-confirm' => Yii::t('news', 'Are you sure you want to block this news?'),
                                ]);
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'created_at',
                    'format' => 'date',
                    'filter' => \kartik\daterange\DateRangePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_range',
//                    'value' => '01-Jan-14 to 20-Feb-14',
                        'convertFormat' => true,
//                        'useWithAddon' => true,
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'Y-m-d',
                                'separator' => ' - ',
                            ],
                            'opens' => 'left'
                        ]
                    ])
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'visibleButtons' => [
                        'delete' => Yii::$app->user->can('admin'),
                    ],
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            if (!Yii::$app->user->can('updateOwnNews', ['news' => $model])) {
                                return;
                            }
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'data-toggle' => 'modal',
                                'data-target' => '#modalForm',
                            ]);
                        }
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>

<?php
$this->registerJs("
$('#modalForm').on('show.bs.modal', function (event) {
  var link = $(event.relatedTarget);
  var url = link.attr('href');
  var modal = $(this);
  modal.find('.modal-content').html('Loading...');
  $.get(url, function(data) {
    modal.find('.modal-content').html(data);
  });
})");
?>