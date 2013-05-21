<?php
	# source: http://www.manuali.it/forum/informatica-ed-internet-programmazione-web/menu-multilivello-tramite-css-php-mysql-t23589.html
	
	include("../include/dbconfig.inc.php");

	
function generate_menu($parent){
    global $menu_array;

    if($parent == 0){ //titoli principali del menu
        $ul_value ='<ul id="menu">';
		$ul_value .="\n";
    } else { //titoli princiapli del sub menu
		$ul_value='<ul>';
		$ul_value .="\n";
    }
    $has_childs = false;
    foreach($menu_array as $key => $value){
        if ($value['parent'] == $parent){
			if ($has_childs == false){
                $has_childs = true;
                echo $ul_value;
            }
            $valore = check_child($key);
            if($valore >=1){
                echo '<li><a href="#">' . $value['name'].'</a>';
				echo "\n\n";
			}else{
				if($value['link']=="" or empty($value['link'])){
					echo '<li><a href="#">' . $value['name'].'</a>';
					echo "\n\n";
				}else{
					echo '<li><a href="'.$value['link'] . '">' . $value['name'].'</a>';
					echo "\n\n";
				}
			}
			#ricorsione 
            generate_menu($key);
			#call function again to generate nested list for subcategories belonging to this category
			echo '</li>';
			echo "\n";
        }
    }
	if ($has_childs == true){
		echo'</ul>';
    }
}
	
	function check_child($index){
		global $dbh;
		$query=$dbh->query("SELECT count(id) as quanti FROM menu_sito where  parent='$index'");

		$data = $query->fetchAll();
		return $data[0]['quanti'];
		#return $valore;
	}
?>