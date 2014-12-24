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

  <title>Структура данных</title>
  <meta http-equiv="Cache-Control" content="no-cache">

  <!--<link rel="stylesheet" href="css/main.css">-->

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
    
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
	<script src="js/jquery-1.11.1.min.js"></script>
  <script src="libs/bootstrap/js/bootstrap.min.js"></script>
 	<script src="js/base.js"></script>
  <script src="js/popup.js"></script>
  
  <div class="content">

    <div class="toolbar">
      <div class="btn-group" role="group" aria-label="...">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dlgEditFolder" id="btnAddFolder" data-action="new">Создать папку</button>
        <button type="button" class="btn btn-default" id="btnAddDetail">Создать расчет конструкции</button>
        <button type="button" class="btn btn-default" id="btnUploadFile">Закачать</button>
      </div>

      <div class="btn-group pull-right" role="group" aria-label="...">
        <button type="button" class="btn btn-default" id="copybtn">Копировать</button>
        <button type="button" class="btn btn-default" id="cutbtn">Вырезать</button>
        <button type="button" class="btn btn-default" id="pastebtn">Вставить</button>
<!--        <button type="button" class="btn btn-default" id="deletebtn">Удалить выделенное</button>-->
      </div>     
    </div>


<!--
    <a class="popup-link-3" id="showUploadDialog" href=""><img style="height:32px; vertical-align:middle;" src="images/icon-addfolder.png"/></a>&nbsp;&nbsp;
    <a class="popup-link-2" id="showUploadDialog" href=""><img style="height:32px; vertical-align:middle;" src="images/icon-upload.png"/></a>&nbsp;&nbsp;
    <p>
      <a class="popup-link-4" id="showUploadDialog" href=""><img style="height:32px; vertical-align:middle;" src="images/icon-upload.png"/></a>
    </p>
-->    
    <div class="breadcrumbs">
      <ol class="breadcrumb">
      <?php 

        $breadcrumbs = file_get_breadcrumbs( $locationId );
        $root = /*$_SERVER['SERVER_NAME'].*/$_SERVER['PHP_SELF'];
         
        echo '<li><a href="'.$root.'?path=home">Главная</a></li>';

        if ($breadcrumbs != null)
        {
          $bid = explode(",", $breadcrumbs[0][0]);
          $bname = explode("/", $breadcrumbs[0][1]);

          for ($i = 0; $i < count($bid); $i++) {
            if ( $i == count($bid) - 1 ) {
              echo '<li class="active">'.$bname[$i].'</li>';
            }
            else {
              echo '<li><a href="'.$root.'?path=home/'.$bid[$i].'">'.$bname[$i].'</a></li>';
            }
          } 
        }
      ?>
      </ol>
    </div>
    <div class="FileManagerTable">
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Updated</th>
            <th>Updated by</th>
            <th>Comment</th>
          </tr>
        </thead>
        <?php
          if ($showBackLink)
          {
            echo '<tr>
                    <td class="col-md-2">
                    </td>
                    <td class="col-md-5">
                      <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;<a href="?path='.implode("/",$locationsArray).'"">...</a>
                    </td>
                    <td class="col-md-1"></td>
                    <td class="col-md-2"></td>
                    <td class="col-md-2"></td>
                  </tr>';
          }

          if ( !empty( $result ) )
          {
        		foreach ( $result as $item ) {
              $isfolder = $item['isfolder'];

              $icon = "glyphicon-folder-close";
        			
              if ( !$isfolder ) {
                $icon = "glyphicon-file";
              }

              if ( ( $item['filetypeid'] == "1" ) || ( $item['filetypeid'] == "5" ) ) {
                echo '<tr>
                        <td class="col-md-2">
                          <input type="checkbox" name="files[]" value="'.$item['fileid'].'" id="'.$item['fileid'].'">
                        </td>
                        <td class="col-md-5">
                          <span class="glyphicon '.$icon.'" aria-hidden="true"></span>&nbsp;&nbsp;
                          <a href="detail.php?file='.$item['fileid'].'">'.$item['filename'].'
                          </a> 
                        </td>
                        <td class="col-md-1">'.$item['updated'].'</td>
                        <td class="col-md-2">'.$item['updatedby'].'</td>
                        <td class="col-md-2">'.$item['comment'].'</td>
                      </tr>';
              }
              //<span class="glyphicon '.$icon.'" aria-hidden="true"></span> <a href="detail.php?file='.$item['fileid'].'">'.$item['filename'].'</a> <img style="float: right; height:25px; vertical-align:middle; margin-left: 10px;" src="images/icon-delete.png" onclick="deleteFile(\''.$item['fileid'].'\')"/>

              else {
        			  echo '<tr>
                      <td class="col-md-2">
                        <input type="checkbox" name="files[]" value="'.$item['fileid'].'" id="'.$item['fileid'].'">
                ';
                echo '    <button type="button" 
                          class="btn btn-default pull-right btnDelete" 
                          aria-label="Delete row" 
                          data-placement="top" 
                          title="Удалить" 
                          data-action="delete"
                      >
                  ';
                echo '      <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>';
                echo '    </button>';

                if ( $isfolder ) {
                  echo '    <button type="button" 
                            class="btn btn-default pull-right" 
                            aria-label="Edit row" 
                            data-placement="top" 
                            title="Редактировать"
                            data-toggle="modal" 
                            data-target="#dlgEditFolder"
                            data-action="edit"
                            data-folderid="'.$item["fileid"].'"
                            data-foldername="'.$item["filename"].'"
                            data-comment="'.$item["comment"].'"
                        >
                    ';
                  echo '      <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
                  echo '    </button>';
                }
                echo '
                      </td>
                      <td class="col-md-5">
                        <span class="glyphicon '.$icon.'" aria-hidden="true">
                        <a href="?path='.$path.'/'.$item['fileid'].'">'.$item['filename'].'</a>

                        <div class="alert alert-danger alert-dismissible fade in hidden" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                          <p>Удалить файл/папку?</p>
                          <p>
                            <button type="button" class="btn btn-danger">Удалить</button>
                          </p>
                        </div>

                      </td>
                      <td class="col-md-1">'.$item['updated'].'</td>
                      <td class="col-md-2">'.$item['updatedby'].'</td>
                      <td class="col-md-2">'.$item['comment'].'</td>
                    </tr>';

//                        <img style="float: right; height:25px; vertical-align:middle; margin-left: 10px;" src="images/icon-delete.png" onclick="deleteFile(\''.$item['fileid'].'\')"/>
//                        <img style="float: right; height:25px; vertical-align:middle;" src="images/icon-edit.png" class="popup-link-1" onclick="editFile(\''.$item['fileid'].'\',\''.$item['filename'].'\',\''.$item['comment'].'\')"/>
        		  }
            }
          }
    	?>
      </table>
    </div>
  </div>

  <?php
    echo '<div class="modal fade" id="dlgEditFolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
    echo '<div class="modal-dialog">';
    echo '  <div class="modal-content">';
    echo '    <div class="modal-header">';
    echo '      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    echo '      <h4 class="modal-title" id="myModalLabel">Редактирование папки</h4>';
    echo '    </div>';
    echo '    <div class="modal-body">';
    echo '
        <div class="alert alert-danger col-sm-14 hidden" role="alert" id="pnlAlert">
          Поле ввода названия должно быть заполнено.
        </div>
      ';
    echo '
          <form class="form-horizontal" id="frmEditFolder">
            
            <div class="form-group" id="pnlWithError">
              <label for="txtFolderName" class="col-sm-3 control-label">Наименование</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtFolderName">
                <input type="hidden" class="form-control" id="txtFolderId">
                <input type="hidden" class="form-control" id="txtAction">
              </div>
            </div>
            <div class="form-group">
              <label for="txtFolderName" class="col-sm-3 control-label">Комментарий</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtComment">
              </div>
            </div>

          </form>
    ';
    echo '    </div>';
    echo '
        <div class="modal-footer">
            <button type="button" class="btn btn-success" autocomplete="off" id="btnSaveFolder">Сохранить</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
        </div>
      ';  
    echo '  </div>';
    echo '</div>';
    echo '</div>';
  ?>
  <script>
    $( '#dlgEditFolder' ).on( 'show.bs.modal', function ( event ) 
    {
      var button = $(event.relatedTarget);
      var name = button.data('foldername');
      var id = button.data('folderid');
      var action = button.data('action');
      var cmt = button.data('comment');
      var modal = $(this);

      modal.find( '#txtAction' ).val ( action );

      switch ( action ) {
        case 'edit':
          modal.find( '#myModalLabel' ).text( 'Редактирование папки' );
          modal.find( '#txtFolderName' ).val( name );
          modal.find( '#txtFolderId' ).val( id );
          modal.find( '#txtComment' ).val( cmt );
          break;
        case 'new':
          modal.find( '#myModalLabel' ).text( 'Создание новой папки' );
          modal.find( '#txtFolderName' ).val( '' );
          modal.find( '#txtFolderId' ).val( '' );
          modal.find( '#txtComment' ).val( '' );
          break;
        default:
          break;
      }

      $( '#pnlWithError' ).removeClass( 'has-error' );
      $( '#pnlAlert' ).addClass( 'hidden' );

      $( '#txtFolderName' ).focus( );
    })
  </script>
  <script>
    function ValidateEdit( ) {
      var res = false;
      var name = $( '#txtFolderName' ).val( );
      if ( name == '')
      {
        $( '#pnlWithError' ).addClass( 'has-error' );
        $( '#pnlAlert' ).removeClass( 'hidden' );
      }
      else
      {
        $( '#pnlWithError' ).removeClass( 'has-error' );
        $( '#pnlAlert' ).addClass( 'hidden' );
        res = true;
      }
      return res;
    };

    $( '#btnSaveFolder' ).on( 'click', function ( ) {
      $( '#frmEditFolder' ).submit( );
    });

    $( '#frmEditFolder' ).submit( function( event ) {
      if ( ValidateEdit( ) )
      {
        var id = $( '#txtFolderId' ).val( );
        var name = $( '#txtFolderName' ).val( );
        var cmt = $( '#txtComment' ).val( );
        var actionname = $( '#txtAction' ).val( );
        var ajaxactionname = '';
        var loc_id = getCurrentLocationId();

        switch ( actionname ) {
          case 'new':
            ajaxactionname = 'folderCreate';
            break;
          case 'edit':
            ajaxactionname = 'fileEdit';
            break;              
        }

            $.ajax({ 
                url: 'scripts/provider.php',
                data: { action: ajaxactionname, location: loc_id, fileid: id, filename: name, comment: cmt, host: window.location.hostname },
                type: 'POST',
                success: function( output ) {
                            //alert ( output );
                            location.reload();
                        }
            });
      }
      event.preventDefault();
    });
  </script>




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