<?php require "config.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title><?= $tb_setelan['nama'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/logo.png" type="image/x-icon">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/animate/animate.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
   <style>
      html,
      body {
         background: #F1F7FF;
      }
      .navbar-logo {
    height: 42px;
    margin-right: 8px;
}

.navbar-text {
    white-space: nowrap;
    color: #000000;
}

@media (max-width: 576px) {
    .navbar-text {
        font-size: 14px; /* Sesuaikan ukuran font untuk layar kecil */
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%; /* Pastikan elemen tetap berada di tengah */
        text-align: center;
    }
}

   </style>
</head>

<nav class="navbar navbar-landing-page navbar-expand-lg navbar-light fixed-top py-4">
   <div class="container my-auto">
      <a class="navbar-brand" href="<?= base_url() ?>">
         <img src="<?= base_url() ?>/assets/img/logo.png" alt="Logo" class="navbar-logo">
         <span class="navbar-text">SMK PGRI SUMBER PUCUNG</span>
      </a>
   </div>
</nav>

<div class="landing-page" id="beranda">
   <div class="container">
      <div class="row d-flex justify-content-center">
         <div class=" col-12 col-lg-6 my-auto">
         <h1>
            <a href="<?= base_url() ?>" style="text-decoration: none;">
            <?= $tb_setelan['nama'] ?>
            <span>- lebih mudah & cepat</span>
            </a>
         </h1>
            <p>adalah sebuah kegiatan pengambilan data guna mengetahui jumlah kehadiran pada suatu acara. Setiap kegiatan yang membutuhkan informasi mengenai peserta tentu akan melakukan absensi.</p>
            <a href="<?= base_url() ?>/auth/siswa" class="btn btn-outline-linear-primary waves-effect my-2">
               Login Siswa
            </a>
            <a href="<?= base_url() ?>/auth/guru" class="btn btn-outline-linear-primary waves-effect my-2">
               Login Guru
            </a>
            <br>
            <a href="<?= base_url() ?>/auth/ortu" class="btn btn-outline-linear-success waves-effect my-2">
               Login Ortu
            </a>
            <a href="<?= base_url() ?>/auth/karyawan" class="btn btn-outline-linear-success waves-effect my-2">
               Login Karyawan
            </a><br>
            <a href="<?= base_url() ?>/auth/admin" class="btn btn-outline-linear-success waves-effect my-2">
               Login Admin
            </a>
         </div>
         <div class="col-10 col-lg-6 my-5 img">
            <img src="<?= base_url() ?>/assets/img/undraw_work_chat_erdt.svg" alt="gambar" class="img-fluid">
         </div>
      </div>
   </div>
</div>


<div class="copyright">
   <div class="container">
      <img src="<?= base_url() ?>/assets/img/logo.png" alt="Logo">
      <p>
         &copy; Copyright smkpgrisumberpucung 2024 <?= $tb_setelan['nama'] ?>
      </p>
   </div>
</div>

<body>
   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
</body>

</html>