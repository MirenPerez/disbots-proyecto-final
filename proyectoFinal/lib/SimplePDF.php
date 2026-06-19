<?php
// Librería sencilla para generar PDF sin depender de instalación externa.
class SimplePDF {
    private array $lines = [];
    public function addTitle(string $text): void { $this->lines[] = ['size'=>18, 'text'=>$text]; }
    public function addLine(string $text): void { $this->lines[] = ['size'=>11, 'text'=>$text]; }
    private function esc(string $s): string { return str_replace(['\\','(',')'], ['\\\\','\\(','\\)'], $s); }
    public function output(string $filename = 'listado.pdf'): void {
        $content = "BT\n/F1 18 Tf\n50 790 Td\n";
        $y = 0;
        foreach ($this->lines as $line) {
            $size = (int)$line['size'];
            $content .= "/F1 {$size} Tf\n0 -" . ($y === 0 ? 0 : 20) . " Td\n(" . $this->esc($line['text']) . ") Tj\n";
            $y++;
        }
        $content .= "ET";
        $objects = [];
        $objects[] = "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj\n";
        $objects[] = "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj\n";
        $objects[] = "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj\n";
        $objects[] = "4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj\n";
        $objects[] = "5 0 obj << /Length " . strlen($content) . " >> stream\n$content\nendstream endobj\n";
        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $obj) { $offsets[] = strlen($pdf); $pdf .= $obj; }
        $xref = strlen($pdf);
        $pdf .= "xref\n0 6\n0000000000 65535 f \n";
        for ($i=1; $i<=5; $i++) $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        $pdf .= "trailer << /Size 6 /Root 1 0 R >>\nstartxref\n$xref\n%%EOF";
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        echo $pdf;
    }
}
?>
