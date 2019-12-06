<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
use app\models\Sedes;
use kartik\select2\Select2;


$model_sedes = new Sedes();
/* @var $this yii\web\View */
/* @var $model app\models\SedeUbicacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sede-ubicacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-12 col-md-6 col-md-offset-3">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-12 col-md-6 col-md-offset-3">
             <?=  $form->field($model, 'sede_codigo')->widget(Select2::classname(),[   
                                                'data' => ArrayHelper::map($model_sedes->getSedes(), "Codigo","Descripcion"),
                                                'language' => 'es',
                                                'options' =>[  
                                                                'placeholder' => 'Seleccione ',
                                                            ],
                                                'pluginOptions' =>  [
                                                                        'allowClear' => true,
                                                                    ]
                            ])->label('Sede');
                        ?>
        </div>
        <div class="col-12 col-md-6 col-md-offset-3">
            <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-12 col-md-6 col-md-offset-3">
            <?= $form->field($model, 'aforo')->textInput(['maxlength' => true]) ?>
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

    <!--<?= $form->field($model, 'ubicacion_codigo')->textInput() ?>

    <?= $form->field($model, 'sede_codigo')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'aforo')->textInput() ?>

    <?= $form->field($model, 'activo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>-->
    </div>

    <?php ActiveForm::end(); ?>

</div>
