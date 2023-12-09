
$(document).ready(function () {
$("#registrationForm").submit(function(){

if($("#name").val()=="")
{
$("#err").text("Please enter  name");
$("#err").show();
$("#name").focus();
return false;       

}
});   


$("#loginForm").submit(function(){

if($("#email").val()=="")
{
$("#err").text("Please enter email");
$("#err").show();
$("#email").focus();
return false;       
}

if(!$("#email").val().match("^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$"))
{
$("#err").text("Please enter your valid email");
$("#err").show();
$("#email").focus();
return false;
}

if($("#password").val()=="")
{
$("#err").text("Please enter password");
$("#err").show();
$("#password").focus();
return false;       
}


}); 





});  
