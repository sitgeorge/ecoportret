<!doctype html>
<?php 
      include_once ( 'scripts/db.php' );
      $result = Null;
?>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>R
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">
  <meta http-equiv="Cache-Control" content="no-cache">

  <link rel="stylesheet" href="css/main.css">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
	<script src="js/jquery-1.11.1.min.js"></script>
  	<script src="js/base.js"></script>
    <script src="js/popup.js"></script>
  	<input type="button" id="testbtn" value="Click me"/>
  	<?php 
      if (isset($_GET["file"]))
      {
        $result = detail_view($_GET["file"], Null);
        echo print_r($result);
      } 
    ?>


</body>
</html>