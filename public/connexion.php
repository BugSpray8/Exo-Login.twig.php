<?php
session_start();
include_once('includes.php');

if(isset($_SESSION['pseudo'])){
	header('Location: accueil.php');
	exit;
}

if(!empty($_POST)){
	extract($_POST);
	$valid = true;
	
	$Mail = htmlspecialchars(trim($Mail));
	$Password = trim($Password);
		
	if(empty($Mail)){
		$valid = false;
		$_SESSION['flash']['warning'] = "Veuillez renseigner votre mail !";
	}
	
	if(empty($Password)){
		$valid = false;
		$error_password = "Veuillez renseigner un mot de passe !";
	}
	
	
	$req = $DB->query('Select * from user where mail = :mail and password = :password', array('mail' => $Mail, 'password' => crypt($Password, '$2a$10$1qAz2wSx3eDc4rFv5tGb5t')));
	$req = $req->fetch();
		
	if(!$req['mail']){
		$valid = false;
		$_SESSION['flash']['danger'] = "Votre mail ou mot de passe ne correspondent pas";
	}
	
	
	if($valid){
		
		//$_SESSION['id'] = $req['id'];
		$_SESSION['id'] = $req['idpublic'];
		$_SESSION['pseudo'] = $req['pseudo'];
		$_SESSION['mail'] = $req['mail'];
		$_SESSION['password'] = $req['password'];
		
		$_SESSION['flash']['info'] = "Bonjour " . $_SESSION['pseudo'];
		header('Location: accueil.php');
		exit;
			
	}
	
}	
?>

