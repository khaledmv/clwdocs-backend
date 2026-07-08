<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class PdfExtractorService
{
    public function extract(string $path): string
    {
        try {
            $parser = new Parser();

            $pdf = $parser->parseFile($path);

            return trim($pdf->getText());
        } catch (\Throwable $e) {
            report($e);

            return '';
        }
    }
}