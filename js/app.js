
function checkName(obj){
	chfl1=false;
	if(typeof obj == 'undefined') obj = document.getElementById('logname');
	var id = obj.id;
	if (!obj.value.match(/^[а-яА-Яa-zA-Z]{2,15}$/)){
		$('#'+id+'_stat').html('Имя указано не коректно').fadeIn().parent().addClass('incorrect').removeClass('correct');
	}else {
		chfl1=true;
		$('#'+id+'_stat').html('').hide().parent().removeClass('incorrect').addClass('correct');			
	}
	return chfl1;
}

function checkPass(p){
	chfl2 = false;
	passOK = false;
	if(typeof p == 'undefined') p = document.getElementById('regpass');	
	var sign='';
	if (p.value.match(/^(.)\\1*$/)){sign='Пароль должен содержать различные символы';}
	else if (p.value.length>15){sign='Максимальная длина пароля <b>15</b> символов';}
	else if (p.value.length<6){sign='Минимальная длина пароля <b>6</b> символов';}
	else if (p.value.match(/[^a-zA-Z0-9\\-_]/)){sign='В пароле присутствуют недопустимые символы';}
	else if (p.value.match(/^[0-9]+$/)){sign='Слишком простой пароль';}
	else {passOK=true;}
	var id = p.id;
	if (!passOK){
		$('#'+id+'_stat').html(sign).fadeIn().parent().addClass('incorrect').removeClass('correct');
	}else {
		chfl2 = true;
		$('#'+id+'_stat').html('').hide().parent().addClass('correct').removeClass('incorrect');
	}
	return chfl2;
}

function checkEmail(obj){
	chfl1=false;
	if(typeof obj == 'undefined') obj = document.getElementById('regemail');
	var id = obj.id;
	if (!obj.value.match(/^[a-zA-Z0-9_\.\-]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,8}$/)){
		$('#'+id+'_stat').html('E-mail указан неправильно').fadeIn().parent().addClass('incorrect').removeClass('correct');
	}else {
		chfl1=true;
		$('#'+id+'_stat').html('').hide().parent().removeClass('incorrect').addClass('correct');		
	}
	checkMail(obj.value);
	return chfl1;
}

function formRegValidate(){
	return checkEmail() && checkPass() && checkLastName() && checkName();
}

function checkMail(str) {
	/*$.ajax({
	type: "POST",
	url: "checkMail.php",
	data: "mail="+str,
	success: function(msg){
			if(!msg)
				$('#regemail_stat').html('E-mail занят другим пользователем').fadeIn().parent().addClass('incorrect').removeClass('correct');
			}
	});*/
}

function RegShow() {
	$("#login").hide();
	$("#reg").show();
	$("#wrap").show();
}

function LoginShow() {
	$("#login").show();
	$("#reg").hide();
	$("#wrap").show();
}

function AllHide() {
	$("#login").hide();
	$("#reg").hide();
	$("#wrap").hide();
}

function DivHideEsc(e) {
	if ( !e.keyCode || e.keyCode === 27 ) {
		AllHide();	
	}
}

function searchajax() {	
	var str = $("#search").val()
	if (str === "") {
		$("#maincontent").html("");
		return;
	}
	$.ajax({
	type: "POST",
	url: "search.php",
	data: "search="+str,
	success: function(msg){
				if(!msg)
					msg = "Поиск не дал результатов."
				$("#maincontent").html(msg);
			}
	});
}

function main() //главная функция
{	
	$('#search').on('input', searchajax);
	
	document.addEventListener('keydown', DivHideEsc);
	$("#wrap").click(AllHide);
	/*$("body").mousemove(function(e) {$(".product-card").css({"position": "fixed", "top": e.clientY, "left": e.clientX});});*/
	$('#search').on('input', searchajax);
	
	if(error == 1) {
		LoginShow();
		$('#logpass_stat').html("Неверный логин или пароль").fadeIn();
	}
	else if(error == 2) {
		RegShow();
		$('#regemail_stat').html('E-mail занят другим пользователем').fadeIn();
	}	
	
	$(document).ready(function(){ 
		$(window).scroll(function(){
				if ($(this).scrollTop() > 100) {
					$('.scrollLeft').fadeIn();
				} else {
					$('.scrollLeft').fadeOut();
				}
			});			 
			$('.scrollLeft').click(function(){
			$("html, body").animate({ scrollTop: 0 }, 600);
			return false;
		});
	});
}

window.addEventListener("load", main);

