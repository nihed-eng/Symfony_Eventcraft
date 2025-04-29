<?php

namespace App\Service;

use Knp\Snappy\Pdf;
use Twig\Environment;

class PdfGenerator
{
    private Pdf $pdf;
    private Environment $twig;

    public function __construct(Pdf $pdf, Environment $twig)
    {
        $this->pdf = $pdf;
        $this->twig = $twig;
    }

    public function generateFromTemplate(string $template, array $data, string $filename): string
    {
        $html = $this->twig->render($template, $data);
        return $this->pdf->getOutputFromHtml($html);
    }
}