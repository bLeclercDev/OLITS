<?php 
require 'tpdf.php';
if (!isset ($_POST['idDevis'])){
?>



<meta http-equiv="Content-Type" content="charset=UTF-8"> <!-- UTF8 permet l'utilisation d'accent-->
<script type="text/javascript" src="js/index.js"></script>
<form method='post' action="index.php">
	<input name='idDevis' type='number' placeholder='Identifiant du devis'/>
	<input type="submit" value="Générer le PDF" />
</form>



<?php
}
else {
	if ( !filter_var($_POST['idDevis'], FILTER_SANITIZE_NUMBER_INT)==false && is_numeric($_POST['idDevis']) && DevisExist()){
		$t1=new Tpdf(abs($_POST['idDevis']));// abs => valeur absolue, 
		$t1->GeneratePDF(); //TODO : gestion erreur objet nnon existant	
	}
	else  {
		echo ('Identifiant non conforme');
		?> </br><input type="button" onclick="location.href='index.php';" value="Retour" /> <?php
	}
}
?>