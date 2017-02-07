
<?php
require 'tpdf.php';
	if ( !filter_var($_POST['idDevis'], FILTER_SANITIZE_NUMBER_INT)==false && is_numeric($_POST['idDevis']) && DevisExist()){
		$t1=new Tpdf(abs($_POST['idDevis']));// abs => valeur absolue, 
		$t1->GeneratePDF(); //TODO : gestion erreur objet nnon existant	
	}
	else  {
		echo ('Identifiant non conforme');
		?> </br><input type="button" onclick="location.href='index.php';" value="Retour" /> <?php
	}

?>