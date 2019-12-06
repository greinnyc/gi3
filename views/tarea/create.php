<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tarea */

$this->title = 'Crear Tarea';
$this->params['breadcrumbs'][] = ['label' => 'Tareas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarea-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
