<?php
session_start();
require "../config.php";
$sql = "SELECT * FROM jenis_wisata";
$ambiljeniswisata = mysqli_query($conn,$sql);
?>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   NextSiakad
  </title>
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
            background-color: #f8f9fa;
            padding: 50px 0;
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
            color: #6c757d;
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
    <section class="hero-section ">
    <div class="bg-secondary p-5 text-center text-white" ><h2>Sejarah singkat</h2></div>
    <div class="p-3">
        <p>Sragen adalah sebuah kabupaten di Jawa Tengah yang memiliki sejarah panjang yang dimulai sejak masa prasejarah. Wilayah ini menjadi salah satu tempat penting dalam sejarah evolusi manusia, yang dibuktikan melalui penemuan berbagai artefak dan fosil manusia purba di Sangiran, sebuah situs yang kini diakui sebagai warisan dunia oleh UNESCO. Sangiran tidak hanya menjadi pusat penemuan fosil Homo erectus, tetapi juga menjadi lokasi studi tentang kehidupan prasejarah, menjadikan Sragen sebagai salah satu kunci penting dalam penelitian evolusi manusia. Bukti lain berupa alat-alat batu dan peninggalan arkeologi menunjukkan bahwa Sragen telah dihuni manusia sejak ribuan tahun lalu.</p>

        <p>Pada masa kerajaan-kerajaan di Jawa, Sragen berada di bawah pengaruh Kerajaan Mataram Kuno yang mendominasi Jawa Tengah. Ketika era kerajaan Islam berkembang, wilayah ini menjadi bagian dari Kesultanan Pajang dan kemudian Kesultanan Mataram. Dalam periode ini, tradisi dan budaya Jawa mulai berkembang pesat, termasuk seni pertunjukan seperti wayang kulit dan gamelan, yang masih dilestarikan hingga sekarang. Beberapa nama tempat di Sragen juga mencerminkan sejarah panjang ini, menunjukkan peran penting wilayah tersebut dalam dinamika politik dan budaya pada zamannya.</p>
        
        <p>Saat era kolonial Belanda, Sragen mulai mengalami pembangunan infrastruktur untuk mendukung kegiatan ekonomi, terutama di sektor pertanian. Letak strategis Sragen sebagai penghubung berbagai wilayah di Jawa membuatnya menjadi salah satu pusat penting dalam distribusi hasil bumi. Beberapa peninggalan dari era kolonial, seperti saluran irigasi dan jembatan, masih dapat ditemukan di beberapa lokasi. Setelah Indonesia merdeka, Sragen resmi menjadi bagian dari provinsi Jawa Tengah, dengan perkembangan pemerintahan daerah yang terus ditingkatkan.</p>
        
        <p>Kini, Sragen dikenal tidak hanya sebagai daerah agraris tetapi juga sebagai destinasi wisata sejarah dan budaya. Situs Sangiran menjadi daya tarik utama, menampilkan koleksi fosil manusia purba yang mendunia. Selain itu, Sragen menawarkan keindahan alam seperti Kedung Ombo dan Kedung Grujug, serta tempat-tempat bersejarah seperti Gunung Kemukus yang memiliki nilai budaya dan spiritual. Dengan kekayaan sejarah, tradisi, dan potensi alamnya, Sragen menjadi salah satu wilayah yang penting dalam memahami perkembangan budaya dan peradaban di Jawa.</p></div>
    </section>

<script crossorigin="anonymous" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n5Y5q5Y5n