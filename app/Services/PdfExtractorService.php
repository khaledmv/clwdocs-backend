<?php

namespace App\Services;

use Spatie\PdfToText\Pdf;

class PdfExtractorService
{
   public function extract(string $path): string
    {
        try {
            $text = Pdf::getText(
                $path,
                config('services.pdftotext.binary')
            );

            $text = mb_convert_encoding(
                $text,
                'UTF-8',
                mb_detect_encoding(
                    $text,
                    ['UTF-8', 'Windows-1252', 'ISO-8859-1'],
                    true
                ) ?: 'UTF-8'
            );

            $text = iconv('UTF-8', 'UTF-8//IGNORE', $text);

            return trim($text);

        } catch (\Throwable $e) {
            report($e);

            return '';
        }
    }


}