<!DOCTYPE html>
<?php 
  include_once ( 'scripts/db.php' );
  $id = null;

  if (isset($_GET["id"])) {
    $fileid = $_GET["id"];
  }
  else
    die;

  $dictionary_content = measurementunit_view(null);
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Справочники</title>

    <!-- Bootstrap -->

    <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
      body {
      }
      .content {
        margin: 100px 135px;
        width: 940px;
      }
      .toolbar {
        display: block;
        margin: 20px 0;
      }
    </style>
  </head>
  <body>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js"></script>

    <script src="js/base.js"></script>

    <div class="content">
      <div class="toolbar">
        <button type="button" class="btn btn-default" aria-label="New row" data-placement="top" title="New row" data-toggle="modal" data-target="#dlgEditMeasurementUnit" data-action="new">
          <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
        </button>
      </div>
      <div class="message">

      </div>
      <div class="panel panel-default">
        <div class="panel-heading">Panel heading without title</div>
        <div class="panel-body">
          <?php
            include_once ( 'dictionary_helper.php' );

            echo '<table class="table table-hover table-bordered">';

            measurementunit_render_table($dictionary_content);

            echo '</table>';

          //echo print_r($dictionary_content);
          ?>
        </div>
      </div>      
  </div>
  <!-- Modal -->
  <?php
    measurementunit_render_modal_edit();
    measurementunit_render_modal_delete(null, null);
  ?>
  </body>
</html>