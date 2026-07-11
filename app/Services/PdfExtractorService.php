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

            $text = $pdf->getText();

            // Normalize encoding
            $text = mb_convert_encoding(
                $text,
                'UTF-8',
                mb_detect_encoding(
                    $text,
                    ['UTF-8', 'Windows-1252', 'ISO-8859-1'],
                    true
                ) ?: 'UTF-8'
            );

            // Remove invalid UTF-8 bytes
            return iconv('UTF-8', 'UTF-8//IGNORE', $text);

        } catch (\Throwable $e) {
            report($e);

            return '';
        }
    }
}