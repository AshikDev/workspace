<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*']); ?>

    <?= $form->field($model, 'expire_date')->widget(DatePicker::class, [
        'language' => 'en',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['autocomplete' => 'off'],
        'clientOptions' => [
            'minDate' => '+0'
        ]
    ]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryArray, ['prompt' => 'Select a category']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
