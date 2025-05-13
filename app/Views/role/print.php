<?php

require_once ROOT_PATH . 'vendor/autoload.php';

use Mpdf\Mpdf;

// $mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/../../../storage/tmp'
]);

// Data simulasi (replace dengan database fetch-mu)
$order = [
    'customer_name' => 'L CRA9',
    'production_code' => 'L CRA9 - 0101',
    'order_date' => '22-Jan-24',
    'order_number' => 'SOL/83/II/24',
    'payment_terms' => '',
    'delivery_plan' => '',
    'items' => [
        ['product_name' => 'GL VC 711 PUTIH', 'karat' => '16K', 'pcs' => 20],
        ['product_name' => 'GL VC 711 PINK', 'karat' => '16K', 'pcs' => 20],
        ['product_name' => 'GL VC 711 HITAM', 'karat' => '16K', 'pcs' => 20],
    ],
    'total_pcs' => 60,
];

$mpdf = new Mpdf();
$html = '
<style>
    body { font-family: sans-serif; font-size: 10pt; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #000; padding: 4px; text-align: center; }
    .no-border { border: none; }
    .signature { height: 50px; }
</style>

<h2 style="text-align: center;">SALES ORDER</h2>
<table>
    <tr>
        <td>Nama dan Alamat:<br><strong>' . $order['customer_name'] . '</strong></td>
        <td>Kode Produksi:<br><strong>' . $order['production_code'] . '</strong></td>
        <td>Tanggal:<br><strong>' . $order['order_date'] . '</strong></td>
    </tr>
    <tr>
        <td colspan="2">Nomor:<br><strong>' . $order['order_number'] . '</strong></td>
        <td>Syarat Pembayaran:<br>' . $order['payment_terms'] . '</td>
    </tr>
    <tr>
        <td colspan="3">Rencana Pengiriman:<br>' . $order['delivery_plan'] . '</td>
    </tr>
</table>
<br>

<table>
    <tr>
        <th>No.</th>
        <th>Uraian Barang</th>
        <th>Warna</th>
        <th>Kadar</th>
        <th>Pcs</th>
        <th>Pairs</th>
        <th>Gr</th>
        <th>Ket</th>
    </tr>';

foreach ($order['items'] as $index => $item) {
    $html .= '
    <tr>
        <td>' . ($index + 1) . '</td>
        <td>' . $item['product_name'] . '</td>
        <td></td>
        <td>' . $item['karat'] . '</td>
        <td>' . $item['pcs'] . '</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>';
}

$html .= '
    <tr>
        <td colspan="4">Total</td>
        <td>' . $order['total_pcs'] . '</td>
        <td>-</td>
        <td>-</td>
        <td></td>
    </tr>
</table>
<br><br>

<table class="no-border">
    <tr>
        <td class="signature">MANAGER PRODUKSI</td>
        <td class="signature">PPIC</td>
        <td class="signature">KABAG PENJUALAN</td>
        <td class="signature">PENERIMA ORDER</td>
    </tr>
</table>
<br>
<p><strong>INFO ORDER & PENANGGUNG JAWAB  P ENDRO</strong></p>
';



if (ob_get_contents()) ob_end_clean();

http_response_code(200); // need for chrome
$filename = substr(bin2hex(random_bytes(3)), 0, 5) . '.pdf';
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
$mpdf->WriteHTML($html);
$mpdf->Output($filename, 'I');
exit;
