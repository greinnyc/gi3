<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tarea".
 *
 * @property int $tarea_codigo
 * @property string $nombre
 * @property int $activo
 *
 * @property StaffEvento[] $staffEventos
 */
class Tarea extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarea';
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
            [['tarea_codigo', 'nombre'], 'required'],
            [['tarea_codigo', 'activo'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['tarea_codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tarea_codigo' => 'Tarea Codigo',
            'nombre' => 'Nombre',
            'activo' => 'Estado',
        ];
    }

    public function getNextRecord()
    {
        $model2 = $this->find()->orderBy(['tarea_codigo' => SORT_DESC])->one();
        if($model2 !== null) {
             $codigo  = $model2->tarea_codigo+1;
        }else {
             $codigo  = 1;
        }
        return $codigo;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaffEventos()
    {
        return $this->hasMany(StaffEvento::className(), ['tarea_codigo' => 'tarea_codigo']);
    }
}
