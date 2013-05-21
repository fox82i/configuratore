<?php
	function return_sub_nav_home($nome_pagina){
		switch ($nome_pagina){
			case "index.php":
				echo"
					<ul id=\"sub-nav\">
						<li class=\"current\"><a href=\"index.php\">Home</a></li>
						<li><a href=\"ordini_produzione.php\">Ordini di Produzione</a></li>
						<li><a href=\"visualizza_diba_produzione.php\">Visualizza DIBA Produzione</a></li>
					</ul>
				";
				break;
				
			case "ordini_produzione.php":
				echo"
					<ul id=\"sub-nav\">
						<li><a href=\"index.php\">Home</a></li>
						<li class=\"current\"><a href=\"ordini_produzione.php\">Ordini di Produzione</a></li>
						<li><a href=\"visualizza_diba_produzione.php\">Visualizza DIBA Produzione</a></li>
					</ul>
				";
				break;
			case "visualizza_diba_produzione.php":
				echo"
					<ul id=\"sub-nav\">
						<li><a href=\"index.php\">Home</a></li>
						<li ><a href=\"ordini_produzione.php\">Ordini di Produzione</a></li>
						<li class=\"current\"><a href=\"visualizza_diba_produzione.php\">Visualizza DIBA Produzione</a></li>
					</ul>
				";
				break;
			}
	}
?>