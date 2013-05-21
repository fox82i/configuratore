<?php
	echo "	
				<div id=\"sidebar\">
                        <div class=\"box\">
							<h3>Link veloci</h3>
								<div class=\"inside\">
									<ul>
										<li><a href=\"strumenti.php\">Strumenti</a></li>
										<li><a href=\"report_vendita.php\">Report Vendita</a></li>
										<li><a href=\"report_acquisti.php\">Report Acquisti</a></li>
										
									</ul>
								</div>
                        </div>

                        <div class=\"box\">
							<h3>Cerca</h3>
							<div class=\"inside\">
								<form action=\"pannello2.php\" method=\"get\">
									Email <input type=\"text\" name=\"q\">
								<input type=\"submit\" value=\"Cerca\">
								</form>
							</div>
                        </div>
                </div>
		";
?>