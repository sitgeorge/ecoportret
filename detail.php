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
      margin: 10px 135px;
      width: 1400px;
    }
    .toolbar {
      display: block;
      margin: 20px 0;
    }
    #detailtable {
      width: 1400px;
    }
    .detailActionButtons {
      width: 150px;
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
      <div class="navigation">
      <ul class="nav nav-tabs">
        <li class="col-sm-3"><a href="#">На главную</a></li>
      </ul>
      </div> 
    <div class="toolbar">
       <div class="btn-group" role="group" aria-label="...">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dlgAddDetail" id="btnAddGroup" data-action="new" data-detailid="">Добавить корневой элемент</button>
      </div>
      <div class="btn-group pull-right" role="group" aria-label="...">
        <button type="button" class="btn btn-default" id="copybtn">Копировать</button>
        <button type="button" class="btn btn-default" id="cutbtn">Вырезать</button>
        <button type="button" class="btn btn-default" id="pastebtn" disabled="disabled">Вставить</button>
      </div>
    </div>
  	<?php 
      if (isset($_GET["file"]))
      {
        $result = detail_view($_GET["file"], Null);

        /* T A B S */
        echo '
          <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="tabNav">
              <li role="presentation" class="active"><a href="#hierarchy" aria-controls="hierarchy" role="tab" data-toggle="tab">Комплект(иерарх.)</a></li>
              <li role="presentation"><a href="#flatsort" aria-controls="flatsort" role="tab" data-toggle="tab">Комплект(сорт.)</a></li>
              <!--
                <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
              -->
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="hierarchy">
        ';

        echo '<table id="detailtable" class="tree table table-bordered"><thead><tr>
          <th>Наименование</th>
          <th>Тип</th>
          <th>Маркировка</th>
          <th>ГОСТ</th>
          <th>Цена/ед.</th>
          <th>Расх.норма</th>
          <th>Расх.кол-во</th>
          <th>Расх.всего</th>
          <th>Счит.?</th>
          <th>Комментарий</th>
          <th></th>
          </tr></thead>';

        foreach ($result as $item) {
          $parent = "";
          $parent1 = "";
          if (($item["detailid"] != $item["_parent"]) && $item["_parent"] != ''){
            $parent1 = " treegrid-parent-".$item["_parent"];
          }
          echo '<tr class="treegrid-'.$item["detailid"].$parent1.'" id="'.$item["detailid"].'">
            <td>'.$item["detailname"].'</td>         
            <td>'.$item["costtypeshortname"].'</td>
            <td>'.$item["detaildescription"].'</td>
            <td>'.$item["detailgost"].'</td>
            <td>'.$item["pricevalue"].'</td>
            <td>'.$item["amount"].'</td>
            <td>'.$item["amountmaterial"].'</td>
            <td>'.$item["amountmaterialtotal"].'</td>
            <td>'.$item["docalc"].'</td>
            <td>'.$item["comment"].'</td>
            <td class="col-md-2 detailActionButtons">';

          /* Action button */
          echo '<div class="btn-group pull-left">
                  <button type="button" 
                          class="btn btn-default"
                          data-action="new" 
                          title="Добавить подэлемент"
                          data-toggle="modal" 
                          data-target="#dlgAddDetail"
                          data-placement="top" 
                          aria-expanded="false"
                          data-detailid="'.$item["detailid"].'">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                  </button>
                 <!--  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Создать подэлемент</a></li>
                                   
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                -->
                  </ul>
                </div>
          ';
          /* Delete button */
          echo '    <button type="button" 
                          class="btn btn-default pull-right btnDelete" 
                          aria-label="Delete row" 
                          data-placement="top" 
                          title="Удалить" 
                          data-action="delete"
                          data-toggle="modal" 
                          data-target="#dlgDeleteDetail"
                          data-detailid="'.$item["detailid"].'"
                          data-detailname="'.$item["detailname"].'"
                    >
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>';
          /* Edit Button */
          echo '    <button type="button" 
                            class="btn btn-default pull-right" 
                            aria-label="Edit row" 
                            data-placement="top" 
                            title="Редактировать"
                            data-toggle="modal" 
                            data-target="#dlgEditDetail"
                            data-action="edit"
                            data-detailid="'.$item["detailid"].'"
                            data-detailname="'.$item["detailname"].'"
                            data-comment="'.$item["comment"].'"
                            data-detaildescription="'.$item["detaildescription"].'"
                            data-detailgost="'.$item["detailgost"].'"
                            data-amount="'.$item["amount"].'"
                            data-measurementunitid="'.$item["measurementunitid"].'"
                            data-amountmaterial="'.$item["amountmaterial"].'"
                            data-amountmaterial="'.$item["amountmaterialtotal"].'"
                        >
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </button>';

          echo '  </td>
                </tr>';
        }
        echo '</table>';
        //echo print_r($result);

        echo '
              </div>

              <div role="tabpanel" class="tab-pane" id="flatsort">
              TEST

              </div>
              <!--
                <div role="tabpanel" class="tab-pane" id="messages">...</div>
                <div role="tabpanel" class="tab-pane" id="settings">...</div>
              -->
            </div>

          </div>
        ';
      } 
    ?>
  </div>

  <div class="modal fade" id="dlgDeleteDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">  
      <div class="modal-content">    
        <div class="modal-header" style="background-color:#f2dede;" >     
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>      
         <h4 class="modal-title" id="myModalLabel">Подтвердите, что хотите удалить следующий элемент:</h4>    
       </div>    
       <div class="modal-body">
          <form class="form-horizontal" id="frmDeleteDetail">
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailName" class="col-sm-3 control-label">Наименование</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" disabled="disabled" id="txtDeleteDetailName">
                <input type="hidden" class="form-control" id="txtDeleteDetailId">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" autocomplete="off" id="btnDeleteDetail">Удалить</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseDeleteDetail">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="dlgEditDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">  
      <div class="modal-content">    
        <div class="modal-header">     
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>      
         <h4 class="modal-title" id="myModalLabel">Редактирование элемента:</h4>    
       </div>    
       <div class="modal-body">
          <div class="alert alert-danger col-sm-14 hidden" role="alert" id="pnlAlert">
            Заполните все обязательные поля!
          </div>
          <form class="form-horizontal" id="frmEditDetail">
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailName" class="col-sm-3 control-label">Наименование</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailName">
              </div>
            </div>
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailComment" class="col-sm-3 control-label">Комментарий</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailComment">
              </div>
            </div>
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailDescription" class="col-sm-3 control-label">Описание</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailDescription">
              </div>
            </div>
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailGost" class="col-sm-3 control-label">ГОСТ</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailGost">
              </div>
            </div>
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailAmount" class="col-sm-3 control-label">Количество</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailAmount">
              </div>
            </div>
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailMeasure" class="col-sm-3 control-label">Ед. измерения</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailMeasure">
              </div>
            </div>
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailAmountmaterial" class="col-sm-3 control-label">Кол-во</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailAmountmaterial">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" autocomplete="off" id="btnEditDetail">Сохранить</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseEditDetail">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="dlgAddDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">  
      <div class="modal-content">    
        <div class="modal-header">     
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>      
         <h4 class="modal-title" id="myModalLabel">Добавление элемента:</h4>    
       </div>    
       <div class="modal-body">
          <div class="alert alert-danger col-sm-14 hidden" role="alert" id="pnlAlert">
            Заполните все обязательные поля!
          </div>
          <form class="form-horizontal" id="frmEditDetail">
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailAddName" class="col-sm-3 control-label">Наименование</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailAddName">
              </div>
            </div>
            <div class="form-group" id="pnlWithError">
              <div class="dialog-checkbox-div">
                <input type="checkbox" id="chkEnableCalculate">
              </div>
              <label for="chkEnableCalculate" class="dialog-checkbox-lbl">Учитывать при расчете</label>
            </div>
            <div class="form-group" id="pnlWithError">
              <div class="dialog-checkbox-div">
                <input type="checkbox" id="chkSaveRecord">
              </div>
              <label for="chkSaveRecord" class="dialog-checkbox-lbl">Сохранить при расчете</label>
            </div>
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailAddComment" class="col-sm-3 control-label">Комментарий</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailAddComment">
              </div>
            </div>
            <div id="containerDetailAdd">
              <div class="form-group" id="pnlWithError">
                <label for="txtDetailAddMeasure" class="col-sm-3 control-label">Ед. измерения</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="txtDetailAddMeasure">
                </div>
              </div>
              <div class="form-group" id="pnlWithError">
                <label for="txtDetailAddType" class="col-sm-3 control-label">Тип</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="txtDetailAddType">
                </div>
              </div>
              <div class="form-group" id="pnlWithError">
                <label for="txtDetailAddPrice" class="col-sm-3 control-label">Цена</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="txtDetailAddPrice">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" autocomplete="off" id="btnAddDetail">Сохранить</button>
            <button type="button" class="btn btn-default" data-dismiss="modal" id="btnCloseAddDetail">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    $( '#dlgAddDetail' ).on( 'show.bs.modal', function ( event ) 
    {
      var button = $(event.relatedTarget);
      var parentId = button.data('detailid');
      $('#containerDetailAdd').hide();
    })

    $('#chkSaveRecord').change(function(){
      $( "#containerDetailAdd" ).toggle( "fast", function() {
        // Animation complete.
      });
    })

    $( '#dlgDeleteDetail' ).on( 'show.bs.modal', function ( event ) 
    {
      var button = $(event.relatedTarget);
      var name = button.data('detailname');
      var id = button.data('detailid');
      var modal = $(this);
      modal.find( '#txtDeleteDetailName' ).val( name );
      modal.find( '#txtDeleteDetailId' ).val( id );
      $( '#pnlWithError' ).removeClass( 'has-error' );
      $( '#pnlAlert' ).addClass( 'hidden' );
      $( '#txtFolderName' ).focus( );
    })

    $( '#btnDeleteDetail' ).on( 'click', function ( ) {
        var id = $( '#txtDeleteDetailId' ).val( );
        deleteDetail(id);
        $( '#btnCloseDeleteDetail' ).click();
    });

    $( '#dlgEditDetail' ).on( 'show.bs.modal', function ( event ) 
    {
      var button = $(event.relatedTarget);
      var name = button.data('detailname');
      var id = button.data('detailid');
      var comment= button.data('comment');
      var detaildescription= button.data('detaildescription');
      var detailgost= button.data('detailgost');
      var amount= button.data('amount');
      var measurementunitid= button.data('measurementunitid');
      var amountmaterial= button.data('amountmaterial');

      var modal = $(this);
      modal.find( '#txtDetailName' ).val( name );
      modal.find( '#txtDetailId' ).val( id );
      modal.find( '#txtDetailComment' ).val( comment );
      modal.find( '#txtDetailDescription' ).val( detaildescription );
      modal.find( '#txtDetailGost' ).val( detailgost );
      modal.find( '#txtDetailAmount' ).val( amount );
      modal.find( '#txtDetailMeasure' ).val( measurementunitid );
      modal.find( '#txtDetailAmountmaterial').val(amountmaterial);

      $( '#pnlWithError' ).removeClass( 'has-error' );
      $( '#pnlAlert' ).addClass( 'hidden' );
      $( '#txtFolderName' ).focus( );
    })

    /*$( '#btnDeleteDetail' ).on( 'click', function ( ) {
        var id = $( '#txtDeleteDetailId' ).val( );
        deleteDetail(id);
        $( '#btnCloseDeleteDetail' ).click();
    });*/
    function ValidateEdit( ) {
      var res = false;
      var name = $('#txtDetailName').val();
      var detailgost = $('#txtDetailGost').val();
      var amount = $('#txtDetailAmount').val();
      var measurementunitid = $('#txtDetailMeasure').val();
      var amountmaterial = $('#txtDetailAmountmaterial').val();
      if (( name == '') || (detailgost == '')|| (amount == '')|| (measurementunitid == '')|| (amountmaterial == ''))
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

    $( '#btnEditDetail' ).on( 'click', function ( ) {
      if ( ValidateEdit() )
      {
        var id = $('#txtDetailId').val();
        var name = $('#txtDetailName').val();
        var comment = $('#txtDetailComment').val();
        var description = $('#txtDetailDescription').val();
        var detailgost = $('#txtDetailGost').val();
        var amount = $('#txtDetailAmount').val();
        var measurementunitid = $('#txtDetailMeasure').val();
        var amountmaterial = $('#txtDetailAmountmaterial').val();

        editDetail(id, name, description, detailgost, amount, measurementunitid, amountmaterial, comment);
        $( '#btnCloseEditDetail' ).click();
      }
    });

    /* T A B S Activation */

    $('#tabNav a[href="#hierarchy"]').click(function (e) {
      e.preventDefault()
      $(this).tab('hierarchy')
    });
    $('#tabNav a[href="#flatsort"]').click(function (e) {
      e.preventDefault()
      $(this).tab('flatsort')
    })
  </script>

</body>
</html>