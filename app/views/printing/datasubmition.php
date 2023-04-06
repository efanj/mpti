<?php

use Dompdf\Dompdf;

$rows = $this->controller->printing->datasubmition($date);
print_r($rows);

// $html = '<!DOCTYPE html>
// <html lang="en">
// <head>
//   <meta charset="UTF-8">
//   <meta http-equiv="X-UA-Compatible" content="IE=edge">
//   <meta name="viewport" content="width=device-width, initial-scale=1.0">
//   <title>Data Serahan</title>
//   <style>
//   table{
//     border-collapse:collapse;
//     width:100%;
//     font-size: 12px;
//   }
//   td,th{
//     border: 1px solid #ddd;
//     padding: 8px;
//   }
//   </style>
// </head>

// <body>';
// $html .= '<table><thead><tr>
// <th>No. Akaun</br> No. Lot</th>
// <th>Nilai Tahunan Asal</br> Kadar Tahunan Asal</br> Cukai Taksiran Asal</th>
// <th>Nilai Tahunan Baru</br> Kadar Tahunan Baru</br> Cukai Taksiran Baru</th>
// <th>Perbezaan</th>
// <th>Sebab-Sebab / Catatan</th>
// </tr></thead><tbody>';

// foreach ($rows as $row) {
//   $html .= '<tr>
// <td>' . $row['smk_akaun'] . '</br>' . $row['smk_nolot'] . '</td>
// <td>' . $row['smk_lsbgn'] . '</br>' . $row['smk_nolot'] . '</td>
// <td>' . $row['smk_akaun'] . '</br>' . $row['smk_nolot'] . '</td>
// <td>' . $row['smk_akaun'] . '</br>' . $row['smk_nolot'] . '</td>
// <td>' . $row['smk_akaun'] . '</br>' . $row['smk_nolot'] . '</td>
// </tr>';
// }

// $html .= '</tbody></table></body>
// </html>';

// $dompdf = new Dompdf();
// $dompdf->loadHtml($html);
// $dompdf->setPaper('A4', 'landscape');
// $dompdf->render();
// $dompdf->stream('dataserahan.pdf', ['Attachment' => 0]);