<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\models\Log;
// use Dompdf\Dompdf as DomPDF;
use kartik\mpdf\Pdf;

class PDF extends Component
{
    public function pdf($viewFile = null)
    {
        $dompdf = new DomPDF();
     
        $dompdf->loadHtmlDomPdf('hello world');

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }
}