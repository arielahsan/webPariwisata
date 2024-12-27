<?php
session_start();
require "../config.php"; // Pastikan Anda menghubungkan ke database
if (isset($_SESSION)){
    if ($_SESSION['level']!='admin'){
        header('Location: ../index.php');
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_wisata = $_POST['nama_wisata'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $fasilitas = $_POST['fasilitas'];
    $biaya = $_POST['biaya'];
    $keamanan = $_POST['keamanan'];
    $fk_jenis_wisata_id = $_POST['fk_jenis_wisata_id'];

    // Query untuk memasukkan data ke tabel pariwisata
    $query = "INSERT INTO pariwisata (nama_pariwisata, lokasi, deskripsi, fasilitas, biaya, keamanan, fk_jenis_wisata_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $nama_wisata, $lokasi, $deskripsi, $fasilitas, $biaya, $keamanan, $fk_jenis_wisata_id);

    if ($stmt->execute()) {
        $wisata_id = $stmt->insert_id; // Ambil ID wisata yang baru ditambahkan

        // Simpan URL gambar jika ada
        if (!empty($_POST['url_gambar'])) {
            $url_gambar_array = $_POST['url_gambar'];
            foreach ($url_gambar_array as $url_gambar) {
                if (!empty($url_gambar)) {
                    $gambar_query = "INSERT INTO gambar_wisata (id_wisata, url_gambar) VALUES (?, ?)";
                    $gambar_stmt = $conn->prepare($gambar_query);
                    $gambar_stmt->bind_param("is", $wisata_id, $url_gambar);
                    $gambar_stmt->execute();
                }
            }
        }

        $success_message = "Wisata berhasil ditambahkan.";
    } else {
        $error_message = "Terjadi kesalahan saat menambahkan wisata. Silakan coba lagi.";
    }
}

// Ambil data jenis wisata untuk dropdown
$jenis_wisata_query = "SELECT * FROM jenis_wisata";
$jenis_wisata_result = $conn->query($jenis_wisata_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #343a40;
            padding-top: 20px;
            transition: 0.3s;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #f8f9fa;
            display: block;
        }
        .sidebar button a:hover {
            background-color: rgb(255, 117, 117);
        }
        .sidebar a:hover {
            background-color: #575d63;
        }
        .main-content {
            margin-left: 0;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .open-btn {
            font-size: 20px;
            cursor: pointer;
            background-color: #343a40;
            color: white;
            padding: 10px 15px;
            border: none;
        }
        .close-btn {
            font-size: 20px;
            cursor: pointer;
            background-color: #343a40;
            color: white;
            padding: 10px 15px;
            border: none;
            display: block;
            text-align: right;
        }
        .logout {
            background-color: red;
            width: 100%;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <button class="close-btn" onclick="toggleSidebar()"><i class="fas fa-undo"></i></button>
        <a href="#dashboard">Dashboard</a>
        <a href="../USER/index.php">Home</a>
        <a href="index.php">Manage Wisata</a>
        <a href="registeradmin.php">Register Admin</a>
        <button class="logout"><a href="../logout.php" style="color: white; text-decoration: none;">Logout</a></button>
    </div>


    <div class="main-content" id="main-content">
        <button class="open-btn" onclick="toggleSidebar()"><i class="fas fa-bars icon"></i> Menu Admin </button>
        
        <div id="add-wisata">
            <h2>Add New Wisata</h2>
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_wisata" class="form-label">Nama Wisata</label>
                    <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" required>
                </div>
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas</label>
                    <input type="text" class="form-control" id="fasilitas" name="fasilitas" required>
                </div>
                <div class="mb-3">
                    <label for="biaya" class="form-label">Biaya</label>
                    <input type="number" class="form-control" id="biaya" name="biaya" required>
                </div>
                <div class="mb-3">
                    <label for="keamanan" class="form-label">Keamanan</label>
                    <input type="text" class="form-control" id="keamanan" name="keamanan" required>
                </div>
                <div class="mb-3">
                    <label for="fk_jenis_wisata_id" class="form-label">Jenis Wisata</label>
                    <select class="form-select" id="fk_jenis_wisata_id" name="fk_jenis_wisata_id" required>
                        <option value="">Pilih Jenis Wisata</option>
                        <?php while ($jenis = $jenis_wisata_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($jenis['id']) ?>"><?= htmlspecialchars($jenis['jenis_wisata']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="url_gambar" class="form-label">Masukkan URL Gambar (pisahkan dengan koma untuk beberapa gambar)</label>
                    <input type="text" class="form-control" id="url_gambar" name="url_gambar[]" placeholder="https://example.com/image1.jpg, https://example.com/image2.jpg">
                </div>
                <button type="submit" class="btn btn-primary">Tambah Wisata</button>
                <a href="index.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            var mainContent = document.getElementById("main-content");
            if (sidebar.style.left === "-250px") {
                sidebar.style.left = "0";
                mainContent.style.marginLeft = "250px";
            } else {
                sidebar.style.left = "-250px";
                mainContent.style.marginLeft = "0";
            }
        }
    </script>
</body>
</html>