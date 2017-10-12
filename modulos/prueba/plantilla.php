<?php
   require_once("../../fpdf/fpdf.php");

  class PDF extends FPDF	
  {
	Function Header()
	{	
		$this->Image('../modulos/images/mask.png', 5, 5, 30);
		$this->$pdf->SetFont('Arial','B',14);
		$this->Cell(30);
		$this->$pdf->Cell(200,20,'COMPROBANTE DE INGRESO',1,0,'C');
		 
		$this->Ln(20)
	}

	Function Footer()
	{
	
		$this->SetY(-15);
		$this->Cell(200,15,'COMPROBANTE DE pie',1,0,'C');
		
	}
   }
?>