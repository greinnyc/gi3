<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items_invitado".
 *
 * @property int $items_invitado_codigo
 * @property int $items_evento_codigo
 * @property int $invitado_codigo
 * @property int $estado_codigo
 * @property string $fecha_registro
 * @property string $fecha_modificacion
 * @property int $usuario_registro
 * @property int $usuario_modificacion
 * @property string $ip_registro
 *
 * @property Invitados $invitadoCodigo
 * @property ItemsEvento $itemsEventoCodigo
 * @property Estados $estadoCodigo
 */
class ItemsInvitado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'items_invitado';
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
            [['items_invitado_codigo', 'items_evento_codigo', 'invitado_codigo', 'estado_codigo', 'fecha_registro', 'fecha_modificacion', 'usuario_registro', 'usuario_modificacion', 'ip_registro'], 'required'],
            [['items_invitado_codigo', 'items_evento_codigo', 'invitado_codigo', 'estado_codigo', 'usuario_registro', 'usuario_modificacion'], 'integer'],
            [['fecha_registro', 'fecha_modificacion'], 'safe'],
            [['ip_registro'], 'string', 'max' => 42],
            [['items_invitado_codigo'], 'unique'],
            [['invitado_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Invitados::className(), 'targetAttribute' => ['invitado_codigo' => 'invitado_codigo']],
            [['items_evento_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => ItemsEvento::className(), 'targetAttribute' => ['items_evento_codigo' => 'item_evento_codigo']],
            /*[['estado_codigo'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado_codigo' => 'estado_codigo']],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'items_invitado_codigo' => 'Items Invitado Codigo',
            'items_evento_codigo' => 'Items Evento Codigo',
            'invitado_codigo' => 'Invitado Codigo',
            'estado_codigo' => 'Estado Codigo',
            'fecha_registro' => 'Fecha Registro',
            'fecha_modificacion' => 'Fecha Modificacion',
            'usuario_registro' => 'Usuario Registro',
            'usuario_modificacion' => 'Usuario Modificacion',
            'ip_registro' => 'Ip Registro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvitadoCodigo()
    {
        return $this->hasOne(Invitados::className(), ['invitado_codigo' => 'invitado_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemsEventoCodigo()
    {
        return $this->hasOne(ItemsEvento::className(), ['item_evento_codigo' => 'items_evento_codigo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstadoCodigo()
    {
        return $this->hasOne(Estados::className(), ['estado_codigo' => 'estado_codigo']);
    }


    public function getItemsInvitado($evento_codigo){
         $query = Yii::$app->db_invitado->createCommand("SELECT ie.item_evento_codigo,ic.nombre,ic.marca,ic.modelo,ii.estado_codigo,ie.stock
            FROM items_evento ie
            left join items_catalogo ic on ic.item_codigo =ie.item_codigo 
            left join items_invitado ii on ii.items_evento_codigo = ie.item_evento_codigo and ii.invitado_codigo =".$this->invitado_codigo."
            where ie.evento_codigo =".$evento_codigo)->queryAll();
        if(count($query)>0){
            return $query;
        }
        return false;
    }

    public function MasivoRegistroItemsInvitado($items_invitado){
        foreach ($items_invitado as $value) {
            $this->items_evento_codigo = $value['items_evento_codigo'];
            $this->estado_codigo = $value['estado_codigo'];
            $itemInvitado = $this->getItemInvitadoCodigo();
            //si el item no existe 
            if($itemInvitado == false){
                $this->insertRegistrarItemsInvitados();
            }else{
                $this->items_invitado_codigo = $itemInvitado['items_invitado_codigo'];
         
                //actualiza el estado del item a entregado
                if($this->estado_codigo == 1){
                    $this->UpdateItemInvitado();
                }             

            }
        }
    }


    public function getItemInvitadoCodigo(){
        $query = Yii::$app->db->createCommand("SELECT items_invitado_codigo ,estado_codigo
            FROM DB_Invitado.dbo.items_invitado
            where items_evento_codigo =".$this->items_evento_codigo." and invitado_codigo=".$this->invitado_codigo)->queryAll();
        if(count($query)>0){
            return $query[0];
        }else{
            return false;
        }
    }

    public function disminuirStock(){
        
        $query = Yii::$app->db->createCommand("SELECT stock-1 as stock 
            from DB_Invitado.dbo.items_evento
            where item_evento_codigo = ".$this->items_evento_codigo)->queryAll();
        $stock = $query[0]['stock'];
        //disminuye solo si hay stock
        if($stock > -1){
            $params =  [
                        'item_evento_codigo' => $this->items_evento_codigo,
                        'stock'=>$stock,
                        'usuario_modificacion'=>$this->usuario_modificacion
                    ];
            Yii::$app->db_invitado->createCommand("UPDATE DB_Invitado.dbo.items_evento
                SET stock=:stock, usuario_modificacion=:usuario_modificacion,fecha_modificacion=getdate()
                WHERE item_evento_codigo=:item_evento_codigo",$params)->execute();
        }
        return $query[0]['stock'];


    }

    public function UpdateItemInvitado(){
        if($this->disminuirStock() > -1){
             $params =  [
                    'items_invitado_codigo' => $this->items_invitado_codigo,
                    'estado_codigo'=>$this->estado_codigo,
                    'fecha_modificacion'=>$this->fecha_modificacion,
                    'usuario_modificacion'=>$this->usuario_modificacion,
                    'ip_registro'=>$this->ip_registro,
                ];
            Yii::$app->db_invitado->createCommand("UPDATE DB_Invitado.dbo.items_invitado
                SET estado_codigo=:estado_codigo, fecha_modificacion=:fecha_modificacion, usuario_modificacion=:usuario_modificacion, ip_registro=:ip_registro
                WHERE items_invitado_codigo=:items_invitado_codigo",$params)->execute();
            return true;
        }else{
            return false;
        }
        
    }


    public function insertRegistrarItemsInvitados(){
        // si no hay stock no inserta al menos que el estado sea 0
        if($this->disminuirStock() > -1 || $this->estado_codigo == 0){
            $query = Yii::$app->db->createCommand("SELECT case when max(items_invitado_codigo) is null then 1 else max(items_invitado_codigo)+1 end as id 
                from DB_Invitado.dbo.items_invitado")->queryAll();
            $this->items_invitado_codigo = $query[0]['id'];
            Yii::$app->db_invitado->createCommand()->insert('DB_Invitado.dbo.items_invitado', [
                                                'items_invitado_codigo' => $this->items_invitado_codigo,
                                                'items_evento_codigo' => $this->items_evento_codigo,
                                                'invitado_codigo' => $this->invitado_codigo,
                                                'estado_codigo'=>$this->estado_codigo,
                                                'fecha_registro'=>$this->fecha_registro,
                                                'fecha_modificacion'=>$this->fecha_modificacion,
                                                'usuario_registro'=>$this->usuario_registro,
                                                'usuario_modificacion'=>$this->usuario_modificacion,
                                                'ip_registro'=>$this->ip_registro,
            ])->execute();
            return true;
        }else{
            return false;
        }
    }

    public function getIngresoInvitado($invitado_codigo,$evento_codigo){
         $query = Yii::$app->db->createCommand("SELECT *
            FROM DB_Invitado.dbo.ingreso_evento
            where invitado_codigo =".$invitado_codigo."
            and evento_codigo =".$evento_codigo." ORDER by fecha_ingreso DESC")->queryAll();
        if(count($query)>0){
            return $query[0];
        }else{
            return false;
        }
    }
}
