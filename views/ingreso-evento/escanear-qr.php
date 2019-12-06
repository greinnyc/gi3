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
<h1>Registrar Ingreso</h1>
<div class="container">
    <?php $form = ActiveForm::begin(['id'=>'escanear-qr','action'=>'escanear-qr']); ?>
        <?= Html::input('hidden','numero_documento','', $options=['class'=>'form-control', 'id'=>'numero_documento']) ?>
        <?= Html::input('hidden','evento_codigo','', $options=['class'=>'form-control', 'id'=>'evento_codigo']) ?>

        <div class="row">
            <div class="col-12 col-md-6">
    	          <h1>Escanear QR</h1>
                <video id="preview" style="width: 200px;height: 200px;"></video>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>	
<?php

$js=<<< JS


let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
scanner.addListener('scan', function (content) {
    data = JSON.parse(content);
    $('#numero_documento').val(data.numero_documento);
    $('#evento_codigo').val(data.evento_codigo);
    $('form#escanear-qr').submit();
});
Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        //alert(cameras.length);
        scanner.start(cameras[1]);
    }else {
        console.error('No cameras found.');
    }
  }).catch(function (e) {
      console.error(e);
  });
JS;

$this->registerJs($js, yii\web\View::POS_READY);
?>
