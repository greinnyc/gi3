<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Reportes_New".
 *
 * @property int $Rep_Codigo
 * @property int $Usuario_Id
 * @property string $Rep_Fecha
 * @property string $Rep_Nombre
 * @property resource $Rep_Binario
 * @property string $Rep_Extension
 */
class Reportes extends \yii\db\ActiveRecord
{
    public $Tipo_Reporte;
    public $evento_codigo;
    public $Fecha_Inicio;
    public $Fecha_Final;
    public $Rep_Nombre;

  

     
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
            
            [['Tipo_Reporte','evento_codigo'], 'integer'],
            [['Tipo_Reporte','evento_codigo','Fecha_Inicio','Fecha_Final'], 'safe'],
            [['Tipo_Reporte','evento_codigo'], 'required'],
            [['Fecha_Final'],'compare', 'compareValue' => 'Fecha_Inicio',
            'message' => 'Fecha Final debe ser mayor a la Fecha Inicio',
            'whenClient' => "function (attribute, value) {
                    var fechaini = $('#reportes-fecha_inicio').val();
                    var fechafin = $('#reportes-fecha_final').val();
                    var fini = fechaini.split('/');
                    var ffin = fechafin.split('/');
                    var f1 = new Date(fini[2], fini[1]-1,fini[0]);
                    var f2 = new Date(ffin[2], ffin[1]-1,ffin[0]);
                    return (f1 > f2);
            }"],
            /*[['Rep_Nombre'], 'string', 'max' => 250],
            [['Rep_Extension'], 'string', 'max' => 3],
            [['Rep_Codigo'], 'unique'],
            [['Fecha_Inicio'],'compare', 'compareValue' => 'Fecha_Final',
            'message' => 'Fecha Inicio debe ser menor a la Fecha Final',
            'whenClient' => "function (attribute, value) {
                    var fechaini = $('#reportesnew-fecha_inicio').val();
                    var fechafin = $('#reportesnew-fecha_final').val();
                    var fini = fechaini.split('/');
                    var ffin = fechafin.split('/');
                    var f1 = new Date(fini[2], fini[1]-1,fini[0]);
                    var f2 = new Date(ffin[2], ffin[1]-1,ffin[0]);
                    return (f1 > f2);
            }"],
            [['Fecha_Final'],'compare', 'compareValue' => 'Fecha_Inicio',
            'message' => 'Fecha Final debe ser mayor a la Fecha Inicio',
            'whenClient' => "function (attribute, value) {
                    var fechaini = $('#reportesnew-fecha_inicio').val();
                    var fechafin = $('#reportesnew-fecha_final').val();
                    var fini = fechaini.split('/');
                    var ffin = fechafin.split('/');
                    var f1 = new Date(fini[2], fini[1]-1,fini[0]);
                    var f2 = new Date(ffin[2], ffin[1]-1,ffin[0]);
                    return (f1 > f2);
            }"],
            [['Periodo'], 'required', 'when' => function($model) {
                    return $model->Tipo_Reporte == 0;
            },'whenClient' => "function (attribute, value) {
                    return $('#reportesnew-tipo_reporte').val() == 0;
            }"],
            [['Fecha_Inicio','Fecha_Final'], 'required', 'when' => function($model) {
                    return $model->Tipo_Reporte == 3;
            },'whenClient' => "function (attribute, value) {
                    return $('#reportesnew-tipo_reporte').val() == 3;
            }"],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Tipo_Reporte' => 'Tipo de Reporte',
            'evento_codigo' => 'Evento',
            'Fecha_Inicio' => 'Fecha Inicio',
            'Fecha_Final' => 'Fecha Final',
            'Rep_Nombre' => 'Rep Nombre',
            /*'Fecha_Inicio' => 'Rep Fecha',
            
            'Rep_Binario' => 'Rep Binario',
            'Rep_Extension' => 'Rep Extension',
            'Fecha_Inicio' => 'Fecha Inicio',
            'Fecha_Final' => 'Fecha Final'*/
        ];
    }

    public function getDateReporte(){
        return date("Y").date("n").date("d")."_".date("H").date("i").date("s");
    }

    public function reporteIngresoEvento(){
        $query = " SELECT e.numero_documento,e.apellido_paterno+' '+e.apellido_materno+' '+e.nombre as nombre_invitado,
            ie.fecha_ingreso, eve.nombre as nombre_evento,emp.apellido_paterno+' '+emp.apellido_materno+' '+emp.nombre as nombre_staff
            from DB_Invitado.dbo.ingreso_evento ie
            LEFT join DB_Invitado.dbo.invitados i on i.invitado_codigo = ie.invitado_codigo
            LEFT join DB_Invitado.dbo.empleado e on e.empleado_codigo = i.empleado_codigo 
            LEFT join empleado emp on emp.empleado_codigo = ie.usuario_registro
            left join eventos eve on eve.evento_codigo = ie.evento_codigo
            where ie.evento_codigo = ".$this->evento_codigo;

        if($this->Fecha_Inicio != ' ' && $this->Fecha_Final != ' '){
            $query.=" and ie.fecha_ingreso between '".$this->Fecha_Inicio." 00:00:00' and '".$this->Fecha_Final." 23:59:59' "; 
        }
        $query.=" ORDER by ie.fecha_ingreso DESC ";
        
        $detalle = Yii::$app->db_invitado->createCommand($query)->queryAll();
        return $detalle;
    }

    public function reporteRegistroEntregaItems(){
        $query = " SELECT
            e.apellido_paterno+' '+e.apellido_materno+' '+e.nombre as nombre_invitado,
            emp.apellido_paterno+' '+emp.apellido_materno+' '+emp.nombre as nombre_staff,
            ic.nombre+'-'+ic.marca+'-'+ic.modelo as item,e.numero_documento,
            case when ii.estado_codigo = 0 then 'No entregado' else 'Entregado' end as estado,
            ii.fecha_modificacion as fecha_registro,eve.nombre as evento_nombre,
            ii.ip_registro
            from items_invitado ii
            LEFT join items_evento ie on ie.item_evento_codigo=ii.items_evento_codigo
            left join invitados i on i.invitado_codigo = ii.invitado_codigo
            left join empleado e on e.empleado_codigo=i.empleado_codigo
            left join empleado emp on emp.empleado_codigo = ii.usuario_modificacion
            left join items_catalogo ic on ic.item_codigo = ie.item_codigo 
            left join eventos eve on eve.evento_codigo = ie.evento_codigo
            where ie.evento_codigo =".$this->evento_codigo;

        if($this->Fecha_Inicio != ' ' && $this->Fecha_Final != ' '){
            $query.=" and ii.fecha_modificacion between '".$this->Fecha_Inicio." 00:00:00' and '".$this->Fecha_Final." 23:59:59' "; 
        }
        $query.=" ORDER by nombre_invitado ";
        $detalle = Yii::$app->db_invitado->createCommand($query)->queryAll();
        return $detalle;
    }

    public function reporteInvitadosEvento(){
        $query = " SELECT 
            e.numero_documento,
            e.apellido_paterno+' '+e.apellido_materno+' '+e.nombre as nombre_invitado,
            eve.nombre as nombre_evento
            from invitados i
            left JOIN empleado e on e.empleado_codigo = i.empleado_codigo
            left JOIN eventos eve on eve.evento_codigo = i.evento_codigo
            where i.evento_codigo = ".$this->evento_codigo;
        $detalle = Yii::$app->db_invitado->createCommand($query)->queryAll();
        return $detalle;
    }





    
    

}
