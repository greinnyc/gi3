<?php

namespace app\controllers;

use Yii;
use app\models\ItemsInvitado;
use app\models\Invitados;
use app\models\Empleado;
use app\models\Eventos;
use app\components\Helper;
use app\models\ItemsInvitadoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemsInvitadoController implements the CRUD actions for ItemsInvitado model.
 */
class ItemsInvitadoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all ItemsInvitado models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemsInvitadoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ItemsInvitado model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ItemsInvitado model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ItemsInvitado();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->items_invitado_codigo]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ItemsInvitado model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->items_invitado_codigo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ItemsInvitado model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ItemsInvitado model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemsInvitado the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemsInvitado::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

     /**
     * muestra vista para registrar ingreso.
     * @return mixed
     */
    public function actionRegistrarEntregaItems()
    {
       //validar si tiene token activo sino preguntar token

        return $this->render('registro-items-invitados', []);
    }

    public function actionConsultarDocumento()
    {
       //validar si tiene token activo sino preguntar token
        $model_empleado = new Empleado();
        $model_invitados = new Invitados();
        $model_eventos = new Eventos();
        $ItemsInvitado = new ItemsInvitado();
        if ($model_invitados->load(Yii::$app->request->post())) {
            $empleado = $model_invitados->getInvitadoDocumentoIndentidad();
            //si esta invitado
            if($empleado != false){
                //si esta activo en el evento y en la empresa
                if($empleado['activo'] == 1 && $empleado['estado_codigo'] == 1){
                    $ingresoEmpleado= $ItemsInvitado->getIngresoInvitado($empleado['invitado_codigo'],$empleado['evento_codigo']);
                    if($ingresoEmpleado != false){
                        $evento_codigo = $empleado['evento_codigo'];
                        $ItemsInvitado->invitado_codigo = $empleado['invitado_codigo'];
                        $items = $ItemsInvitado->getItemsInvitado($evento_codigo);
                        return $this->render('informacion-invitado', [ 
                            'model'=>$ItemsInvitado,
                            'empleado' => $empleado,
                            'model_eventos'=>$model_eventos,
                            'items'=>$items
                        ]);
                    }else{
                        Yii::$app->session->setFlash('flashMsgError', "El invitado debe registrar su ingreso."); 
                        return $this->render('registro-items-invitados', []);
                    }
                    
                }else{
                    Yii::$app->session->setFlash('flashMsgError', "El empleado no esta activo."); 
                    return $this->render('registro-items-invitados', []);
                }
            }else{
                Yii::$app->session->setFlash('flashMsgError', "El empleado no esta invitado al evento."); 
                return $this->render('registro-items-invitados', []);
            }
            
        }
        return $this->render('consultar-documento', [ 
            'model_invitados' => $model_invitados,
            'model_eventos'=>$model_eventos,
        ]);
    }

        public function actionEscanearQr()
    {   
        $model = new Invitados();
        $model_eventos = new Eventos();
        if(count($_POST) > 0){
            $model->evento_codigo = $_POST['evento_codigo'];
            $model->numero_documento = $_POST['numero_documento'];
            $empleado = $model->getInvitadoDocumentoIndentidad();
            if($empleado != false){
                if($empleado['activo'] == 1 && $empleado['estado_codigo'] == 1){
                    $ItemsInvitado = new ItemsInvitado();
                    $evento_codigo = $empleado['evento_codigo'];
                    $ItemsInvitado->invitado_codigo = $empleado['invitado_codigo'];
                    $items = $ItemsInvitado->getItemsInvitado($evento_codigo);
                    return $this->render('informacion-invitado', [ 
                        'model'=>$ItemsInvitado,
                        'empleado' => $empleado,
                        'model_eventos'=>$model_eventos,
                        'items'=>$items
                    ]);
                }else{
                    Yii::$app->session->setFlash('flashMsgError', "El empleado no esta activo."); 
                    return $this->render('registro-items-invitados', []);
                }
            }else{
                Yii::$app->session->setFlash('flashMsgError', "El empleado no esta invitado al evento."); 
                return $this->render('registro-items-invitados', []);
            }
        }
        return $this->render('escanear-qr', [ ]);
    }

    public function actionRegistrarItemsInvitado()
    {
        $model = new ItemsInvitado();
        $formulario = $_POST;
        $model->invitado_codigo = $formulario['invitado_codigo'];
        $items = $model->getItemsInvitado($_POST['evento_codigo']);
        $model->fecha_registro = Helper::getDateTimeNow();
        $model->fecha_modificacion = Helper::getDateTimeNow();
        $model->usuario_registro = Helper::getUserDefault();
        $model->usuario_modificacion = Helper::getUserDefault();
        $model->ip_registro = Helper::getUserIpAddr();
        $items_invitado = [];
        foreach ($items as $key => $value) {
            $items_array = [];
            $items_array = [
                                "items_evento_codigo"=>$value['item_evento_codigo'],
                                "estado_codigo"=>$_POST['items_'.$value['item_evento_codigo']]

                            ];
            array_push($items_invitado, $items_array);
        }


        $model->MasivoRegistroItemsInvitado($items_invitado);

        Yii::$app->session->setFlash('flashMsgExito', "Se registró exitosamente.");
        return $this->redirect(['items-invitado/registrar-entrega-items']);
    }

}
