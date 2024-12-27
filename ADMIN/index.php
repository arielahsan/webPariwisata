<?php
session_start();
require "../config.php"; // Pastikan Anda menghubungkan ke database
if (isset($_SESSION)){
    if ($_SESSION['level']!='admin'){
        header('Location: ../index.php');
    }
}
// Ambil data dari tabel pariwisata dan gambar_wisata
$query = "
    SELECT p.id, p.nama_pariwisata, p.lokasi, p.deskripsi, p.fasilitas, p.biaya, p.keamanan, jw.jenis_wisata, gw.url_gambar
    FROM pariwisata p
    LEFT JOIN jenis_wisata jw ON p.fk_jenis_wisata_id = jw.id
    LEFT JOIN gambar_wisata gw ON p.id = gw.id_wisata
    ORDER BY p.nama_pariwisata ASC;
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Wisata Management</title>
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
        .action {
            min-width: 10em;
        }
        .logout {
            background-color: red;
            width: 100%;
            text-align: left;
        }
        .img-thumbnail {
            max-width: 100px; /* Atur ukuran gambar */
            max-height: 100px; /* Atur ukuran gambar */
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <button class="close-btn" onclick="toggleSidebar()"><i class="fas fa-undo"></i></button>
        <a href="#dashboard">Dashboard</a>
        <a href="../USER/index.php">Home</a>
        <a href="#manage-wisata">Manage Wisata</a>
        <a href="registeradmin.php">Register Admin</a>
        <button class="logout"><a href="../logout.php" style="color: white; text-decoration: none;">Logout</a></button>
    </div>

    <div class="main-content" id="main-content">
        <button class="open-btn" onclick="toggleSidebar()"><i class="fas fa-bars icon"></i> Menu Admin </button>
        
        <div id="manage-wisata">
            <h2>Manage Wisata</h2>
            <a href="add_wisata.php"><button class="btn btn-primary mb-3">Add New Wisata</button></a>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Deskripsi</th>
                        <th>Fasilitas</th>
                        <th>Keamanan</th>
                        <th >Jenis Wisata</th>
                        <th>Gambar</th>
                        <th class="action">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['nama_pariwisata']) ?></td>
                            <td><?= htmlspecialchars($row['lokasi']) ?></td>
                            <td><?= htmlspecialchars(substr($row['deskripsi'], 0, 50)) . (strlen($row['deskripsi']) > 50 ? '...' : '') ?></td>
                            <td><?= htmlspecialchars($row['fasilitas']) ?></td>
                            <td><?= htmlspecialchars($row['keamanan']) ?></td>
                            <td><?= htmlspecialchars($row['jenis_wisata']) ?></td>
                            <td>
                                <?php if (!empty($row['url_gambar'])): ?>
                                    <img src="<?= htmlspecialchars($row['url_gambar']) ?>" class="img-thumbnail" alt="Gambar <?= htmlspecialchars($row['nama_pariwisata']) ?>">
                                <?php else: ?>
                                    <span>Tidak ada gambar</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="edit_wisata.php?id=<?php echo $row['id']; ?>"><button class="btn btn-warning">Edit</button></a>
                                <button class="btn btn-danger" onclick="confirmDelete(<?= $row['id'] ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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

        function confirmDelete(id) {
            if (confirm("Apakah anda ingin menghapus lokasi pariwisata ini?")) {
                window.location.href = "delete_wisata.php?id=" + id;
            }
        }
    </script>
</body>
</html>