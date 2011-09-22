$(document).ready(function(){
	$("#submit").click(function(){
		$(this).log_reg("login");
	});

	$("#submit_reg").click(function(){
		$(this).register_check("register");				
	});

});

(function($){
	$.fn.log_reg = function(action){
		//alert("it worked somehow");

		if($("#name").val() == "" || $("#pass").val() == "")
		{
			alert ("Either name or password is empty!");
			//$("warning").html() = "Name or Password is empty!";
			//return;
		}
		
		else
		{	
			$(this).ajax_call(action);
			/*
			var login_string = "name="+$("#name").val()+"&"+"pass="+$("#pass").val()+"&"+"action="+action;
			$.ajax({
				url: 'login_php.php',
				data: login_string,
				async: false,
				success: function(data){$('.result').html(data)}; 				
			});*/
		}
		


	};



})(jQuery);

(function($){
	$.fn.register_check = function(action){
		//alert("it worked somehow");

		if($("#name").val() == "" || $("#pass").val() == "" || $("#pass_again").val() == "")
		{
			alert ("Either name or one of the password fields is empty!");
			return;
		}

		if($("#pass").val() == $("#pass_again").val())
		{
			$(this).ajax_call(action);
		}
		else
		{
			alert("Paswords don't match!");
		}

	};

})(jQuery);

(function($){
	$.fn.ajax_call = function(action){

		//need a hash for the password
		var login_string = "name="+$("#name").val()+"&"+"pass="+$("#pass").val()+"&"+"action="+action;

		var hash_salt = "MitchellPavel5"; //hash salt to prevent decoding of hash
		var hash = $.md5($("#pass").val()+hash_salt); //hash made of pass and hash salt
		login_string += "&hash="+hash;

		var jqxhr = $.post("login_php.php", login_string, function(data){alert(data);});

	
		//don't use get, it reveals the password in the url
		//hash password on client side and send through post, I guess unhash elsewhere.
		
		/*
		$.ajax({
			type: 'POST',
			url: 'login_php.php',
			data: login_string,
			async: false				
		});
		*/
	


	};

})(jQuery);
