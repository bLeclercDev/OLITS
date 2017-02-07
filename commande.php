<?php 
include ('functionBdd.php');
class Commande{
	function __construct($idDevis){
		$this->idDevis=$idDevis;
		$this->FillAttribute(ConnexionBdd2());
		
		//Requete2($idDevis, $this->$req);
	}
		//TODO
		//$nbPrint= requete(select nombreDimpression from table where idDevis=$idDevis);
		//=> faire tous les attributs
	// attributes en public pour que tpdf puisse l'utiliser
	public $idDevis;
	public $nbPrint;//int
	public $image='img\\';// chemin de l'image
	public $modele;//(int) ajouter une liste pour récupérer hauteurModele et largeurModele en fonction du modèle ? 
	public $largeurModele;//(int) largeur image en px
	public $hauteurModele;//(int) longueur image en px
	public $textContent;//(string) texte à afficher
	public $textPolice='Courier';//(string) police d'écriture utilisée
	public $textStyle;//(char) B=Bold=Gras, I=italic, U=souligné, rien = normal
	public $textColor;//? type string?
	public $textFont=8;//(int) Taille du texte
	public $textPosX;//(int) position horizontale du texte
	public $textPosY;//(int) position verticale du texte
	public $ID_Carte;


	public function FillAttribute($conn){
		//TODO : une requete => plein de propriété 
		$reqCommande='select "Nb_Papier","ID_Modele" from "Commande" where "ID_Commande"='.$this->idDevis;
		$resCommande=Requete2($conn,$reqCommande);
		$this->nbPrint=$resCommande["Nb_Papier"];
		$this->modele=$resCommande["ID_Modele"];
		$reqModele='select "Image","TPos_X","TPos_Y","ID_TPolice","Gras","Italique","Souligne", "Text", "Couleur", "ID_TCarte" from "Modele" where "ID_Modele"='.$this->modele;
		$resModele=Requete2($conn,$reqModele);
		$this->textPosX=$resModele["TPos_X"];
		$this->textPosY=$resModele["TPos_Y"];
		$this->image.=$resModele["Image"];
		$this->textContent=str_replace('<br>', '\n',$resModele["Text"]);
		$this->textColor=$resModele["Couleur"];
		if ($resModele["Gras"]=='t'){
			$this->textStyle.='B';
		}
		if ($resModele["Italique"]=='t'){
			$this->textStyle.='I';
		}
		if ($resModele["Souligne"]=='t'){
			$this->textStyle.='U';
		}
	}
}


 ?>