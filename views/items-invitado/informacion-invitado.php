<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\IngresoEvento */
/* @var $form yii\widgets\ActiveForm */
?>
<h1>Registrar Entrega de Items</h1>
<div class="container">
	<?php $form = ActiveForm::begin(['id'=>'informacion_invitado_items','action'=>'registrar-items-invitado']); ?>

		<?= Html::input('hidden','invitado_codigo',$empleado['invitado_codigo'], $options=['class'=>'form-control', 'id'=>'invitado_codigo']) ?>
		<?= Html::input('hidden','sede_codigo',$empleado['sede_codigo'], $options=['class'=>'form-control', 'id'=>'sede_codigo']) ?>
		<?= Html::input('hidden','evento_codigo',$empleado['evento_codigo'], $options=['class'=>'form-control', 'id'=>'evento_codigo']) ?>


		<div class="row justify-content-center">
			 <div class="col-md-6">
			 	<p style="text-align: center;font-weight: bold;">INFORMACION INVITADO</p>
			 	<p><b>Número de Documento:</b> <?= $empleado['numero_documento']?></p>
			 	<p><b>Empleado:</b> <?= $empleado['nombre']." ".$empleado['apellido_materno']." ".$empleado['apellido_paterno']?></p>
			 	<p><b>Estado:</b><?= ($empleado['estado_codigo'] == 1)?'<b style="color:green">Activo</b>':'<b style="color:red">Inactivo</b>' ?></p>
			 	<p><b>Evento:</b><?= $empleado['nombre_evento']?></p>

			 </div>
  			<div class="col-md-6">
  				<?= Html::img('@web/dist/img/user1-128x128.jpg',['class' => 'img-circle elevation-2 img-info-empleado','alt' => 'User Avatar']) ?>
  			</div>
		</div>
		<div class="row">
			<?php foreach ($items as $key => $value) { ?>
				<div class="col-md-12">
  					<?php echo $value['nombre']?>
  					<?= Html::input('hidden','items_'.$value['item_evento_codigo'],'0', $options=['class'=>'form-control']) ?>
  			   		<?php echo Html::checkbox('items_'.$value['item_evento_codigo'],$value['estado_codigo'],['class'=>'class','id'=>'items_'.$value['item_evento_codigo'],'disabled'=>($value['stock'] == 0 || $value['estado_codigo'] == 1)?true:false]);?>
                </div>                          
  			<?php  }?>
			
		</div>
		<div class="row" style="text-align: center">
			<div class="col-md-6">
				<?= Html::submitButton('Aceptar', ['class' => 'btn btn-primary','id'=>'btn_guardar', 'name'=>'btn_guardar',]) ?>
	       		<?= Html::button('Cancelar', array('onclick' => 'js:document.location.href="registrar-entrega-items"','class' => 'btn btn-secondary'));?>
			</div>
    	</div>

	<?php ActiveForm::end(); ?>
</div>
