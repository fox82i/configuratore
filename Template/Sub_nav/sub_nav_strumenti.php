<?php
		function return_sub_nav($nome_pagina){
			switch ($nome_pagina){
				case "strumenti.php":
					echo "<ul id=\"sub-nav\">
							<li><a href=\"importa_dati_massivo.php\">Importa dati massivo</a></li>
						</ul>";
					break;
				case "importa_dati_massivo.php":
					echo "<ul id=\"sub-nav\">
							<li class=\"current\"><a href=\"importa_dati_massivo.php\">Importa dati massivo</a></li>
						</ul>";
					break;
				
			}
		}
?>