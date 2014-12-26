<!doctype html>
<?php 
      include_once ( 'scripts/db.php' );
      $result = Null;
?>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">
  <meta http-equiv="Cache-Control" content="no-cache">

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/jquery.treegrid.css">
  <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <style>
    body {
    }
    .content {
      margin: 50px 135px;
      width: 940px;
    }
    .toolbar {
      display: block;
      margin: 20px 0;
    }
  </style>
</head>

<body>
    <script src="js/jquery.js"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/jquery.treegrid.js"></script>
  	<script src="js/details_base.js"></script>
    <div class="content">
    <div class="toolbar">
      <div class="btn-group" role="group" aria-label="...">
        <button type="button" class="btn btn-default" id="copybtn">Копировать</button>
        <button type="button" class="btn btn-default" id="cutbtn">Вырезать</button>
        <button type="button" class="btn btn-default" id="pastebtn" disabled="disabled">Вставить</button>
        <button type="button" class="btn btn-default" id="deletebtn">Удалить</button>
      </div>
    </div>
  	<?php 
      if (isset($_GET["file"]))
      {
        $result = detail_view($_GET["file"], Null);
        echo '<table id="detailtable" class="tree table table-bordered"><thead><tr><th>Detail</th><th>DType Id</th><th>Description</th><th>Gost</th><th>Amount</th><th>Measure Id</th><th>Material am.</th><th>Total</th><th>Comment</th></tr></thead>';

        foreach ($result as $item) {
          $parent = "";
          $parent1 = "";
          if (($item["detailid"] != $item["_parent"]) && $item["_parent"] != ''){
            $parent1 = " treegrid-parent-".$item["_parent"];
          }
          echo '<tr class="treegrid-'.$item["detailid"].$parent1.'" id="'.$item["detailid"].'"><td>'.$item["detailname"].'</td><td>'.$item["detailtypeid"].'</td><td>'.$item["detaildescription"].'</td><td>'.$item["detailgost"].'</td><td>'.$item["amount"].'</td><td>'.$item["measurementunitid"].'</td><td>'.$item["amountmaterial"].'</td><td>'.$item["amountmaterialtotal"].'</td><td>'.$item["comment"].'</td></tr>';
        }
        echo '</table>';
        //echo print_r($result);

      } 
    ?>
  </div>
</body>
</html>