<!doctype html>
<?php 
      include_once ( 'scripts/db.php' );
      $path = "home";
      $locationId = Null;
      $showBackLink = false;
      if (isset($_GET["path"]))
      {
        if ($_GET["path"] != "home")
        {
          $path = $_GET["path"];
          $locationsArray = explode("/", $path);
          $loccount = count($locationsArray);
          if ($loccount != 1)
          {
            $locationId = $locationsArray[$loccount - 1];
            array_pop($locationsArray);
            $showBackLink = true;
          }
        }
        //echo 'location ID: '.$locationId;
      }
      $result = file_flat_view($locationId);
      $breadcrumbs = file_get_breadcrumbs($locationId);
      $bstring = "<a href='/?path=home'>Home</a>";
      if ($breadcrumbs != null)
      {
        $bid = explode(",", $breadcrumbs[0][0]);
        $bname = explode("/", $breadcrumbs[0][1]);
        $path = "home";
        for ($i = 0; $i < count($bid); $i++) {
          $path = $path."/".$bid[$i];
          $bstring = $bstring." > "."<a href='/?path=".$path."'>".$bname[$i]."</a>";
        } 
      }
      ?>
<?php
if (isset($_FILES["userfile"]))
{
  $errormsg = Null;
  if ($_FILES["userfile"]["error"] == 0)
  {
      $uploaddir = 'C:\apache\htdocs\ecoportret\upload\\';
      $tmp_name = $_FILES["userfile"]["tmp_name"];
      if (!empty($tmp_name)){
        $parentid = $locationId;
        $filename = basename($_FILES['userfile']['name']);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $typeid = filetype_getid_by_extname($ext);
        if (($typeid != null) && (($typeid[0][0] != 0)))
        {
          $isfolder = 0;
          $isprotected = 0;
          $comment = null;
          $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
          $fileId = file_insert($parentid, $filename, $typeid[0][0], $isfolder, $isprotected, $comment, $host);
          if ($fileId != 0)
          {
            $uploadfile = $uploaddir . $fileId.".".$ext;
            if (!move_uploaded_file($tmp_name, $uploadfile))
            {
              $errormsg .= "Could not move uploaded file '".$tmp_name."' to '".$uploadfile."'<br/>\n";
            }
          }
          else
          {
              $errormsg .= "Could not save uploaded file '".$tmp_name."' to DB<br/>\n";
          }
        }
        else
        {
          $errormsg .= "Incorrect File Extension!";
        }
      }
  }
  else {
    $errormsg .= "Upload error. [".$_FILES["userfile"]["error"]."] on file '".$_FILES["userfile"]["name"]."'<br/>\n";
  }
  header("Location: ". $_SERVER['REQUEST_URI']);
  exit;
  //echo $errormsg;
}
?>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
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
  	
      <p>
      <input type="button" id="copybtn" value="Copy"/>
      <input type="button" id="cutbtn" value="Cut"/>
      <input type="button" id="pastebtn" value="Paste"/>
      <input type="button" id="deletebtn" value="Delete"/></p>
      <p><a class="popup-link-3" id="showUploadDialog" href=""><img style="height:32px; vertical-align:middle;" src="images/icon-addfolder.png"/></a>&nbsp;&nbsp;
      <a class="popup-link-2" id="showUploadDialog" href=""><img style="height:32px; vertical-align:middle;" src="images/icon-upload.png"/></a>&nbsp;&nbsp;
      <p><a class="popup-link-4" id="showUploadDialog" href=""><img style="height:32px; vertical-align:middle;" src="images/icon-upload.png"/></a></p>
      <div class="breadcrumbs"><?php echo $bstring; ?></div>
      <div class="FileManagerTable"><table><tr><td style="width:20px;"></td><td>Name</td><td>Updated</td><td>Updated by</td><td>Comment</td></tr>
      <?php
      if ($showBackLink)
      {
        echo '<tr><td></td><td><a href="?path='.implode("/",$locationsArray).'""><- ...</a></td><td></td><td></td><td></td></tr>';
      }
      if (!empty($result))
      {
    		foreach ($result as $item) {
          $icon = "icon-folder";
    			if ($item['isfolder'] == "0")
    			{
            $icon = "icon-file";
          }
          if (($item['filetypeid'] == "1") || ($item['filetypeid'] == "5")){
            echo '<tr><td><input type="checkbox" name="files[]" value="'.$item['fileid'].'" id="'.$item['fileid'].'"></td><td><img style="height:30px; vertical-align:middle;" src="images/'.$icon.'.png"/>&nbsp;<a href="detail.php?file='.$item['fileid'].'">'.$item['filename'].'</a><img style="float: right; height:25px; vertical-align:middle; margin-left: 10px;" src="images/icon-delete.png" onclick="deleteFile(\''.$item['fileid'].'\')"/></td><td>'.$item['updated'].'</td><td>'.$item['updatedby'].'</td><td>'.$item['comment'].'</td></tr>';
          }
          else {
    			 echo '<tr><td><input type="checkbox" name="files[]" value="'.$item['fileid'].'" id="'.$item['fileid'].'"></td><td><img style="height:30px; vertical-align:middle;" src="images/'.$icon.'.png"/>&nbsp;<a href="?path='.$path.'/'.$item['fileid'].'">'.$item['filename'].'</a><img style="float: right; height:25px; vertical-align:middle; margin-left: 10px;" src="images/icon-delete.png" onclick="deleteFile(\''.$item['fileid'].'\')"/><img style="float: right; height:25px; vertical-align:middle;" src="images/icon-edit.png" class="popup-link-1" onclick="editFile(\''.$item['fileid'].'\',\''.$item['filename'].'\',\''.$item['comment'].'\')"/></td><td>'.$item['updated'].'</td><td>'.$item['updatedby'].'</td><td>'.$item['comment'].'</td></tr>';
    		  }
        }
      }
  		echo '</table></div>';
  	?>


<a class="popup-link-1" style="display: none;" id="showEditDialog" href="">Click me</a>
 
<div class="popup-box" id="popup-box-1">
    <div class="close">X</div>
    <div class="top">
        <h2>Edit</h2>
    </div>
    <div class="bottom">
      <input type="hidden" id="editfile_id"/>
      <p>Name: <input type="text" id="editfile_name"/></p>
      <p>Comment: <input type="text" id="editfile_comment"/></p>
      <p><input type="button" id="saveeditbtn" value="save"/></p>
    </div>
</div>

<div class="popup-box" id="popup-box-2">
    <div class="close">X</div>
    <div class="top">
        <h2>Upload File</h2>
    </div>
    <div class="bottom">
      <form enctype="multipart/form-data" action="" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
        <p>Choose file: <input name="userfile" type="file" /></p>
        <p><input type="submit" value="Send File" /></p>
      </form>
    </div>
</div>

<div class="popup-box" id="popup-box-3">
    <div class="close">X</div>
    <div class="top">
        <h2>Create Folder</h2>
    </div>
    <div class="bottom">
        <p>Folder name: <input id="createfolder_name" type="text" /></p>
        <p>Comment: <input id="createfolder_comment" type="text" /></p>
        <p><input type="submit" id="createfolderbtn" value="Create" /></p>
    </div>
</div>

<div class="popup-box" id="popup-box-4">
    <div class="close">X</div>
    <div class="top">
        <h2>Create Internal File</h2>
    </div>
    <div class="bottom">
        <p>File name: <input id="createfile_name" type="text" /></p>
        <p>Comment: <input id="createfile_comment" type="text" /></p>
        <p><input type="submit" id="createfilebtn" value="Create" /></p>
    </div>
</div>


</body>
</html>