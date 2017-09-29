<?php
//require_once("../../fpdf/fpdf.php");

//include 'plantilla.php';
//require_once("../../conexion.php");

//$query="SELECT * FROM `sucursales` WHERE 1";

//	$pdf=new PDF();
//	$pdf->AddPage();
	
//	$pdf->FillColor(232,232,232);
//	$pdf->SetFont('Arial','B',12);
//	$pdf->Cell(70,10,'encabezado1',1,0,'C');
//	$pdf->Cell(70,10,'encabezado1',1,0,'C');	
//	$pdf->Cell(70,10,'encabezado1',1,0,'C');
	
require_once '../../lib/rb.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
header("Content-Type: application/json; charset=UTF-8");

    R::setup('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PASS);
    R::setAutoResolve( TRUE );        //Recommended as of version 4.2
    $post = R::dispense( 'post' );
    $post->text = 'Hello World';

    $id = R::store( $post );          //Create or Update
    $post = R::load( 'post', $id );   //Retrieve
    R::trash( $post );                //Delete
	

?>