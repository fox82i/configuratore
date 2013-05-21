<?php
class MysqlClass{
  // parametri per la connessione al database
	private $nomehost = "localhost";     
	private $nomeuser = "root";          
	private $password = "i19691982!D"; 
	
          
  // controllo sulle connessioni attive
	private $attiva = false;
 
  // funzione per la connessione a MySQL
	public function connetti(){
		if(!$this->attiva){
			$connessione = mysql_connect($this->nomehost,$this->nomeuser,$this->password);
		}else{
			return true;
		}
    }
	public function disconnetti(){
        if($this->attiva){
            if(mysql_close()){
				$this->attiva = false; 
				return true; 
            }else{
                return false; 
            }
        }
	}
	public function change_db($nome_db){
		 if($this->attiva){
			if(mysql_select_db($nome_db)){
				return true;
			}else{
				return false;
			}
		}
	}
} 

/* // inclusione del file contenente la classe
	include "funzioni_mysql.php"
	// istanza della classe
	$data = new MysqlClass();
	// chiamata alla funzione di connessione
	$data->connetti();
	chiamata alla funzione di disconnessione
	$data->disconnetti();      
*/
?>
