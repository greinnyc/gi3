<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TareaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tareas';
$this->params['breadcrumbs'][] = $this->title;
$options = array('1' => 'Activo',  '0'=> 'Inactivo');

?>
<div class="tarea-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Tarea', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
             [
                'attribute'=>'activo',
                'label' => 'Estado',  
                'value' => function($model) {
                    return ($model->activo == '1') ? "Activo":"Inactivo";;
                },
                'filter' => Html::activeDropDownList($searchModel,'activo', $options,['prompt'=>'--------','style'=>'height: 33px;'])
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>


</div>
