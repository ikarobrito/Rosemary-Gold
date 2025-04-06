<?php
	$servidor = "localhost";
	$baseDados = "rosemary";
	$usuario = "root";
	$senha = "usbw";

	$conexao = mysqli_connect($servidor, $usuario, $senha, $baseDados);
	
	if (!$conexao):
		die ("Conexão falhou: ".mysqli_connect_error());
	endif;
