<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title"><?= $model->isNewRecord ? 'Create news' : 'Update news' ?></h4>
</div>
<div class="modal-body">
    <div class="news-form">

        <?php $form = ActiveForm::begin([
//        'enableClientValidation' => false,
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
        ]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'image')->fileInput() ?>

        <?= $form->field($model, 'status')->dropDownList(\app\models\News::getStatusList()) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('news', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>


