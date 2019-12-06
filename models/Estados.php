<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "estados".
 *
 * @property int $estado_codigo
 * @property string $valor
 * @property string $activo
 *
 * @property Empleado[] $empleados
 * @property Eventos[] $eventos
 * @property ItemsInvitado[] $itemsInvitados
 */
class Estados extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estados';
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
            [['estado_codigo', 'valor', 'activo'], 'required'],
            [['estado_codigo'], 'integer'],
            [['valor'], 'string', 'max' => 255],
            [['activo'], 'string', 'max' => 1],
            [['estado_codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'estado_codigo' => 'Estado Codigo',
            'valor' => 'Valor',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpleados()
    {
        return $this->hasMany(Empleado::className(), ['estado_codigo' => 'estado_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Eventos::className(), ['Estado_codigo' => 'estado_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsInvitados()
    {
        return $this->hasMany(ItemsInvitado::className(), ['estado_codigo' => 'estado_codigo']);
    }

    public function getEstado($id){
        $query = Yii::$app->db_invitado->createCommand("SELECT estado_codigo as Codigo, valor as Descripcion
            from DB_Invitado.dbo.estados
            WHERE estado_codigo =".$id)->queryAll();
        if(count($query)>0){
            return $query['Descripcion'];
        }
        return false;

    }
}
