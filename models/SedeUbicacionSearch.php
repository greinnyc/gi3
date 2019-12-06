<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SedeUbicacion;
use Yii;

/**
 * SedeUbicacionSearch represents the model behind the search form of `app\models\SedeUbicacion`.
 */
class SedeUbicacionSearch extends SedeUbicacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ubicacion_codigo', 'sede_codigo', 'aforo', 'activo'], 'integer'],
            [['nombre', 'direccion','organizacion_codigo','nombre_sede'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SedeUbicacion::find()->select([
            'ubicacion_codigo' => 'ubicacion_codigo',
            'sede_codigo' => 'sede_ubicacion.sede_codigo',
            'nombre' => 'sede_ubicacion.nombre',
            'nombre_sede'=>'sedes.nombre',
            'direccion' => 'direccion',
            'aforo' => 'aforo',
            'activo' => 'sede_ubicacion.activo',
            'organizacion_codigo'=>'organizacion_codigo'
        ]);
        $query->innerJoin('sedes', ' sede_ubicacion.sede_codigo = sedes.sede_codigo ');


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ubicacion_codigo' => $this->ubicacion_codigo,
            'sede_codigo' => $this->sede_codigo,
            'aforo' => $this->aforo,
            'sede_ubicacion.activo' => $this->activo,
            'organizacion_codigo'=>Yii::$app->params['codigo_pais']
        ]);

        $query->andFilterWhere(['like', 'sede_ubicacion.nombre', $this->nombre])
            ->andFilterWhere(['=', 'sedes.organizacion_codigo', $this->organizacion_codigo])
            ->andFilterWhere(['like', 'sedes.nombre', $this->nombre_sede])
            ->andFilterWhere(['like', 'direccion', $this->direccion]);

        return $dataProvider;
    }
}
