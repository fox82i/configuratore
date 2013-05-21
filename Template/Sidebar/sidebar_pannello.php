<?php
	function return_sidebar ($nome_pagina){
		switch($nome_pagina){
			case "ins_lista.php":
				echo"
					 <div id=\"sidebar\">
                        <div class=\"box\">
                        <h3>Link veloci</h3>
                        <div class=\"inside\">
                                <ul>
                                        <li><a href=\"pannello.php\">Vedi liste</a></li>
                                        <li><a href=\"pannello4.php\">Invia email</a></li>
                                </ul>
                        </div>
                        </div>
                </div>
				
				";
				break;
			case "pannello.php":
				echo"
					<div id=\"sidebar\">
                        <div class=\"box\">
							<h3>Link veloci</h3>
							<div class=\"inside\">
                                <ul>
                                   <li><a href=\"ins_lista.php\">Nuova lista</a></li>
                                   <li><a href=\"pannello4.php\">Invia email</a></li>
                                </ul>
							</div>
                        </div>
					</div>
				";
				break;
		}
	}
?>
