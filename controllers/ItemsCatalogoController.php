<?php

namespace app\controllers;

use Yii;
use app\models\ItemsCatalogo;
use app\models\ItemsCatalogoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\Helper;


/**
 * ItemsCatalogoController implements the CRUD actions for ItemsCatalogo model.
 */
class ItemsCatalogoController extends Controller
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
     * Lists all ItemsCatalogo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemsCatalogoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ItemsCatalogo model.
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
     * Creates a new ItemsCatalogo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ItemsCatalogo();
        $model->fecha_modificacion = Helper::getDateTimeNow();
        $model->usuario_modificacion =Helper::getUserDefault();
        $model->fecha_registro = Helper::getDateTimeNow();
        $model->usuario_registro =Helper::getUserDefault();
        $model->item_codigo = $model->getNextRecord();
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
     * Updates an existing ItemsCatalogo model.
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
     * Deletes an existing ItemsCatalogo model.
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
     * Finds the ItemsCatalogo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemsCatalogo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemsCatalogo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
