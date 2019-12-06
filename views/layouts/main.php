<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;



AppAsset::register($this);
$mensaje_error = Yii::$app->session->getFlash('flashMsgError');
$mensaje_success = Yii::$app->session->getFlash('flashMsgExito');

if (Yii::$app->session->hasFlash('flashMsgError')){
  $js=<<< JS
    
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    toastr.error('<div style="font-size:16px">$mensaje_error</div>')
JS;
$this->registerJs($js, yii\web\View::POS_READY);

}

if (Yii::$app->session->hasFlash('flashMsgExito')){
  $js=<<< JS
    
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    toastr.success('<div style="font-size:16px">$mensaje_success</div>')
JS;
$this->registerJs($js, yii\web\View::POS_READY);

}



?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item" style="padding-left: 10px;">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
          <?= Html::a('<i  style="color:red" class="fas fa-power-off"></i>', Url::to(['main/logout'], false),['class'=>'nav-link'])?>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <!--<?= Html::img('@web/dist/img/AdminLTELogo.png',['class' => 'brand-image img-circle elevation-3','alt' => 'AdminLTE Logo','style'=>['opacity'=>'.8']]) ?>-->

      <div style="text-align: center;"> <span class="brand-text font-weight-light" >GESTIÓN DE INVITADOS</span></div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          
          <?= Html::img(Yii::$app->params['url_fotos'].Yii::$app->user->identity->Empleado_Dni.'.jpg',['class' => 'img-30x30 img-circle elevation-2','alt' => 'User Avatar']) ?>
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=Yii::$app->user->identity->Empleado_Nombres?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
              <?= Html::a('<i class="far fa-calendar-alt"></i> <p>Creación de Eventos</p>', Url::to(['/eventos/index'], false),['class'=>'nav-link'])?>
            </a>
          </li>
          <li class="nav-item">
            <?= Html::a('<i class="fas fa-clipboard-check"></i> <p>Registrar ingreso</p>', Url::to(['/ingreso-evento/registrar-ingreso'], false),['class'=>'nav-link'])?>
          </li>
          <li class="nav-item">
            <?= Html::a('<i class="fas fa-gifts"></i> <p>Registrar entrega de Ítems</p>', Url::to(['/items-invitado/registrar-entrega-items'], false),['class'=>'nav-link'])?>
          </li>
          <li class="nav-item">
            <?= Html::a('<i class="fas fa-file-excel"></i> <p>Reportes</p>', Url::to(['/reportes/index'], false),['class'=>'nav-link'])?>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-stream"></i>
              <p>
                Maestros
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item">
               
                <?= Html::a('<i class="nav-icon far fa-circle text-info"></i> <p>Ítems</p>', Url::to(['/items-catalogo/index'], false),['class'=>'nav-link'])?>

              </li>
              <li class="nav-item">
                <?= Html::a('<i class="nav-icon far fa-circle text-info"></i> <p>Sedes</p>', Url::to(['/sedes/index'], false),['class'=>'nav-link'])?>
              </li>
              <li class="nav-item">
                <?= Html::a('<i class="nav-icon far fa-circle text-info"></i> <p>Ubicaciones</p>', Url::to(['/sede-ubicacion/index'], false),['class'=>'nav-link'])?>
              </li>
              <li class="nav-item">
                <?= Html::a('<i class="nav-icon far fa-circle text-info"></i> <p>Tareas</p>', Url::to(['/tarea/index'], false),['class'=>'nav-link'])?>
              </li>
            </ul>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <?= $content ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0
    </div>
    <strong>©<?=date("Y")?> Gerencia Regional de Desarrollo de Sistemas <span style="color:#332c2c;text-shadow:none;"> Atento-Per&uacute; </span></strong> 
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
