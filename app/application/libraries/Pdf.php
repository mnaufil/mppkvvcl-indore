<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

use Dompdf\Options;
use Dompdf\Dompdf;

class Pdf
{
    function createPDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait')
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        // $options->set('tempDir', $_SERVER['DOCUMENT_ROOT'].'/assets/ncr-pdf/tmp/');

        // $dompdf = new Dompdf\DOMPDF();
        $dompdf = new Dompdf($options);

        $dompdf->load_html($html);

        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();

        file_put_contents($filename, $dompdf->output());

        /*if($download)
            $dompdf->stream($filename.'.pdf', array('Attachment' => 1));

        else
            $dompdf->stream($filename.'.pdf', array('Attachment' => 0));*/
    }


    function createPDFVisitReport($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait')
    {
        /*$options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('tempDir', $_SERVER['DOCUMENT_ROOT'].'/assets/ncr-pdf/tmp/');*/

        $dompdf = new Dompdf();
        // $dompdf = new Dompdf\Dompdf($options);

        $dompdf->load_html($html);

        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();

        // file_put_contents($filename, $dompdf->output());

        if($download)
            $dompdf->stream($filename.'.pdf', array('Attachment' => 1));

        else
            $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
    }

    public function createPDFForNCRDownload($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait')
    {
        $dompdf = new Dompdf();

        $dompdf->load_html($html);

        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();

        if($download)
            $dompdf->stream($filename, array('Attachment' => 1));

        else
            $dompdf->stream($filename, array('Attachment' => 0));
    }

    public function createPDFReport($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait')
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('tempDir', $_SERVER['DOCUMENT_ROOT'].'/assets/ncr-pdf/tmp/');

        // $dompdf = new Dompdf\DOMPDF();
        $dompdf = new Dompdf($options);

        $dompdf->load_html($html);

        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();

        // file_put_contents($filename, $dompdf->output());

        if($download)
            $dompdf->stream($filename.'.pdf', array('Attachment' => 1));

        else
            $dompdf->stream($filename.'.pdf', array('Attachment' => 0));
    }

    public function createPDFForTKCWeeklyPlanDownload($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait')
    {
        $dompdf = new Dompdf();

        $dompdf->load_html($html);

        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();

        if($download)
            $dompdf->stream($filename, array('Attachment' => 1));

        else
            $dompdf->stream($filename, array('Attachment' => 0));
    }
}

?>