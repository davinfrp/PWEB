<?php
// memanggil library FPDF
require('./fpdf.php');

$pdf = new FPDF('l','mm','A4');
$pdf->AddPage();

$pageWidth = $pdf->GetPageWidth();

$pdf->SetFont('Arial','B',16);
$xCoordinate = ($pageWidth - 190) / 2;
$pdf->SetXY($xCoordinate, 10);
$pdf->Cell(190, 7, 'DAFTAR SISWA YANG SUDAH MENDAFTAR', 0, 1, 'C');
$pdf->Cell(10, 10, '', 0, 1);


$pdf->Cell(40, 10, 'Foto', 1, 0, 'C');
$pdf->Cell(40, 10, 'NIS', 1, 0, 'C');
$pdf->Cell(50, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(40, 10, 'Jenis Kelamin', 1, 0, 'C');
$pdf->Cell(40, 10, 'Telepon', 1, 0, 'C');
$pdf->Cell(67, 10, 'Alamat', 1, 1, 'C');

$pdf->SetFont('Arial','',10);

include 'koneksi.php';
$sql = $pdo->prepare("SELECT * FROM siswa");
$sql->execute();

$pdf->SetFont('Courier', '', 12);
while ($data = $sql->fetch()) {
    $imagePath = 'images/' . $data['foto'];
    if (file_exists($imagePath)) {
        list($width, $height) = getimagesize($imagePath);

        $aspectRatio = $width / $height;

        $maxHeight = 30;
        $maxWidth = 30 * $aspectRatio;

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $pdf->Cell(40, 40, '', 1, 0, 'C');
        $pdf->Image($imagePath, $x + 5, $y + 5, 30, 30);

        $pdf->SetXY($x + 40, $y);
    } else {
        $pdf->Cell(50, 50, 'Tidak Ada Gambar', 1, 0, 'C');
    }
    $pdf->Cell(40, 40, $data['nis'], 1, 0, 'C');
    $pdf->Cell(50, 40, $data['nama'], 1, 0, 'C');
    $pdf->Cell(40, 40, $data['jenis_kelamin'], 1, 0, 'C');
    $pdf->Cell(40, 40, $data['telp'], 1, 0, 'C');
    $pdf->Cell(67, 40, $data['alamat'], 1, 1, 'L');
}

$filename = 'Data_Siswa.pdf';
$pdf->Output($filename, 'D');
?>