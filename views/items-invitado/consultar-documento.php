<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $model app\models\IngresoEvento */
/* @var $form yii\widgets\ActiveForm */
?>
<h1>Registrar entrega de ítems</h1>
<div class="container">
	<?php $form = ActiveForm::begin(['id'=>'consultar_documento']); ?>
    	<div class="row">
        	<div class="col-12 col-md-6">
		    	<?= $form->field($model_invitados, 'numero_documento')->textInput()->label('Número de Documento'); ?>
		    	 <?=  $form->field($model_invitados, 'evento_codigo')->widget(Select2::classname(),[   
                                                'data' => ArrayHelper::map($model_eventos->getEventos(), "Codigo","Descripcion"),
                                                'language' => 'es',
                                                'options' =>[  
                                                                'placeholder' => 'Seleccione ',
                                                                'id'=>'sede'
                                                            ],
                                                'pluginOptions' =>  [
                                                                        'allowClear' => true,
                                                                    ]
                            ])->label('Eventos');
                        ?>

			    <div class="form-group">
			        <?= Html::submitButton('Consultar', ['class' => 'btn btn-primary']) ?>
			    </div>
        </div>
    <?php ActiveForm::end(); ?>
       
    </div>
    
    
</div>
