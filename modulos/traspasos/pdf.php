<?php
	require_once("../../dompdf/dompdf_config.inc.php");
	$dompdf = new DOMPDF();
	$dompdf->set_paper("letter","portrait");
	ob_start();//: que le da comienzo al buffer
	
	//ob_flush();//: que permite limpiar el buffer imprimiendo toda la salida
	include_once("rpt_ordencompra.php");
	$html = ob_get_contents();//: que permite obtener los contenidos del buffer sin imprimir en pantalla
	
	ob_end_clean();
	//$dompdf->load_html(file_get_contents('rpt_ordencompra.php'));
	$dompdf->load_html($html);
	
	$dompdf->render();
	$dompdf->stream("Orden_de_Compra.pdf", array('Attachment' => 0));
?>