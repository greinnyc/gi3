<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Reportes;
use kartik\date\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;




/* @var $this yii\web\View */
/* @var $searchModel app\models\ReportesNewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reportes por Período';
$this->params['breadcrumbs'][] = $this->title;
$tipoReporte = Array( 
                        0 =>'1. Reporte ingreso de invitados a evento',
                        1 =>'2. Reporte registros de entrega de items',
                        2 =>'3. Reporte de invitados por evento',
                    );

?>
<div class="reportes-new-index">


    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <!--<?= Html::a('Create Reportes New', ['create'], ['class' => 'btn btn-success']) ?>-->
    </p>
    <?php $form = ActiveForm::begin(['id' => 'reportes',
                                    //'enableAjaxValidation' => true
                                    ])?>

        <div class="row">
            
            <div class="col-md-6 col-md-offset-3">
                <?= $form->field($model, 'Tipo_Reporte')->dropDownList($tipoReporte,["prompt"=>"Seleccione"])->label('Tipo de Reporte'); ?>
            </div>
            <div class="col-md-6 col-md-offset-3">
                <?=  $form->field($model, 'evento_codigo')->widget(Select2::classname(),[   
                                                'data' => ArrayHelper::map($model_eventos->getEventos(), "Codigo","Descripcion"),
                                                'language' => 'es',
                                                'options' =>[  
                                                                'placeholder' => 'Seleccione ',
                                                                'id'=>'sede'
                                                            ],
                                                'pluginOptions' =>  [
                                                                        'allowClear' => true,
                                                                    ]
                            ])->label('Eventos');
                        ?>
            </div>
            <div class="col-md-3 col-md-offset-3">
                 <?php 
                    echo $form->field($model, 'Fecha_Inicio',[ 'options' => [ 'style' => '']])->widget(DatePicker::classname(), [
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'todayBtn' => true,
                            'format' => 'dd/mm/yyyy',
                        ],
                        'options'=>['autocomplete'=>'off'],

                    ])->label('Fecha Inicio');
                ?>
            </div>
            <div class=" col-12 col-md-3">
               <?php 
                    echo $form->field($model, 'Fecha_Final',[ 'options' => [ 'style' => '']])->widget(DatePicker::classname(), [
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'todayBtn' => true,
                            'format' => 'dd/mm/yyyy',
                        ],
                        'options'=>['autocomplete'=>'off'],

                    ])->label('Fecha Fin');
                ?>
            </div>
            <div class="col-md-6 col-md-offset-3 form-group" style="text-align:center">
                <?= Html::submitButton('Generar Reporte', ['class' => 'btn btn-primary','id'=>'btn_guardar', 'name'=>'btn_guardar']) ?>
            </div>

               
                <?php ActiveForm::end(); ?>
            
        </div>
        
        
   
  
</div>
