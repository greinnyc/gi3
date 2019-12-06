<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;


/* @var $this yii\web\View */
/* @var $model app\models\Sedes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sedes-form">

    <?php $form = ActiveForm::begin(['id'=>'sedes']); ?>
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

    <!--<?= $form->field($model, 'sede_codigo')->textInput() ?>

    <?= $form->field($model, 'organizacion_codigo')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activo')->textInput() ?>

    <?= $form->field($model, 'usuario_registro')->textInput() ?>

    <?= $form->field($model, 'usuario_modificacion')->textInput() ?>

    <?= $form->field($model, 'fecha_registro')->textInput() ?>

    <?= $form->field($model, 'fecha_modificacion')->textInput() ?>-->

   
    <?php ActiveForm::end(); ?>

</div>
