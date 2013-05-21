<?php

	function return_navigation($nome_pagina){//serve per cambiare la classe nella lista: effetto visivo di selezione
		switch ($nome_pagina){
			case "strumenti.php":
					echo"
						<ul id=\"navigation\">
						<li><a href=\"index.php\">Configuratore</a></li>
						<li class=\"current\"><a href=\"strumenti.php\">Strumenti</a></li>						
					</ul>
					";
				break;
			
			default:
				echo"
					<ul id=\"navigation\">
						<li class=\"current\"><a href=\"index.php\">Configuratore</a></li>
						<li><a href=\"strumenti.php\">Strumenti</a></li>
					</ul>
					";
				break;
		}
	}
?>