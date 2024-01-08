
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
require_once dirname(__FILE__) . '/fpdf/fpdf.php';

#[\AllowDynamicProperties]
  
class Mypdf extends FPDF
{
  
    protected $DPI;
 public $MM_IN_INCH;
 public $A4_HEIGHT;
 public $A4_WIDTH;
 protected $maxwidth;
 protected $maxheight;
 
 function __construct()
 {
      $this->DPI = 96;
    $this->MM_IN_INCH = 25.4;
   $this->A4_HEIGHT = 297;
   $this->A4_WIDTH = 210;
$this->maxwidth = 1100;
    $this->maxheight = 700;
    

    $this->B = 0;
    $this->I = 0;
    $this->U = 0;
    $this->HREF = '';


 parent::__construct();
 }
 
 
 
 
    function pixelsToMM($val) {
        return $val * $this->MM_IN_INCH / $this->DPI;
    }
    function resizeToFit($imgFilename) {
        list($width, $height) = getimagesize($imgFilename);
        $widthScale = $this->pixelsToMM($width);
        $heightScale = $this->pixelsToMM($height);
        if(($heightScale > $this->A4_HEIGHT) || $widthScale > $this->A4_WIDTH){
        
        $scale= round(($width/($this->A4_WIDTH-10)),2);
        $scalehight=round(($height/$scale),0);
        
        return array(
            ($this->A4_WIDTH-10),
            $scalehight
        );
        }else{
            return array(
            round($this->pixelsToMM($width)),
            round($this->pixelsToMM($height))
        );
        }
    }
    function centreImage($img) {
        list($xwidth, $xheight) = $this->resizeToFit($img);
        // you will probably want to swap the width/height
        // around depending on the page's orientation
       
        $this->Image(
            $img,5,5,
           $xwidth ,
            $xheight
        );
    }





    function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('Arial',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}

 
 
}
  
/* End of file Pdf.php */
