<?php session_start();
if (isset($_SESSION['Sess_nom']))
{ 
	if ($_SESSION['Sess_nom'] <> 'Upload')
		header("Location: login_upload.php");
	else
		header("Location: upload_menu.php")
}
else
{
	header("Location: login_upload.php");
}?>