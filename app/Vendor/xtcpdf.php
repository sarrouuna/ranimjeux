<?php 
App::import('Vendor','tcpdf/tcpdf'); 

class XTCPDF  extends TCPDF 
{ 

    var $xheadertext  = 'PDF created using CakePHP and TCPDF'; 
    var $xheadercolor = array(0,0,200); 
    //var $xfootertext  = 'Copyright Â© %d XXXXXXXXXXX. <b>All rights reserved.</b>'; 
    var $xfooterfont  = PDF_FONT_NAME_MAIN ; 
    var $xfooterfontsize = 8 ; 


//    /** 
//    * Overwrites the default header 
//    * set the text in the view using 
//    *    $fpdf->xheadertext = 'YOUR ORGANIZATION'; 
//    * set the fill color in the view using 
//    *    $fpdf->xheadercolor = array(0,0,100); (r, g, b) 
//    * set the font in the view using 
//    *    $fpdf->setHeaderFont(array('YourFont','',fontsize)); 
//    */ 
//    function Header() 
//    { 
//
//        list($r, $b, $g) = $this->xheadercolor; 
//        $this->setY(10); // shouldn't be needed due to page margin, but helas, otherwise it's at the page top 
//        $this->SetFillColor($r, $b, $g); 
//        $this->SetTextColor(0 , 0, 0); 
//        $this->Cell(0,20, '', 0,1,'C', 1); 
//        $this->Text(15,26,$this->xheadertext ); 
//    } 
//////
////    /** 
////    * Overwrites the default footer 
////    * set the text in the view using 
////    * $fpdf->xfootertext = 'Copyright Â© %d YOUR ORGANIZATION. All rights reserved.'; 
////    */ 
    function Footer() 
    { 
        $year = date('Y'); 
        $footertext = sprintf($this->xfootertext, $year); 
        $this->SetY(-20); 
        $this->SetTextColor(0, 0, 0); 
        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);  
//         $footertext1 = sprintf($this->xfootertext1, $year); 
        $this->SetY(-20); 
        $this->SetTextColor(0, 0, 0); 
        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize); 
//         $footertext2 = sprintf($this->xfootertext2, $year); 
        $this->SetY(-20); 
        $this->SetTextColor(0, 0, 0); 
        $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize); 
        //$this->Cell(0,8, $footertext.' '.$this->getAliasNumPage(),'T',1,'L');
        $this->Cell(0,8,$this->getAliasNumPage(),'T',1,'C'); 
//        $this->Cell(0,1, $footertext1,0,1,'L'); 
//        $this->Cell(0,3, $footertext2,0,1,'L'); 

    } 
//      public function LoadData($file) {
//        // Read file lines
//        $lines = file($file);
//        $data = array();
//        foreach($lines as $line) {
//            $data[] = explode(';', chop($line));
//        }
//        return $data;
//    }
//
//    // Colored table
//    public function ColoredTable($header,$data) {
//        // Colors, line width and bold font
//        $this->SetFillColor(255, 0, 0);
//        $this->SetTextColor(255);
//        $this->SetDrawColor(128, 0, 0);
//        $this->SetLineWidth(0.3);
//        $this->SetFont('', 'B');
//        // Header
//        $w = array(40, 35, 40, 45);
//        $num_headers = count($header);
//        for($i = 0; $i < $num_headers; ++$i) {
//            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
//        }
//        $this->Ln();
//        // Color and font restoration
//        $this->SetFillColor(224, 235, 255);
//        $this->SetTextColor(0);
//        $this->SetFont('');
//        // Data
//        $fill = 0;
//        foreach($data as $row) {
//            $this->Cell($w[0], 6, $row['Lignedevi']['designation'], 'L', 0, 'L', $fill);
//            $this->Cell($w[1], 6, $row['Lignedevi']['Qte'], 'LR', 0, 'L', $fill);
//           // $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
//           //$this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
//            $this->Ln();
//            $fill=!$fill;
//        }
//        $this->Cell(array_sum($w), 0, '', 'T');
//    }
} 
?>
