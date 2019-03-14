function validate(){
	cp=document.getElementsByName("conpass")[0];
	np=document.getElementsByName("newpass")[0];
	if(np.value==cp.value)
		return true
	else
	{
		alert("New Password and Confirm Password does NOT MATCH")
		np.focus();
		np.style.border="1px red solid";
		cp.style.border="1px red solid";
		return false;
	}
}