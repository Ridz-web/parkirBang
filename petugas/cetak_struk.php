<?php
include "../config/database.php";
$id = $_GET['id'];

$stmt = $db->prepare(
 "SELECT t.*, k.plat_nomor, r.harga, r.jenis_kendaraan
  FROM transaksi t
  JOIN kendaraan k ON t.kendaraan_id=k.id
  JOIN tarif r ON t.tarif_id=r.id
  WHERE t.id=?"
);
$stmt->execute([$id]);
$data = $stmt->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 300px; 
            margin: 0 auto; 
            padding: 20px; 
            text-align: left;
        }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        .line { border-bottom: 1px dashed #000; margin: 10px 0; }
        .row { display: flex; justify-content: space-between; margin-bottom: 5px; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center bold">PARKIR APP</div>
    <div class="text-center">Struk Parkir</div>
    <div class="line"></div>
    
    <div class="row">
        <span>Plat Nomor</span>
        <span><?= $data['plat_nomor'] ?></span>
    </div>
    <div class="row">
        <span>Jenis</span>
        <span><?= $data['jenis_kendaraan'] ?></span>
    </div>
    <div class="row">
        <span>Masuk</span>
        <span><?= date('d/m H:i', strtotime($data['waktu_masuk'])) ?></span>
    </div>
    
    <div class="line"></div>
    
    <div class="row bold">
        <span>TOTAL</span>
        <span>Rp <?= number_format($data['harga'], 0, ',', '.') ?></span>
    </div>
    
    <div class="line"></div>
    <div class="text-center" style="margin-top: 20px;">Terima Kasih</div>
</body>
</html>