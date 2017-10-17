$(document).on('change', 'input:file', function(){
	var filename = $(this).val();
	var videoSize = $(this)[0].files[0].size;

	var fileExtention = filename.split(".");
	//alert(fileExtention[1]);

	var errorTag = 0;

	//alert(fileExtArray.indexOf(fileExtention[1]));
	if (fileExtArray.indexOf(fileExtention[1]) == -1){
		errorTag += 1;
	}

	if (videoSize > filemax){
		errorTag += 2;
	}

	switch(errorTag){
		case 1: alert(errorExt);break;
		case 2: alert(errorSize);break;
		case 3: alert(errorBoth);break;
		default: break;
	}
});

$(document).ready(function(){
	$("#adminportal").click(function(){
		$("#admin_portal").fadeIn();
		$("#admin_portal").css({"visibility":"visible","display":"block"});
		$("#upload_video").fadeOut();
		$("#upload_video").css({"visibility":"hidden","display":"none"});
	});

	$("#generalportal").click(function(){
		$("#upload_video").fadeIn();
		$("#upload_video").css({"visibility":"visible","display":"block"});
		$("#admin_portal").fadeOut();
		$("#admin_portal").css({"visibility":"hidden","display":"none"});
	});
});
