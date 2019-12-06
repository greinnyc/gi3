<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tarea */

$this->title = 'Actualizar Tarea ';
$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tarea_codigo, 'url' => ['view', 'id' => $model->tarea_codigo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tarea-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
