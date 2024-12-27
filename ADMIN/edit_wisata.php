<?php
session_start();
require "../config.php"; // Pastikan Anda menghubungkan ke database
if (isset($_SESSION)){
    if ($_SESSION['level']!='admin'){
        header('Location: ../index.php');
    }
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data wisata berdasarkan ID
    $query = "SELECT p.id, p.nama_pariwisata, p.lokasi, p.fasilitas, p.biaya, p.deskripsi, p.keamanan, p.fk_jenis_wisata_id, gw.url_gambar
              FROM pariwisata p
              LEFT JOIN gambar_wisata gw ON p.id = gw.id_wisata
              WHERE p.id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak diberikan.";
    exit;
}

// Ambil data jenis wisata untuk dropdown
$jenis_wisata_query = "SELECT id, jenis_wisata FROM jenis_wisata";
$jenis_wisata_result = $conn->query($jenis_wisata_query);

// Ambil gambar yang sudah ada
$gambar_query = "SELECT url_gambar FROM gambar_wisata WHERE id_wisata = ?";
$gambar_stmt = $conn->prepare($gambar_query);
$gambar_stmt->bind_param("i", $id);
$gambar_stmt->execute();
$gambar_result = $gambar_stmt->get_result();
$gambar_urls = [];
while ($gambar_row = $gambar_result->fetch_assoc()) {
    $gambar_urls[] = $gambar_row['url_gambar'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Wisata</title>
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
        .sidebar a:hover {
            background-color: #575d63;
        }
        .sidebar button a:hover {
            background-color: rgb(255, 117, 117);
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
        
        <div id="edit-wisata">
            <h2>Edit Wisata</h2>
            <form method="POST" action="update_wisata.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                <div class="mb-3">
                    <label for="nama_pariwisata" class="form-label">Nama Pariwisata</label>
                    <input type="text" class="form-control" id="nama_pariwisata" name="nama_pariwisata" value="<?= htmlspecialchars($row['nama_pariwisata']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?= htmlspecialchars($row['lokasi']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas</label>
                    <input type="text" class="form-control" id="fasilitas" name="fasilitas" value="<?= htmlspecialchars($row['fasilitas']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="biaya" class="form-label">Biaya</label>
                    <input type="number" class="form-control" id="biaya" name="biaya" value="<?= htmlspecialchars($row['biaya']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="6" style="min-height: 60px;" required oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"><?= htmlspecialchars($row['deskripsi']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="keamanan" class="form-label">Keamanan</label>
                    <input type="text" class="form-control" id="keamanan" name="keamanan" value="<?= htmlspecialchars($row['keamanan']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="fk_jenis_wisata_id" class="form-label">Jenis Wisata</label>
                    <select class="form-select" id="fk_jenis_wisata_id" name="fk_jenis_wisata_id" required>
                        <option value="">--Pilih Jenis Wisata--</option>
                        <?php while ($jenis = $jenis_wisata_result->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($jenis['id']) ?>" <?= ($jenis['id'] == $row['fk_jenis_wisata_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($jenis['jenis_wisata']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="url_gambar" class="form-label">URL Gambar (tambahkan lebih dari satu)</label>
                    <div id="gambar-container">
                        <input type="url" class="form-control mb-2" name="url_gambar[]" placeholder="https://example.com/image.jpg">
                        <?php foreach ($gambar_urls as $url): ?>
                            <input type="url" class="form-control mb-2" name="url_gambar[]" value="<?= htmlspecialchars($url) ?>" placeholder="https://example.com/image.jpg">
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="addImageInput()">Tambah Gambar</button>
                </div>
                <div class="mb-3">
                    <h5>Gambar yang sudah ada:</h5>
                    <?php foreach ($gambar_urls as $url): ?>
                        <img src="<?= htmlspecialchars($url) ?>" class="img-thumbnail" alt="Gambar" style="max-width: 200px; margin-right: 10px;">
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="btn btn-primary">Update Wisata</button>
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

        function addImageInput() {
            var container = document.getElementById("gambar-container");
            var input = document.createElement("input");
            input.type = "url";
            input.className = "form-control mb-2";
            input.name = "url_gambar[]";
            input.placeholder = "https://example.com/image.jpg";
            container.appendChild(input);
        }
    </script>
</body>
</html>