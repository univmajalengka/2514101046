<?php
function hitungDiskon($totalBelanja) {
    if ($totalBelanja >= 100000) {
        return $totalBelanja * 0.10;
    } elseif ($totalBelanja >= 50000) {
        return $totalBelanja * 0.05;
    } else {
        return 0;
    }
}

$totalBelanja = 0;
$diskon = 0;
$totalBayar = 0;
$persenDiskon = "0%";
$hasil = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rawBelanja = str_replace('.', '', $_POST["totalBelanja"] ?? '0');
    $totalBelanja = (int) $rawBelanja;
    
    if ($totalBelanja >= 0) {
        $diskon = hitungDiskon($totalBelanja);
        $totalBayar = $totalBelanja - $diskon;
        $hasil = true;

        // Menentukan persentase untuk ditampilkan
        if ($totalBelanja >= 100000) {
            $persenDiskon = "10%";
        } elseif ($totalBelanja >= 50000) {
            $persenDiskon = "5%";
        } else {
            $persenDiskon = "0%";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Diskon</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header .icon {
            font-size: 45px;
        }

        .header h1 {
            color: #333;
            margin: 10px 0;
        }

        .header p {
            color: #888;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #444;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 2px solid #eee;
            border-radius: 10px;
            font-size: 16px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #667eea;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102,126,234,0.4);
        }

        .result {
            margin-top: 25px;
            padding: 20px;
            background: #f8f9ff;
            border-radius: 15px;
            border: 1px solid #e5e8ff;
        }

        .result h2 {
            text-align: center;
            color: #667eea;
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #555;
            font-size: 14px;
        }

        .discount {
            color: #16a34a;
            font-weight: bold;
        }

        .total {
            border-top: 1px dashed #ccc;
            padding-top: 15px;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .total span:last-child {
            color: #667eea;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div class="icon">🛍️</div>
        <h1>Kalkulator Diskon</h1>
        <p>Hitung diskon belanja dengan mudah!</p>
    </div>

    <form method="POST">
        <div class="form-group">
            <label for="totalBelanja">Total Belanja (Rp)</label>
            <input
                type="text"
                id="totalBelanja"
                name="totalBelanja"
                placeholder="Contoh: 100.000"
                autocomplete="off"
                required
                value="<?php echo isset($_POST['totalBelanja']) ? htmlspecialchars($_POST['totalBelanja']) : ''; ?>"
                oninput="formatRupiah(this)"
            >
        </div>

        <button type="submit">✨ Hitung Diskon</button>
    </form>

    <?php if ($hasil): ?>
    <div class="result">
        <h2>📊 Hasil Perhitungan</h2>

        <div class="row">
            <span>Total Belanja</span>
            <span>Rp <?php echo number_format($totalBelanja, 0, ',', '.'); ?></span>
        </div>

        <div class="row">
            <span>Diskon (<?php echo $persenDiskon; ?>)</span>
            <span class="discount">
                - Rp <?php echo number_format($diskon, 0, ',', '.'); ?>
            </span>
        </div>

        <div class="row total">
            <span>Total Bayar</span>
            <span>Rp <?php echo number_format($totalBayar, 0, ',', '.'); ?></span>
        </div>
    </div>
    <?php endif; ?>

    <div class="footer">
        Program PHP • Fungsi hitungDiskon()
    </div>

</div>

<script>
function formatRupiah(input) {
    let angka = input.value.replace(/[^,\d]/g, '').toString();
    let split = angka.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    input.value = rupiah;
}
</script>

</body>
</html>