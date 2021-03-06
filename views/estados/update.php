<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Estados */

$this->title = 'Update Estados: ' . $model->estado_codigo;
$this->params['breadcrumbs'][] = ['label' => 'Estados', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->estado_codigo, 'url' => ['view', 'id' => $model->estado_codigo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estados-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
