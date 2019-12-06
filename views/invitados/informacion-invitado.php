<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Invitados */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invitados-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'invitado_codigo')->textInput() ?>

    <?= $form->field($model, 'evento_codigo')->textInput() ?>

    <?= $form->field($model, 'empleado_codigo')->textInput() ?>

    <?= $form->field($model, 'activo')->textInput() ?>

    <?= $form->field($model, 'usuario_registro')->textInput() ?>

    <?= $form->field($model, 'usuario_modificacion')->textInput() ?>

    <?= $form->field($model, 'fecha_registro')->textInput() ?>

    <?= $form->field($model, 'fecha_modificacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
