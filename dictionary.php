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
<!--        
        <div class="dropdown">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
            Dropdown
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Copy</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Cut</a></li>
            <li role="presentation" class="disabled"><a role="menuitem" tabindex="-1" href="#">Past</a></li>
          </ul>
        </div>       
        <button type="button" class="btn btn-default">New</button>
        <button type="button" class="btn btn-default" disabled="disabled">Edit</button>
        <button type="button" class="btn btn-default" disabled="disabled">Delete</button>      
-->
<!--
        <div class="btn-group" role="group" aria-label="...">
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">New</button>
          <button type="button" class="btn btn-default" disabled="disabled">Edit</button>
          <button type="button" class="btn btn-default" disabled="disabled">Delete</button>

          <div class="btn-group" role="group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              Dropdown
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Copy</a></li>
              <li><a href="#">Cut</a></li>
              <li class="disabled"><a href="#">Paste</a></li>
            </ul>
          </div>
        </div>
-->
      </div>
      <div class="message">

      </div>
      <div class="panel panel-default">
        <div class="panel-heading">Panel heading without title</div>
        <div class="panel-body">
          <?php
            include_once ( 'dictionary_helper.php' );

            echo '<table class="table table-hover table-bordered">';

            measurementunit_render($dictionary_content);

            echo '</table>';

          //echo print_r($dictionary_content);
          ?>
        </div>
      </div>      
  </div>
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Modal title</h4>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>  
  </body>
</html>