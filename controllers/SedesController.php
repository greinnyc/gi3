<?php

namespace app\controllers;

use Yii;
use app\models\Sedes;
use app\models\SedesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\Helper;


/**
 * SedesController implements the CRUD actions for Sedes model.
 */
class SedesController extends Controller
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
     * Lists all Sedes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SedesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sedes model.
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
     * Creates a new Sedes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sedes();
        $model->fecha_modificacion = Helper::getDateTimeNow();
        $model->usuario_modificacion =Helper::getUserDefault();
        $model->fecha_registro = Helper::getDateTimeNow();
        $model->usuario_registro =Helper::getUserDefault();
        $model->sede_codigo = $model->getNextRecord();
        $model->organizacion_codigo = Yii::$app->params['codigo_pais'];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('flashMsgExito', "Se registró exitosamente.");
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sedes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->fecha_modificacion = Helper::getDateTimeNow();
        $model->usuario_modificacion =Helper::getUserDefault();
        $model->fecha_registro = Helper::getDateTimeNow();
        $model->usuario_registro =Helper::getUserDefault();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

             Yii::$app->session->setFlash('flashMsgExito', "Se registró exitosamente.");
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sedes model.
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
     * Finds the Sedes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sedes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sedes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
