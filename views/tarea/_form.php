<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;


/* @var $this yii\web\View */
/* @var $model app\models\Tarea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tarea-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12 col-md-6 col-md-offset-3">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-12 col-md-6 col-md-offset-3">
            <?=
                $form->field($model, 'activo')->widget(SwitchInput::classname([
                    'name' => 'activo',
                    'pluginOptions' => [
                        'onText' => 'Si',
                        'offText' => 'No',
                    ]
                ]))->label('Estado');
               
            ?>
        </div>
    </div>
    <div class="col-12 form-group" style="text-align: center">
        <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary']) ?>
        <?= Html::button('Cancelar', array('onclick' => 'js:document.location.href="index"','class' => 'btn btn-secondary'));?>

    </div>
    <?php ActiveForm::end(); ?>

</div>
