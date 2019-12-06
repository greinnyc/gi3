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
<h1>Validar Token</h1>
<div class="container">
	<?php $form = ActiveForm::begin(['id'=>'registrar_token']); ?>
    	<div class="row">
        	<div class="col-12 col-md-6">
		    	<?= $form->field($model_staff, 'token')->textInput()->label('Token de Autenticación'); ?>
            </div>
		    <div class="col-12 col-md-12">
		        <?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary']) ?>
                <?= Html::button('Reenviar Token', array('onclick' => 'js:enviarToken();','class' => 'btn btn-secondary'));?>

		    </div>
        </div>
    <?php ActiveForm::end(); ?>
       
    </div>
    
    
</div>
