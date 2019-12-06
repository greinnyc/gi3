<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EventosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Eventos';
$this->params['breadcrumbs'][] = $this->title;
$options = array('1' => 'Activo',  '0'=> 'Inactivo');

?>
<div class="eventos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Eventos', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'evento_codigo',
                'label' => 'Evento Código',
            ],
            [
                'attribute'=>'nombre',
                'label' => 'Nombre',
            ],
            [
                'attribute'=>'Estado_codigo',
                'label' => 'Estado',  
                'value' => function($model) {
                    return ($model->Estado_codigo == '1') ? "Activo":"Inactivo";;
                },
                'filter' => Html::activeDropDownList($searchModel,'Estado_codigo', $options,['prompt'=>'--------','style'=>'height: 33px;'])
            ],
            //'usuario_modificacion',
            //'fecha_modificacion',
            //'fecha_registro',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
