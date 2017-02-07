<?php
require ('fpdf\fpdf.php');
require ('commande.php');
define('FPDF_FONTPATH','fpdf/font');

function DevisExist(){ // TODO vérification si l'entier est un identifiant devis valide
	return true;
}

class Tpdf{

	function __construct($idDevis){
		$this->commande=new commande($idDevis);
	}
	
	//attributes
	private $commande;
	private $pdf;
	private $margeImage=10; // marge entre chaque carte
	private $margePage=10; // TODO : marge de la page
	private $ColorR=0;
	private $ColorG=0;
	private $ColorB=0;


	public function To_mm($nbPixel){ // fonction de conversion pixels vers millimètres
		return $nbPixel/3.37;
	}

	public function PrintPDF(){
		$this->SetImage();
		$x=$this->To_mm($this->commande->textPosX);// transforme la position X du text en millimètre
		$y=$this->To_mm($this->commande->textPosY);// transforme la position Y du text en millimètre
		$witdth=$this->To_mm($this->commande->largeurModele)+$this->margeImage; // conversion de la largeur de l'image en mm
		$height=$this->To_mm($this->commande->hauteurModele)+$this->margeImage; // conversion de la hauteur de l'image en mm
		$nbItemLargeur=round($this->pdf->GetPageWidth()/$witdth-0.5); // troncature du nombre possible d'image à imprimer sur une ligne
		$nbItemHauteur=round($this->pdf->GetPageHeight()/$height-0.5); // troncature du nombre possible d'image à imprimer sur une colone
		$this->pdf->SetFont($this->commande->textPolice,$this->commande->textStyle,$this->commande->textFont);//configuration de la police, du style et de la taille du texte (doc : fpdf.org/fr/doc/setfont.htm)
		$j=0; // $j représentera le numéro de la ligne à imprimer
		$this->SetColor($this->commande->textColor);
		$this->pdf->SetTextColor($this->ColorR,$this->ColorG,$this->ColorB);
		for($i=0;$i<$this->commande->nbPrint;$i++){ // algo gestion placement impression sur le PDF... spoiler : ça casse le crâne
			$this->pdf->Image($this->commande->image, $witdth*($i%$nbItemLargeur), $height*$j);//imprime l'image sur le pdf img(cheminImage, x, y) (doc : fpdf.org/en/doc/image.htm)
			$this->pdf->Cell($x,$y,'',0,0);// ajoute une cellule vide afin de placer la cellule text après
			$this->pdf->Cell($witdth-$x,$y,utf8_decode($this->commande->textContent),0,0,'C'); // cellule contenant le texte (doc : fpdf.org/fr/doc/cell.htm)
			if (($i+1)%$nbItemLargeur==0) { // arrive à la fin de la ligne
				$this->pdf->SetY($this->pdf->GetY()+$height); // saut de ligne
				$j++; // incrémentation de la ligne d'impression
				if (($j)%$nbItemHauteur==0){ // si tous les items ont été imprimés sur la page
					$this->pdf->AddPage(); // création d'une nouvelle page
					$j=0; // réinitialisation de la ligne puisque l'on crée une nouvelle page
				}
			}
		}
		
		ob_clean(); // flush permettant l'utilisation de pdf->output
		//echo($this->pdf->Output('S',$this->NamePdfDevis(),true));
		//$this->pdf->Output('F',$this->NamePdfDevis(),true); // enregistre le fichier en local
		$this->pdf->Output('I',$this->NamePdfDevis(),true); // affiche le fichier 
		//$this->pdf->Output('D',$this->NamePdfDevis(),true); // télécharge le fichier par  le navigateur
	}

	public function NamePdfIncrement(){
		$i=1;
		$filename='doc.pdf';
		while (file_exists($filename)){			
			$i++;
			$filename="pdfFilesSaves\doc".$i.".pdf";
		}
		return $filename;
	}

	public function NamePdfDevis(){
		$filename="pdfFilesSaves\\Commande_".intval($this->commande->idDevis).".pdf";		
		return $filename;
	}

	public function SetColor($color){// TODO : couleur du texte
		switch ($color){
			case 'blue':
				$this->ColorR=0;
				$this->ColorG=0;
				$this->ColorB=255;
				break;
			case 'vert':
				$this->ColorR=0;
				$this->ColorG=255;
				$this->ColorB=0;
				break;
			case 'rouge':
				$this->ColorR=255;
				$this->ColorG=0;
				$this->ColorB=0;
				break;
			case 'blanc':
				$this->ColorR=255;
				$this->ColorG=255;
				$this->ColorB=255;
				break;
		}
	}

	public function SetImage(){
		$size = getimagesize($this->commande->image);
		$this->commande->largeurModele=$size[0];
		$this->commande->hauteurModele=$size[1];
	}

	public function GeneratePDF(){ 
		$this->pdf = new FPDF('P','mm',array(320,460)); // P = portait, mm = millimètre, array(320,460) = dimension de la page (doc : http://www.fpdf.org/fr/doc/__construct.htm)
		$this->pdf->SetMargins($this->margePage,$this->margePage); // supprime les marges pour plus de rentabilité
		$this->pdf->AddPage(); // ajoute la première page du pdf
		$this->PrintPDF(); // impression PDF
	}

}
?>