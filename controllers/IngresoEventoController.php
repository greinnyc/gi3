<?php

namespace app\controllers;

use Yii;
use app\models\IngresoEvento;
use app\models\Invitados;
use app\models\Empleado;
use app\models\Eventos;
use app\models\LogAccionesEvento;
use app\components\Helper;
use app\models\IngresoEventoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\StaffEvento;

/**
 * IngresoEventoController implements the CRUD actions for IngresoEvento model.
 */
class IngresoEventoController extends Controller
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
     * Lists all IngresoEvento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IngresoEventoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    /**
     * Displays a single IngresoEvento model.
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
     * Creates a new IngresoEvento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IngresoEvento();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ingreso_codigo]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing IngresoEvento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ingreso_codigo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing IngresoEvento model.
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
     * Finds the IngresoEvento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IngresoEvento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IngresoEvento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

     /**
     * muestra vista para registrar ingreso.
     * @return mixed
     */
    public function actionRegistrarIngreso()
    {
        $session = Yii::$app->session;

       //validar si tiene token activo sino preguntar token
        /*$model_staff = new StaffEvento();
        if($session->has('token') == false){
            return $this->render('registrar-token', ['model_staff'=>$model_staff]);
        }*/

        return $this->render('registrar-ingreso', []);
    }

    public function actionConsultarDocumento()
    {
       //validar si tiene token activo sino preguntar token
        $model_empleado = new Empleado();
        $model_invitados = new Invitados();
        $model_eventos = new Eventos();
        $model_log = new LogAccionesEvento();
        if ($model_invitados->load(Yii::$app->request->post())) {
            $empleado = $model_invitados->getInvitadoDocumentoIndentidad();
            $model_log->evento_codigo = $model_invitados->evento_codigo;
            $model_log->proceso_codigo = 1;
            $model_log->empleado_codigo = $empleado['empleado_codigo'];

            if($empleado != false){
                if($empleado['activo'] == 1 && $empleado['estado_codigo'] == 1){
                    $model_log->descripcion = 'Se ingreso documento en el ingreso';
                    $model_log->registrarLog();
                    return $this->render('informacion-invitado', [ 
                        'empleado' => $empleado,
                        'model_eventos'=>$model_eventos
                    ]);
                }else{
                    Yii::$app->session->setFlash('flashMsgError', "El empleado no esta activo."); 
                    $model_log->descripcion = 'El empleado no esta activo.';
                    $model_log->registrarLog();
                    return $this->render('registrar-ingreso', []);
                }
            }else{
                Yii::$app->session->setFlash('flashMsgError', "El empleado no esta invitado al evento."); 
                $model_log->descripcion = 'El empleado no esta invitado al evento.';
                $model_log->registrarLog();
                return $this->render('registrar-ingreso', []);
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
        $model_log = new LogAccionesEvento();
        if(count($_POST) > 0){
            $model->evento_codigo = $_POST['evento_codigo'];
            $model_log->evento_codigo = $model->evento_codigo;
            $model_log->proceso_codigo = 1;
            $model->numero_documento = $_POST['numero_documento'];
            $empleado = $model->getInvitadoDocumentoIndentidad();
            $model_log->empleado_codigo = $empleado['empleado_codigo'];
            if($empleado != false){
                if($empleado['activo'] == 1 && $empleado['estado_codigo'] == 1){
                    $model_log->descripcion = 'Se escaneo QR en el ingreso.';
                    $model_log->registrarLog();
                    return $this->render('informacion-invitado', [ 
                        'empleado' => $empleado,
                        'model_eventos'=>$model_eventos
                    ]);
                }else{
                    Yii::$app->session->setFlash('flashMsgError', "El empleado no esta activo."); 
                    $model_log->descripcion = 'El empleado no esta activo.';
                    $model_log->registrarLog();
                    return $this->render('registrar-ingreso', []);

                }
            }else{
                Yii::$app->session->setFlash('flashMsgError', "El empleado no esta invitado al evento."); 
                $model_log->descripcion = 'El empleado no esta invitado al evento.';
                $model_log->registrarLog();
                return $this->render('registrar-ingreso', []);
            }
            
        }
        return $this->render('escanear-qr', [ ]);
    }

    public function actionRegistrarIngresoInvitado()
    {
        $model = new IngresoEvento();
        $model_log = new LogAccionesEvento();
        
        $model->invitado_codigo = $_POST['invitado_codigo'];
        $model->sede_codigo = $_POST['sede_codigo'];
        $model->evento_codigo = $_POST['evento_codigo'];
        $model_log->evento_codigo = $model->evento_codigo;
        $model_log->empleado_codigo = $_POST['empleado_codigo'];
        $model_log->proceso_codigo = 1;
        $model->fecha_ingreso = Helper::getDateTimeNow();
        $model->Ip = Helper::getUserIpAddr();
        $model->usuario_registro = Helper::getUserDefault();
        if(array_key_exists('btn_guardar',$_POST)){
            $model->insertRegistrarIngresoEvento();
            $model_log->descripcion = 'Se registro correctamente el usuario en el evento.';
            $model_log->registrarLog();
            Yii::$app->session->setFlash('flashMsgExito', "Se registró exitosamente");

        }else{
            $model_log->descripcion = 'Error al registrar el usuario en el evento.';
            $model_log->registrarLog();
            Yii::$app->session->setFlash('flashMsgError', "No se pudo realizar el registro de ingreso."); 

        }
     
        return $this->redirect(['ingreso-evento/registrar-ingreso']);


    }


}
