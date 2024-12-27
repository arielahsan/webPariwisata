<?php
session_start();
require "../config.php";
$sql = "SELECT * FROM jenis_wisata";
$ambiljeniswisata = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Pariwisata Kabupaten Sragen</title>
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
        .hero-section {
            background-image: url('IMG/Ornamen-Replika-Gading-Gajah-Raksasa.-Foto-Gmap-Reno-Herdhiansyah-e1619776202522.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: #fff; 
            text-shadow: 0px 1px 5px rgba(0, 0, 0, 0.7); 
            margin: 0;
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #7b2ff7;
        }
        .hero-section h1 span {
            color: #000;
        }
        .hero-section p {
            font-size: 1.25rem;
            color: #fff;
        }
        .btn-get-started {
            background: linear-gradient(90deg, #7b2ff7, #00c6ff);
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
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

<section class="hero-section text-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-md-start">
                <h1>
                    Pariwisata
                    <span>
                        Kabupaten Sragen
                    </span>
                </h1>
                <p>
                    Memudahkan Akses Pariwisata Kabupaten Sragen
                </p>
                <a class="btn btn-get-started" href="profil.php">
                    Get Started
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="col-md-6">      
            </div>
        </div>
    </div>
</section>
</body>
</html>