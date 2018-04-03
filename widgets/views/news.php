<?php
/** @var $this yii\web\View
 * @var $pageSizesSet array
 * @var $pageParam string
 * @var $dataProvider yii\data\ActiveDataProvider
 */

?>

<?php \yii\widgets\Pjax::begin(); ?>

    <form action="/" class="form-inline text-right" id="pageHolderForm">
        <div class="form-group">
            <label for="pageHolder">Page size: </label>
            <?= \yii\bootstrap\Html::dropDownList($pageParam, $dataProvider->pagination->pageSize, $pageSizesSet, [
                'class' => 'form-control',
                'id' => 'pageHolder'
            ]) ?>
        </div>
    </form>


<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_news',
]) ?>


<?php \yii\widgets\Pjax::end(); ?>

<?php $this->registerJs("
$('#pageHolder').on('change', function(){
    $('#pageHolderForm').submit();
});
") ?>
