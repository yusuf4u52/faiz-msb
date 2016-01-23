<?php
require 'libraries/pdfcrowd.php';

try
{   
    // create an API client instance
    $client = new Pdfcrowd("taha2009", "88a7a354a546cad34ca4d74fe4f80945");

    // convert a web page and store the generated PDF into a $pdf variable
    $pdf = $client->convertURI('http://faizstudents.com/registration/info.php?its='.$_GET['its']);

    // set HTTP response headers
    header("Content-Type: application/pdf");
    header("Cache-Control: max-age=0");
    header("Accept-Ranges: none");
    header("Content-Disposition: attachment; filename=\"registration-form.pdf\"");

    // send the generated PDF 
    echo $pdf;
}
catch(PdfcrowdException $why)
{
    echo "Pdfcrowd Error: " . $why;
}
?>