<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemsCatalogoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items Catalogos';
$this->params['breadcrumbs'][] = $this->title;
$options = array('1' => 'Activo',  '0'=> 'Inactivo');

?>
<div class="items-catalogo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Ítem', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'nombre',
                'label' => 'Nombre',
            ],
            [
                'attribute'=>'marca',
                'label' => 'Marca',
            ],
            [
                'attribute'=>'modelo',
                'label' => 'Modelo',
            ],
              [
                'attribute'=>'estado',
                'label' => 'Estado',  
                'value' => function($model) {
                    return ($model->estado == '1') ? "Activo":"Inactivo";;
                },
                'filter' => Html::activeDropDownList($searchModel,'estado', $options,['prompt'=>'--------','style'=>'height: 33px;'])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>


</div>
