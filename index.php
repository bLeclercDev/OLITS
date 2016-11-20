<?php
require 'tpdf.php';
$t1=new tpdf();
$t1->FillAuto();
$t1->GeneratePDF();

?>