<?PHP 
require('fpdf17/fpdf.php');
class PDF extends FPDF {
	function Header(){
		$this->SetFont('Arial','B',15);
		
		//dummy cell to put logo
		//$this->Cell(12,0,'',0,0);
		//is equivalent to
		
        //put logo
        $this->Image('../Images/LogoBlack.png',20,10,20);
		$this->SetX(50);
		$this->Cell(100,10,'Labjournaal $titelLabjournaal',0,1);
		
		//dummy cell to give line spacing
		//$this->Cell(0,5,'',0,1);
		//is equivalent to:
		$this->Ln(5);
		
	}
	function Footer(){
		
		//Go to 1.5 cm from bottom
		$this->SetY(-15);
				
		$this->SetFont('Arial','',8);
		
		//width = 0 means the cell is extended up to the right margin
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
	}
}


//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new PDF('P','mm','A4'); //use new class

//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->AddPage();
$pdf->SetFont('Arial','B',13);
$pdf->Cell(100	,5,'Labjournaal:',0,1);//end of line

$pdf->SetFont('Arial','',12);


$pdf->AddPage();
$pdf->AddPage();
$pdf->AddPage();

$pdf->Output();