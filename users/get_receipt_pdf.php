<?php
require_once '../vendor/autoload.php'; 

function generate_pdf($pdfContent) {
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($pdfContent);

    // $dompdf->setPaper('A4', 'landscape');
    $dompdf->setPaper(array(0,0,720,600));
    $dompdf->render();
    $dompdf->stream("receipt.pdf", array("attachment"=>true));
    // $dompdf->stream();

    // $dompdf->stream("receipts.pdf");
    // $output = $dompdf->output();
    // file_put_contents('Brochure.pdf', $output);
}