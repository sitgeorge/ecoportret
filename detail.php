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
  <link href="css/jquery.treetable.css" rel="stylesheet" type="text/css" />
  <link href="css/jquery.treetable.theme.default.css" rel="stylesheet" type="text/css" />

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
	  <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.treetable.js"></script>
  	<!--<script src="js/base.js"></script>
    <script src="js/popup.js"></script>-->
    
  	<input type="button" id="testbtn" value="Click me"/>
  	<?php 
      if (isset($_GET["file"]))
      {
        $result = detail_view($_GET["file"], Null);
        echo '<table id="example-basic-expandable"><thead><tr><td>detailname</td><td>detailtypeid</td><td>detaildescription</td><td>detailgost</td><td>amount</td><td>measurementunitid</td><td>amountmaterial</td><td>amountmaterialtotal</td><td>comment</td></tr></thead>';

        foreach ($result as $item) {
          $parent = "";
          if ($item["detailid"] != $item["_parent"])
            $parent = "data-tt-parent-id='".$item["_parent"]."'";
          echo '<tr data-tt-id="'.$item["detailid"].'" '.$parent.'><td>'.$item["detailname"].'</td><td>'.$item["detailtypeid"].'</td><td>'.$item["detaildescription"].'</td><td>'.$item["detailgost"].'</td><td>'.$item["amount"].'</td><td>'.$item["measurementunitid"].'</td><td>'.$item["amountmaterial"].'</td><td>'.$item["amountmaterialtotal"].'</td><td>'.$item["comment"].'</td></tr>';
        }
        echo '</table>';
        //echo print_r($result);

      } 
    ?>


<script>
      $("#example-basic-expandable").treetable({ expandable: true });
    </script>

</body>
</html>