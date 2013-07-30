<?php

include_once './Class/select.class.php';
$opt = new PrezzoProdottoConfigurabile();


#motore_led
if(isset($_POST['prodotto_lineare']))
{
	echo $opt->showMotoreLed();
	die;
}

#colore led
if(isset($_POST['motore_led']))
{
	echo $opt->showTemperaturaLuce();
	die;
}
#accessorio lampada
if(isset($_POST['accessorio']))
{
	echo $opt->showAccessorio();
	die;
}
#sistema fissaggio per le lampade che ne hanno bisogno
if(isset($_POST['fissaggio']))
{
	echo $opt->showSistemaFissaggio();
	die;
}
#schermo per prodotti lineari
if(isset($_POST['schermo']))
{
	echo $opt->showSchermo();
	die;
}

#dati per calcolo prezzo
if(isset($_POST['dato_per_prezzo']))
{
	echo $opt->showPrezzoProdotto();
	die;
}

?>