<?php

namespace app\controllers;

use Yii;
use app\models\Reportes;
use app\models\Eventos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\Helper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\EmpleadoLoginAcceso;
use yii\filters\AccessControl;



/**
 * ReportesController implements the CRUD actions for Reportes model.
 */
class ReportesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
       /* $obj = new EmpleadoLoginAcceso();
        $arr = $obj->obtenAcciones();
        if(count($arr)>0) {
            array_push($arr,'');
        }
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => $arr,
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@','?'], 
                    ],
                ],
                'denyCallback' => function ($rule, $action) {  
                    if(Yii::$app->user->isGuest) {
                        Yii::$app->response->redirect(['main/login']);
                    }else {
                       Yii::$app->response->redirect(['site/noautorizado']);
                    }
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];*/
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Reportes models.
     * @return mixed
     */
    public function actionIndex()
    {   
        $model = new Reportes();
        $model_eventos = New Eventos();

        if($request = Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && !array_key_exists('btn_guardar',$_POST)) {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && array_key_exists('btn_guardar',$_POST)) {

            if($model->Tipo_Reporte != ''){
                switch ($model->Tipo_Reporte) {
                    case 0:   
                        return $this->redirect(Url::to(['registro-ingreso-evento','Fecha_Inicio' => $model->Fecha_Inicio,'Fecha_Final' => $model->Fecha_Final,'Tipo_Reporte'=>$model->Tipo_Reporte,'evento_codigo'=>$model->evento_codigo]));
                        break;
                    case 1:
                        return $this->redirect(Url::to(['registro-entrega-items','Fecha_Inicio' => $model->Fecha_Inicio,'Fecha_Final' => $model->Fecha_Final,'Tipo_Reporte'=>$model->Tipo_Reporte,'evento_codigo'=>$model->evento_codigo]));
                        break;
                    case 2:
                        return $this->redirect(Url::to(['invitados-evento','Fecha_Inicio' => $model->Fecha_Inicio,'Fecha_Final' => $model->Fecha_Final,'Tipo_Reporte'=>$model->Tipo_Reporte,'evento_codigo'=>$model->evento_codigo]));
                        break;
                     default:
                        break;
                   
                }
                $this->layout = 'reporte';
            }else{
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return $this->render('index', [
            'model_eventos'=>$model_eventos,
            'model'=>$model
        ]);
        
    }

    public function actionRegistroIngresoEvento($Fecha_Inicio,$Fecha_Final,$Tipo_Reporte,$evento_codigo){
        $model = new Reportes();
        $model->Fecha_Inicio = Helper::formateaFechaSQL($Fecha_Inicio);
        $model->Fecha_Final = Helper::formateaFechaSQL($Fecha_Final);
        $model->Tipo_Reporte = $Tipo_Reporte;
        $model->evento_codigo = $evento_codigo;
        $model->Rep_Nombre = "reporte_registro_ingreso_evento".$model->getDateReporte().".xls";
        $query = $model->reporteIngresoEvento();
        $pagina = 'reporte_registro_ingreso_evento';
        $this->layout = 'reporte';
        return $this->render($pagina, [
                'model'=> $query,
                'name'=>$model->Rep_Nombre,
        ]);
    }

    public function actionRegistroEntregaItems($Fecha_Inicio,$Fecha_Final,$Tipo_Reporte,$evento_codigo){
        $model = new Reportes();
        $model->Fecha_Inicio = Helper::formateaFechaSQL($Fecha_Inicio);
        $model->Fecha_Final = Helper::formateaFechaSQL($Fecha_Final);
        $model->Tipo_Reporte = $Tipo_Reporte;
        $model->evento_codigo = $evento_codigo;
        $model->Rep_Nombre = "reporte_registro_entrega_items".$model->getDateReporte().".xls";
        $query = $model->reporteRegistroEntregaItems();
        $pagina = 'reporte_registro_entrega_items';
        $this->layout = 'reporte';
        return $this->render($pagina, [
                'model'=> $query,
                'name'=>$model->Rep_Nombre,
        ]);
    }

    public function actionInvitadosEvento($Fecha_Inicio,$Fecha_Final,$Tipo_Reporte,$evento_codigo){
        $model = new Reportes();
        $model->Fecha_Inicio = Helper::formateaFechaSQL($Fecha_Inicio);
        $model->Fecha_Final = Helper::formateaFechaSQL($Fecha_Final);
        $model->Tipo_Reporte = $Tipo_Reporte;
        $model->evento_codigo = $evento_codigo;
        $model->Rep_Nombre = "reporte_invitados_evento".$model->getDateReporte().".xls";
        $query = $model->reporteInvitadosEvento();
        $pagina = 'reporte_invitados_evento';
        $this->layout = 'reporte';
        return $this->render($pagina, [
                'model'=> $query,
                'name'=>$model->Rep_Nombre,
        ]);
    }



    
}
