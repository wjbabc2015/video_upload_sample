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

	if (videoSize > filemaxAdmin){
		errorTag += 2;
	}

	switch(errorTag){
		case 1: alert(errorExt);break;
		case 2: alert(errorSizeAdmin);break;
		case 3: alert(errorBothAdmin);break;
		default: break;
	}
});

$(document).ready(function(){
	$("#admin_logout").click(function(){
		if (confirm(adminLogout)){
			window.location = "session_over.php";
		}
	});

	$("#select_all").click(function(){
		checkboxChange("video_delete", this);
	});

	$("#video_delete").click(function(){
		if (confirm(videoDelete)) {
			
			var videoName = getCheckbox("video_delete");

			if (videoName.length == 0){
				alert(videoNoSelect);
			}else{
				$.ajax({
					url: 'delete_video.php',
					type: 'post',
					data: {videoName: videoName},
					success: function(response){
						$("#videos").html(response);
					}
				});
			}
		}
	});

});

function checkboxChange(id, btn){
	var checkboxes = document.getElementsByClassName(id);
	var statue = btn.checked;
	
	for (var i = 0; i < checkboxes.length; i ++){
		checkboxes[i].checked = statue;
	}
}

function getCheckbox(id){
	var name = [];
	var checkboxes = document.getElementsByClassName(id);

	var index = 0;
	for(var i = 0; i < checkboxes.length; i ++){
		if(checkboxes[i].checked){
			name[index++] = checkboxes[i].value;
		}
		//alert(name);
	}

	return name;
}

function accountSelect(){
	checkboxChange("account_delete", document.getElementById("select_all_account"));
}

function accountDelete(){
	if (confirm(accountDelete)) {

		var accountName = getCheckbox("account_delete");

		if (accountName.length == 0) {
			alert(accountNoSelect);
		}else{
			$.ajax({
				url: 'delete_account.php',
				type: 'post',
				data: {accountName: accountName},
				success: function(response){
					$("#dropdown-show").html(response);
				}
			});
		}
	}
}

function statueChange(username){
	$.ajax({
		url: 'status_change.php',
		type: 'post',
		data: {"username":username},
		success: function(response){
			$("#dropdown-show").html(response);
		}
	});
}

function accountRefresh(){
	$.ajax({
		url: 'refrest_account.php',
		type: 'post',
		success: function(response){
			$("#dropdown-show").html(response);
		}
	});
}

function accountAdd(){
	var username = $('#username_add_id').val();
	var password = $('#password_add_id').val();
	var pass = $("#pass_add_id").val();
	var adminCheck = document.getElementById("admin_check_id").checked;

	//alert(username);

	var admin = 1;

	if (adminCheck) {admin = 2};

	//alert(admin);

	if (username.length != 0 && password.length != 0) {
		if (password == pass) {
			$.ajax({
				url: 'add_account.php',
				type: 'post',
				data: {"username":username, "password":password, "admin":admin},
				success: function(response){
					$("#dropdown-add").html(response);
					accountRefresh();
				}
			});
		}else{
			alert(passMatch);
		}
	}else{
		alert(userPassEmpty);
	}
}

function accountChange(){
	var username = $('#username_change_id').val();
	var password = $('#password_change_id').val();
	var pass = $("#pass_change_id").val();

	if (username.length != 0 && password.length != 0) {
		if (password == pass) {
			$.ajax({
				url: 'change_account.php',
				type: 'post',
				data: {"username":username, "password":password},
				success: function(response){
					$("#dropdown-change").html(response);
					accountRefresh();
				}
			});
		}else{
			alert(passMatch);
		}
	}else{
		alert(userPassEmpty);
	}
}

/**

**/