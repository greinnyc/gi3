<?php

namespace app\models;

use Yii;
use app\components\Helper;
use yii\db\Expression;



/**
 * This is the model class for table "log_acciones_evento".
 *
 * @property int $log_codigo
 * @property int $evento_codigo
 * @property int $proceso_codigo
 * @property int $empleado_codigo
 * @property string $descripcion
 * @property int $usuario_registro
 * @property int $fecha_registro
 *
 * @property Eventos $eventoCodigo
 * @property EventoProceso $procesoCodigo
 * @property Empleado $empleadoCodigo
 */
class LogAccionesEvento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_acciones_evento';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_invitado');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['log_codigo', 'evento_codigo', 'proceso_codigo', 'empleado_codigo', 'descripcion', 'usuario_registro', 'fecha_registro'], 'required'],
            [['log_codigo', 'evento_codigo', 'proceso_codigo', 'empleado_codigo', 'usuario_registro', 'fecha_registro'], 'integer'],
            [['descripcion'], 'string'],
            [['log_codigo'], 'unique'],
            [['evento_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Eventos::className(), 'targetAttribute' => ['evento_codigo' => 'evento_codigo']],
            /*[['proceso_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => EventoProceso::className(), 'targetAttribute' => ['proceso_codigo' => 'proceso_codigo']],
            [['empleado_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Empleado::className(), 'targetAttribute' => ['empleado_codigo' => 'empleado_codigo']],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'log_codigo' => 'Log Codigo',
            'evento_codigo' => 'Evento Codigo',
            'proceso_codigo' => 'Proceso Codigo',
            'empleado_codigo' => 'Empleado Codigo',
            'descripcion' => 'Descripcion',
            'usuario_registro' => 'Usuario Registro',
            'fecha_registro' => 'Fecha Registro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventoCodigo()
    {
        return $this->hasOne(Eventos::className(), ['evento_codigo' => 'evento_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcesoCodigo()
    {
        return $this->hasOne(EventoProceso::className(), ['proceso_codigo' => 'proceso_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleadoCodigo()
    {
        return $this->hasOne(Empleado::className(), ['empleado_codigo' => 'empleado_codigo']);
    }

    public function registrarLog(){
        $query = Yii::$app->db_invitado->createCommand("SELECT case when max(log_codigo) is null then 1 else max(log_codigo)+1 end as id 
            from DB_Invitado.dbo.log_acciones_evento")->queryAll();
        $this->log_codigo = $query[0]['id'];

        Yii::$app->db_invitado->createCommand()->insert('DB_Invitado.dbo.log_acciones_evento', [
                                            'log_codigo' => $this->log_codigo,
                                            'evento_codigo' => $this->evento_codigo,
                                            'proceso_codigo'=>$this->proceso_codigo,
                                            'empleado_codigo'=>$this->empleado_codigo,
                                            'descripcion'=>$this->descripcion,
                                            'fecha_registro'=>new Expression("getdate()"),
                                            'usuario_registro'=>Helper::getUserDefault(),
        ])->execute();
    }
}


