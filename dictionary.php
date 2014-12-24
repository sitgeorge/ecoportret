<!DOCTYPE html>
<?php 
  include_once ( 'scripts/db.php' );
  $id = null;

  if (isset($_GET["id"])) {
    $fileid = $_GET["id"];
  }
  else
    die;

  $dictionary_content = null;

  $search_string = null;

  if ( isset( $_GET["searchstring"] ) ) {
    $search_string = $_GET["searchstring"];
  } 

  switch ( $fileid ) {
    case 1:
      $dictionary_content = measurementunit_view(null);
    break;
    case 2:
      $dictionary_content = detailtype_view($search_string, null, null, null);
    break;
  }
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

      <?php
        include_once ( 'dictionary_helper.php' );

        switch ( $fileid ) {
          case 1:
            measurementunit_render_page($dictionary_content);
          break;
          case 2:
/*          
            echo "<pre>";
            var_dump($dictionary_content); 
            echo "</pre>";
*/            
            detailtype_render_page($fileid, $dictionary_content);
          break;
        }
      ?>
  
    </div>
  <!-- Modal -->
  <?php
    switch ( $fileid ) {
      case 1:
        measurementunit_render_modal_edit();
      break;
      case 2:
        detailtype_render_modal_edit();
      break;
    }
  ?>
  </body>
</html>