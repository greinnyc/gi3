<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SedeUbicacion */

$this->title = 'Crear Ubicación';
$this->params['breadcrumbs'][] = ['label' => 'Sede Ubicacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sede-ubicacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
