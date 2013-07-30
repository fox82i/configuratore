<!DOCTYPE html>
<?php 
	include("include/dbconfig.inc.php");
?>

<html>
<head>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="prezzo_configuratore_files/formoid1/formoid-default.css" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.10.2.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){
	
		var scegli = '<option value="0">Scegli...</option>';
		var attendere = '<option value="0">Attendere...</option>';
		var no_data='<option value="0">NO DATA</option>';
		var no_prezzo='';
		
		var prodotto='';
		
		$("select#motore_led").html(scegli);
		$("select#motore_led").attr("disabled", "disabled");
		$("select#temp_colore").html(scegli);
		$("select#temp_colore").attr("disabled", "disabled");
		$("select#accessorio").html(scegli);
		$("select#accessorio").attr("disabled", "disabled");
		$("select#schermo").html(scegli);
		$("select#schermo").attr("disabled", "disabled");
		$("select#fissaggio").html(scegli);
		$("select#fissaggio").attr("disabled", "disabled");
	
		
		$("select#nome_prodotto").change(function(){
			
			$("select#temp_colore").html(attendere);
			$("select#temp_colore").attr("disabled", "disabled");
			$("select#accessorio").html(attendere);
			$("select#accessorio").attr("disabled", "disabled");
			$("select#schermo").html(attendere);
			$("select#schermo").attr("disabled", "disabled");
			$("select#fissaggio").html(attendere);
			$("select#fissaggio").attr("disabled", "disabled");
			$("result").html(no_prezzo);
			
			prodotto = $("select#nome_prodotto option:selected").attr('value');
			$.post("select.php", {prodotto_lineare:prodotto}, function(data){
				$("select#motore_led").removeAttr("disabled"); 
				$("select#motore_led").html(data);	
				
			});
		});	
		
		$("select#motore_led").change(function(){
		
			$("select#accessorio").html(attendere);
			$("select#accessorio").attr("disabled", "disabled");
			$("select#schermo").html(attendere);
			$("select#schermo").attr("disabled", "disabled");
			$("select#fissaggio").html(attendere);
			$("select#fissaggio").attr("disabled", "disabled");
			
				var motore_led = $("select#motore_led option:selected").attr('value');
			$.post("select.php", {motore_led:motore_led}, function(data){
				$("select#temp_colore").removeAttr("disabled"); 
				$("select#temp_colore").html(data);	
				
			});
		});	
		
		$("select#temp_colore").change(function(){
					
			$("select#schermo").html(attendere);
			$("select#schermo").attr("disabled", "disabled");
			$("select#fissaggio").html(attendere);
			$("select#fissaggio").attr("disabled", "disabled");
					
			$.post("select.php", {accessorio:prodotto}, function(data){
				$("select#accessorio").removeAttr("disabled"); 
				$("select#accessorio").html(data);	
				
			});
		});	
		
		$("select#accessorio").change(function(){
						
			$("select#fissaggio").html(attendere);
			$("select#fissaggio").attr("disabled", "disabled");
			
			$.post("select.php", {schermo:prodotto}, function(data){
				$("select#schermo").removeAttr("disabled"); 
				$("select#schermo").html(data);	
				
			});
		});	
		
		$("select#schermo").change(function(){
				
			if (prodotto =='BALI'){	
					
				$.post("select.php", {fissaggio:prodotto}, function(data){
					$("select#fissaggio").removeAttr("disabled"); 
					$("select#fissaggio").html(data);	
					});
			}else{
				$("select#fissaggio").html(no_data);
				$("select#fissaggio").attr("disabled", "disabled");
			}
			
		});	
		
		$("form#select_form").submit(function(){
			if(prodotto){
				var accessorio=$("select#accessorio option:selected").attr('value');
				var lunghezza_barra=$("input:text#lunghezza").val();
				
				//concateno i valori per l'elaborazione
				var dato=prodotto+'|'+accessorio+'|'+lunghezza_barra;
				
				$.post("select.php", {dato_per_prezzo:dato}, function(data){
			
					$("#result").html(data);	
					});
			}
			else
			{
				$("#result").html("Devi segliere un prodotto per avere un prezzo!");
			}
			return false;
		});

	});	
	
	</script>
	
	<title>Calcolo prezzo prodotto configurato</title>
</head>
<?php
	include_once 'Class/select.class.php';
	$opt = new PrezzoProdottoConfigurabile();
?>
<body style="background-color:#EBEBEB" >



<!-- Start Formoid form-->


<form class="formoid-default" id="select_form" style="background-color:#FFFFFF;font-size:14px;font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;color:#666666;width:480px" title="parametri per calcolo costi" >
	<div class="element-text" >
		<h2 class="title" style="color:black"><strong>Calcolo prezzo prodotto configurato</strong></h2>
	</div>
	<div class="element-select"  title="prodotti lineari led attualmente disponibili">
		<label class="title">Prodotto Lineare<span class="required">*</span></label>
			<select name="nome_prodotto" required="required" id="nome_prodotto">
				<?php echo $opt->ShowProdotti(); ?>
			</select>
	</div>
	<div class="element-select"  title="Motori led attualmente disponibili">
		<label class="title">Motore Led<span class="required">*</span></label>
			<select name="motore_led" required="required" id="motore_led">
				<option>Scegli:</option>
			</select>
	</div>
	<div class="element-select"  title="gradazione in gradi K">
		<label class="title">Temperatura luce<span class="required">*</span></label>
			<select name="temp_colore" required="required" id="temp_colore">
				<option >Scegli:</option>
			</select>
	</div>
	<div class="element-select"  title="Lampada con o senza touch">
		<label class="title">Accessorio</label>
			<select name="accessorio" id="accessorio">
				<option >Scegli:</option>
			</select>
	</div>
	<div class="element-select"  title="Tipo di schermo">
		<label class="title">Tipo schermo</label>
			<select name="schermo" id="schermo" >
				<option >Scegli:</option>
			</select>
	</div>
	<div class="element-select"  title="solo per i prodotti Bali">
		<label class="title">Sistema fissaggio</label>
			<select name="fissaggio" id="fissaggio" >
				<option >Scegli:</option>
			</select>
	</div>
	<div class="element-input" title="lunghezza prodotto" >
		<label class="title">Lunghezza (mm)<span class="required">*</span></label>
		<input type="text" id="lunghezza" name="input" required="required" maxlenght='5'/>
	</div>
	<div class="element-submit" title="Invia i dati" >
		<input type="submit" value="Conferma"/>
		<input type="reset" value="Reset"/>
		
		<br/><br/>
		<div id="loading"></div>
	</div>

</form><br/>
<div class="formoid-default" id="result" style="background-color:#FFFFFF;font-size:14px;font-family:'Open Sans','Helvetica Neue','Helvetica',Arial,Verdana,sans-serif;color:#666666;width:480px; align:center;">
</div>
</body>
</html>
