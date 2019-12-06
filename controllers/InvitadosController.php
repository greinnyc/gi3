<?php

namespace app\controllers;

use Yii;
use app\models\Invitados;
use app\models\InvitadosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\components\Helper;



/**
 * InvitadosController implements the CRUD actions for Invitados model.
 */
class InvitadosController extends Controller
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
     * Lists all Invitados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvitadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invitados model.
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
     * Creates a new Invitados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invitados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->invitado_codigo]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Invitados model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->invitado_codigo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Invitados model.
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
     * Finds the Invitados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invitados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invitados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    

    public function actionSaveInvitadoEmpleadoEvento($invitado_codigo,$codigo_empleado,$activo,$evento_codigo){
        $model = new Invitados();
        $model->evento_codigo = $evento_codigo;
        $model->empleado_codigo = $codigo_empleado;
        $model->activo = $activo;
        $model->usuario_modificacion = Helper::getUserDefault();
        $model->fecha_modificacion = Helper::getDateTimeNow();
        $model->invitado_codigo = $model->existInvitadoEmpleadoEvento($evento_codigo,$codigo_empleado);

        if($model->invitado_codigo == false){
            $model->usuario_registro = Helper::getUserDefault();
            $model->fecha_registro = Helper::getDateTimeNow();                                          
            $model->AddInvitadoEvento();

        }else{
            $model->updateInvitadoEvento();
        }
          
    }

     public function actionGetInvitadoEmpleadoEvento($empleadoInvitado){
        $model = new Invitados();
        $invitado = $model->getInvitadoEmpleadoEvento($empleadoInvitado);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $invitado;
       
    }
}
