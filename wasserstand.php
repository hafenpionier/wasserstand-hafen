<?php
header("Content-Type: text/html; charset=utf-8");

	echo'
		{
		';
		
		
// Include the library
include('simple_html_dom.php');//Daran Denken die Datei im Server bereit zu stellen!
 
// Retrieve the DOM from a given URL
$html = file_get_html('http://hafenkante.info/pegel.php');
//Zufällige Seite uf der der Wasserstand angeben wurde. Wert durch simple_html_dom ausgelesen.
 foreach($html->find('div.vollblock') as $e)
     $ee = $e->children(1)->children(0);
     $korrigierterstand = floatval(str_replace(",",".",strval($ee->innertext)))-5;
     echo '"wasserstand":"'.$korrigierterstand.'"';
     
     
    $host_name  = "";
    $database   = "";
    $user_name  = "";
    $password   = "";

    $mysqli = mysqli_connect($host_name, $user_name, $password, $database);
    
    if(mysqli_connect_errno())
    {
   // echo '<p>Verbindung zum MySQL Server fehlgeschlagen: '.mysqli_connect_error().'</p>';
	}
    else
    {
    /*---------------------------------------------------
    Verbindung zum MySQL Server erfolgreich aufgebaut.
    ---------------------------------------------------*/
    $mysqli->query("SET NAMES 'utf8'");
    $mysqli->query("SET CHARACTER SET 'utf8'");
    $sql = 'SELECT * FROM data';
	$result = $mysqli->query($sql);
	
    // output data of each row
    while($row = $result->fetch_assoc()) {
    echo ',"zeigerstand":"'.$row["zeigerstand"].'"';
  	};
echo'}';


 if ($_GET["zeigerstand"] != "") {
    $sql = "UPDATE `db722464503`.`data` SET `zeigerstand` = '".$_GET["zeigerstand"]."' WHERE `data`.`id` = 1;";
    $result = $mysqli->query($sql);
    }
    
if ($_GET["istfertig"] != "") {
    $sql = "UPDATE `db722464503`.`data` SET `zeigerstand` = '".round(($korrigierterstand+3)*(38.4))."' WHERE `data`.`id` = 1;";
    $result = $mysqli->query($sql);
    }



}



	
?>
