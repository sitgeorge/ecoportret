$(function(){
    var currentSelectedId = null;
    $('.tree').treegrid({
          'initialState': 'collapsed',
          'saveState': true,
        });

    $("#detailtable tbody").on("mousedown", "tr", function() {
        $(".selected").not(this).removeClass("selected");
        $(this).toggleClass("selected");
        currentSelectedId = $(this).attr("id");
    });
    /*$('.tree').treegrid({
            onChange: function() {
                //alert("Changed: "+$(this).attr("id"));
            }, 
            onCollapse: function() {
                //alert("Collapsed: "+$(this).attr("id"));
            }, 
            onExpand: function() {
                //alert("Expanded "+$(this).attr("id"));
            }});*/
    /*$("#example-basic-expandable").treetable({ expandable: true });

    $("#example-basic-expandable tbody").on("mousedown", "tr", function() {
        $(".selected").not(this).removeClass("selected");
        $(this).toggleClass("selected");
        currentSelectedId = $(this).attr("id");
    });*/
	/*$("#testbtn").click(getFolderContent);
	if(typeof(Storage) !== "undefined") {
        if (sessionStorage.cutcopyfile) {
            $("#pastebtn").removeAttr('disabled','disabled')
        } else {
            $("#pastebtn").attr('disabled','disabled')
        }
    } else {
        alert("Sorry, your browser does not support web storage...");
    }*/

    $("#copybtn").click(function(){
    	sessionStorage.cutcopydetail = currentSelectedId;
    	sessionStorage.cutcopyOperation = "copy";
    	$("#pastebtn").removeAttr('disabled','disabled')
    });

    $("#cutbtn").click(function(){
    	sessionStorage.cutcopydetail = currentSelectedId;
    	sessionStorage.cutcopyOperation = "cut";
    	$("#pastebtn").removeAttr('disabled','disabled')
    });

    $("#pastebtn").click(function(){
    	pasteDetail(currentSelectedId, sessionStorage.cutcopydetail);
    });

    $("#deletebtn").click(function(){
    	deleteDetail(currentSelectedId);
    });

    /*$("#saveeditbtn").click(function(){
        saveFile($("#editfile_id").val(), $("#editfile_name").val(), $("#editfile_comment").val());
    });
    $("#createfolderbtn").click(function(){
        var locationId = getCurrentLocationId();
        createFolder(locationId, $("#createfolder_name").val(), $("#createfolder_comment").val(), 1);
    });
    $("#createfilebtn").click(function(){
        var locationId = getCurrentLocationId();
        createFolder(locationId, $("#createfile_name").val(), $("#createfile_comment").val(), 0);
    });*/
});

function pasteDetail(locationId, id)
{
    var actionValue = (sessionStorage.cutcopyOperation == "cut") ? "detailMove" : "detailCopy";
    $.ajax({ 
        url: 'scripts/provider.php',
        data: { action: actionValue, detailid: id, destination: locationId, host: window.location.hostname},
        type: 'POST',
        success: function(output) {
                    alert(output);
                     location.reload();
                }
    });
}

function deleteDetail(id)
{
    $.ajax({ 
        url: 'scripts/provider.php',
        data: { action: "detailDelete", detailid: id },
        type: 'POST',
        success: function(output) {
                     location.reload();
                }
    });
}

function editDetail(id, name, description, gost, amount, muid, amountmaterial, comment)
{
    $.ajax({ 
        url: 'scripts/provider.php',
        data: { action: "detailEdit", 
                detailid: id, 
                detailname: name, 
                description: description,
                gost: gost,
                amount: amount,
                muid: muid,
                amountmaterial: amountmaterial,
                comment: comment, 
                host: window.location.hostname },
        type: 'POST',
        success: function(output) {
                     location.reload();
                }
    });
}

/*function createFolder(locationId, name, comment, isFolder)
{
    if (isFolder == 1) {
        $.ajax({ 
            url: 'scripts/provider.php',
            data: { action: 'folderCreate', location: locationId, filename: name, comment: comment, host: window.location.hostname},
            type: 'POST',
            success: function(output) {
                         location.reload();
                    }
        });
    }
    else {
        $.ajax({ 
            url: 'scripts/provider.php',
            data: { action: 'fileCreate', location: locationId, filename: name, comment: comment, host: window.location.hostname},
            type: 'POST',
            success: function(output) {
                         location.reload();
                    }
        });
    }
}

function getFolderContent(id)
{
	$.ajax({ 
		url: 'scripts/provider.php',
     	data: { action: 'getFolderContent'},
        type: 'POST',
        success: function(output) {
                     alert(output);
            	}
	});
}

function pasteFile(locationId)
{
	var actionValue = (sessionStorage.cutcopyOperation == "cut") ? "fileMove" : "fileCopy";
	$.ajax({ 
		url: 'scripts/provider.php',
     	data: { action: actionValue, fileIds: sessionStorage.cutcopyfile, destination: locationId, host: window.location.hostname},
        type: 'POST',
        success: function(output) {
                     location.reload();
            	}
	});
}

function deleteFiles(files)
{
	$.ajax({ 
		url: 'scripts/provider.php',
     	data: { action: "fileDelete", fileIds: files },
        type: 'POST',
        success: function(output) {
                     location.reload();
            	}
	});
}

function saveFile(id, name, comment)
{
    $.ajax({ 
        url: 'scripts/provider.php',
        data: { action: "fileEdit", fileid: id, filename: name, comment: comment, host: window.location.hostname },
        type: 'POST',
        success: function(output) {
                     location.reload();
                }
    });
}

function getSelectedFiles()
{
	var files_list = jQuery('input:checked[name="files[]"]').map(function () {
		return this.value;
	}).get();
	return files_list.join();
}

function getCurrentLocationId()
{
	var path = getURLParameter('path');
	if (path == "home" || path == null)
		return null;
	var locations = path.split("/");
	return locations[locations.length-1];
}

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
}

function editFile (id, name, comment) {
	$("#editfile_id").val(id);
	$("#editfile_name").val(name);
	$("#editfile_comment").val(comment);
	$("#showEditDialog").click();
}

function deleteFile (id) {
    deleteFiles(id);
}*/