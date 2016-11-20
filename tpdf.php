<?php 
require ('connecBdd.php');
require ('fpdf\fpdf.php');

class tpdf{

	function __construct(){	
	}
	
	//attributes
	private $nbPrint;//int
	private $image;//
	private $modele;//(int)
	private $longueurModele;//(int)
	private $largeurModele;//(int)
	private $textContent;//(string)
	private $textPolice;//(string)
	private $textStyle;//(char)
	private $textColor;//? type string?
	private $textFont;//(int)
	
	//setters
	public function SetnbPrint($nbPrint){$this->nbPrint=$nbPrint;}
	public function Setimage($image){$this->image=$image;}
	public function Setmodele($modele){$this->modele=$modele;}
	public function SetlongueurModele($longueurModele){$this->longueurModele=$longueurModele;}
	public function SetlargeurModele($largeurModele){$this->largeurModele=$largeurModele;}
	public function SettextContent($textContent){$this->textContent=$textContent;}
	public function SettextPolice($textPolice){$this->textPolice=$textPolice;}
	public function SettextStyle($textStyle){$this->textStyle=$textStyle;}
	public function SettextColor($textColor){$this->textColor=$textColor;}
	public function SettextFont($textFont){$this->textFont=$textFont;}
	
	//getter utilisé pour test
	public function GetlargeurModele(){return $this->largeurModele;}
	
	public function FillAttribute(){connectBddT();} //fonction qui se connectera à la Bdd et affectera les attributs nécessaire à le génération pdf
	
	public function FillAuto(){
		$this->SetnbPrint(1);
		$this->Setimage('img\logo.png');
		$this->Setmodele(1);
		$this->SetlongueurModele(200);
		$this->SetlargeurModele(60);
		$this->SettextContent('rip lui');	
		$this->SettextPolice('Helvetica');
		$this->SettextStyle('B');
		$this->SettextColor('blue');
		$this->SettextFont('18');
	}
	public function GeneratePDF(){
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->Image($this->image,0,0);// fpdf.org/en/doc/image.htm
		$pdf->SetFont($this->textPolice,$this->textStyle,$this->textFont);//fpdf.org/fr/doc/setfont.htm
		$pdf->Cell(0,0,$this->textContent,); // fpdf.org/fr/doc/cell.htm
		$pdf->Output(); // affiche le pdf
	}
}

?>