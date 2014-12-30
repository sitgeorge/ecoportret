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
        echo '<table id="detailtable" class="tree table table-bordered"><thead><tr>
          <th>Detail</th>
          <th>Action</th>
          <th>DType Id</th>
          <th>Description</th>
          <th>Gost</th>
          <th>Amount</th>
          <th>Measure Id</th>
          <th>Material am.</th>
          <th>Total</th>
          <th>Comment</th>
          </tr></thead>';

        foreach ($result as $item) {
          $parent = "";
          $parent1 = "";
          if (($item["detailid"] != $item["_parent"]) && $item["_parent"] != ''){
            $parent1 = " treegrid-parent-".$item["_parent"];
          }
          echo '<tr class="treegrid-'.$item["detailid"].$parent1.'" id="'.$item["detailid"].'">
            <td>'.$item["detailname"].'</td>
            <td style="width:100px;">';
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
                    ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>';
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
                        ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>';
          echo '</td>          
            <td>'.$item["detailtypeid"].'</td>
            <td>'.$item["detaildescription"].'</td>
            <td>'.$item["detailgost"].'</td>
            <td>'.$item["amount"].'</td>
            <td>'.$item["measurementunitid"].'</td>
            <td>'.$item["amountmaterial"].'</td>
            <td>'.$item["amountmaterialtotal"].'</td>
            <td>'.$item["comment"].'</td></tr>';
        }
        echo '</table>';
        //echo print_r($result);

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
            <div class="form-group" id="pnlWithError">
              <label for="txtDetailTotalamount" class="col-sm-3 control-label">Кол-во всего</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtDetailTotalamount">
              </div>
              <input type="hidden" class="form-control" id="txtDetailId">
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

  <script>
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
      var amounttotal= button.data('amountmaterialtotal');

      var modal = $(this);
      modal.find( '#txtDetailName' ).val( name );
      modal.find( '#txtDetailId' ).val( id );
      modal.find( '#txtDetailComment' ).val( comment );
      modal.find( '#txtDetailDescription' ).val( detaildescription );
      modal.find( '#txtDetailGost' ).val( detailgost );
      modal.find( '#txtDetailAmount' ).val( amount );
      modal.find( '#txtDetailMeasure' ).val( measurementunitid );
      modal.find( '#txtDetailAmountmaterial').val(amountmaterial);
      modal.find( '#txtDetailTotalamount' ).val( amounttotal );

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
      var amounttotal = $('#txtDetailTotalamount').val();
      if (( name == '') || (detailgost == '')|| (amount == '')|| (measurementunitid == '')|| (amountmaterial == '')|| (amounttotal == ''))
      {
        $( '#pnlWithError' ).addClass( 'has-error' );
        $( '#pnlAlert' ).removeClass( 'hidden' );
      }
      else
      {
        alert(detailgost);
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
        var amounttotal = $('#txtDetailTotalamount').val();

        editDetail(id, name, description, detailgost, amount, measurementunitid, amountmaterial, comment);
        $( '#btnCloseEditDetail' ).click();
      }
    });
  </script>

</body>
</html>