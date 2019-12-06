<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\IngresoEvento */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <?= Html::a(Html::img('@web/img/qr_icon.png',['class' => 'logo-button']), Url::to(['/items-invitado/escanear-qr'], false))?>

        </div>
         <div class="col-12 col-md-6">
            <?= Html::a(Html::img('@web/img/carnet.png',['class' => 'logo-button']), Url::to(['/items-invitado/consultar-documento'], false))?>

        </div>
    </div>
    
    
</div>
