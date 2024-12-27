<?php
session_start();
require "../config.php";

// Query untuk mendapatkan data wisata dan gambar terkait
$query = "
    SELECT p.id AS id_pariwisata, p.nama_pariwisata, p.lokasi, p.fasilitas, 
           p.biaya, p.deskripsi, p.keamanan, 
           jw.jenis_wisata, 
           GROUP_CONCAT(gw.url_gambar SEPARATOR '|') AS gambar_urls
    FROM pariwisata p
    LEFT JOIN jenis_wisata jw ON p.fk_jenis_wisata_id = jw.id
    LEFT JOIN gambar_wisata gw ON p.id = gw.id_wisata
    GROUP BY p.id
    ORDER BY p.nama_pariwisata ASC;
";
$sql = "SELECT * FROM jenis_wisata";
$ambiljeniswisata = mysqli_query($conn,$sql);

if($_SERVER['REQUEST_METHOD']=="GET"){
        $defaultquery=$query;

    if(isset($_GET['jenis_wisata'])){
        $jenis_wisata = $_GET['jenis_wisata'];

        $query = "
    SELECT p.id AS id_pariwisata, p.nama_pariwisata, p.lokasi, p.fasilitas, 
           p.biaya, p.deskripsi, p.keamanan, 
           jw.jenis_wisata, 
           GROUP_CONCAT(gw.url_gambar SEPARATOR '|') AS gambar_urls
    FROM pariwisata p
    LEFT JOIN jenis_wisata jw ON p.fk_jenis_wisata_id = jw.id
    LEFT JOIN gambar_wisata gw ON p.id = gw.id_wisata
    WHERE p.fk_jenis_wisata_id = $jenis_wisata
    GROUP BY p.id
    ORDER BY p.nama_pariwisata ASC;
";
    }
}
try {
    $result = $conn->query($query);
}
catch(Exception $e) {
  $result = $conn->query($defaultquery);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Pariwisata</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            color: #7b2ff7;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: #000;
            font-weight: 500;
        }
        .btn-login {
            background: linear-gradient(90deg, #7b2ff7, #00c6ff);
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 5px 20px;
        }
        .frame {
            border: 2px solid #ddd;
            padding: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .card-title-bg {
            background-color: #6c757d; /* Bootstrap bg-secondary */
            color: white;
            padding: 10px;
            font-size: 1.5rem;
        }
        .card-body p {
            margin-bottom: 0.5rem;
        }
        .image-gallery img {
            margin-right: 5px;
            margin-bottom: 5px;
            max-width: 10em;
            max-height: 10em;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="IMG/logo-kabupaten-sragen.jpg" width="50" height="50" alt="">
            </a>
            <a class="navbar-brand" href="#">
                Kabupaten Sragen
            </a>

            <button aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarNav" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php 
                    if($_SESSION['level'] == "admin") {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="../ADMIN/index.php">Admin Dashboard</a>
                    </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Profil</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi Wisata
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="informasi.php">Wisata</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php
                            while ($row=mysqli_fetch_assoc($ambiljeniswisata)){
                                ?><li><a class="dropdown-item" href="informasi.php?jenis_wisata=<?php echo $row['id']?>"><?php echo $row['jenis_wisata'] ;?></a></li>
                            <?php
                            }

                            ?>
                            <!-- <li><a class="dropdown-item" href="informasi.php?jenis_wisata=wisata_alam">Wisata Alam</a></li>
                            <li><a class="dropdown-item" href="informasi.php?jenis_wisata=wisata_budaya">Wisata Budaya</a></li>
                            <li><a class="dropdown-item" href="informasi.php?jenis_wisata=wisata_sejarah">Wisata Sejarah</a></li>
                            
                            <li><a class="dropdown-item" href="informasi.php?jenis_wisata=wisata_rekreasi">Wisata Rekreasi</a></li> -->
                        </ul>
                    </li>      
                    <li class="nav-item">
                        <a class="btn btn-login" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <br>
        <h1 class="text-center my-5">Artikel Pariwisata</h1>
        <div class="d-flex flex-wrap justify-content-between">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="flex-fill mb-4" style="max-width: 30%;">
                        <div class="card">
                            <?php
                            $gambar_urls = explode('|', $row['gambar_urls']); 
                            
                            // echo $gambar_urls;
                            ?>

                            <img src="<?= htmlspecialchars($gambar_urls[0]) ?>" class="card-img-top frame" alt="Gambar <?= htmlspecialchars($row['nama_pariwisata']) ?>">
                            <div class="card-title-bg">
                                <?= htmlspecialchars($row['nama_pariwisata']) ?>
                            </div>
                            <div class="card-body">
                                <p><strong>Lokasi:</strong> <?= htmlspecialchars($row['lokasi']) ?></p>
                                <p><strong>Jenis Wisata:</strong> <?= htmlspecialchars($row['jenis_wisata']) ?></p>
                                <p><strong>Fasilitas:</strong> <?= htmlspecialchars($row['fasilitas']) ?></p>
                                <p><strong>Biaya Masuk:</strong> Rp<?= number_format($row['biaya'], 0, ',', '.') ?></p>
                                <p><strong>Keamanan:</strong> <?= htmlspecialchars($row['keamanan']) ?></p>
                                <p><strong>Deskripsi:</strong> <?= htmlspecialchars($row['deskripsi']) ?></p>
                                <div class="image-gallery">
                                    <?php 
                                    // Tampilkan semua gambar sebagai galeri kecil
                                    $gambar_urls = explode('|', $row['gambar_urls']);
                                    foreach ($gambar_urls as $url): ?>
                                        <img src="<?= htmlspecialchars($url) ?>" alt="Gambar <?= htmlspecialchars($row['nama_pariwisata']) ?>" class="frame">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">Belum ada data pariwisata.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
