<?php


namespace App\Service;


use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Dompdf\Dompdf;

class PdfService
{

    /**
     * @var Pdf
     */
    private Pdf $knpSnappyPdf;
    /**
     * @var TokenGeneratorInterface
     */
    private TokenGeneratorInterface $tokenGenerator;

    public function __construct(Pdf $knpSnappyPdf, TokenGeneratorInterface $tokenGenerator)
    {
        $this->knpSnappyPdf = $knpSnappyPdf;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @param $view = renderView
     * @param $fileName = string
     * @return PdfResponse
     * Need Install https://wkhtmltopdf.org/ and set location of bin in config knpsnappy
     * @example use :  return $generatePdf->generatePdf($this->renderView('pdf/test.html.twig'), "test");
     */
    public function generateDownloadPdf($view, $fileName): PdfResponse
    {
        $token = $this->tokenGenerator->generateToken();
        /*$options = [
            'margin-top' => 2,
            'margin-bottom' => 2,
            'margin-left' => 2,
            'margin-right' => 2,
        ];
        $this->knpSnappyPdf->setOptions($options);*/

        $dompdf = new Dompdf();
        $dompdf->loadHtml('hello world');
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        //$dompdf->render();
        
        // Output the generated PDF to Browser
        //$dompdf->stream();  

        return new PdfResponse(
            //$this->knpSnappyPdf->getOutputFromHtml($view),
            $dompdf->render(),
            $fileName.'-'.$token.'.pdf'
        );
    }

    /**
     * @param $view
     * @param $filename
     * @return Response
     */
    public function generateViewPdf($view, $filename): Response
    {
        //$this->knpSnappyPdf->setOption("encoding","UTF-8");
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        //return $dompdf->stream();
        return new Response(
            $dompdf->output(),
            //$this->knpSnappyPdf->getOutputFromHtml($view),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
}