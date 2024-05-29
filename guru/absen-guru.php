<?php
require "../config.php";
$j_guru = query("SELECT * FROM j_guru LIMIT 1");

$masuk_mulai = date('Hi', strtotime($j_guru['masuk_mulai']));
$masuk_akhir = date('Hi', strtotime($j_guru['masuk_akhir']));
$pulang_mulai = date('Hi', strtotime($j_guru['pulang_mulai']));
$pulang_akhir = date('Hi', strtotime($j_guru['pulang_akhir']));
$waktu_sekarang = new DateTime();

$waktu_sekarang->modify('-1 hour');
$waktu_sekarang = $waktu_sekarang->format('Hi');

$tanggal = date('d');
$bulan_tahun = date('m-Y');

$jml_hari = jml_hari(date('m'), date('Y'));
function absenMasuk()
{
   global $conn;
   global $tanggal;
   global $bulan_tahun;
   $result = mysqli_query($conn, "SELECT * FROM a_masuk_guru WHERE id_guru = '$_SESSION[guru]' && m_bulan_tahun = '$bulan_tahun'");
   $a_masuk_guru = mysqli_fetch_assoc($result);
   if (isset($a_masuk_guru[$tanggal])) {
      if ($a_masuk_guru[$tanggal] == '') {
         $row_tgl = true;
      } else {
         $row_tgl = $a_masuk_guru[$tanggal];
      }
   } else {
      $row_tgl = true;
   }
   return num_rows("SELECT * FROM a_masuk_guru WHERE `$tanggal` = '$row_tgl'");
}

function absenPulang()
{
   global $conn;
   global $tanggal;
   global $bulan_tahun;
   $result = mysqli_query($conn, "SELECT * FROM a_pulang_guru WHERE id_guru = '$_SESSION[guru]' && p_bulan_tahun = '$bulan_tahun'");
   $a_pulang_guru = mysqli_fetch_assoc($result);
   if (isset($a_pulang_guru[$tanggal])) {
      if ($a_pulang_guru[$tanggal] == '') {
         $row_tgl = true;
      } else {
         $row_tgl = $a_pulang_guru[$tanggal];
      }
   } else {
      $row_tgl = true;
   }
   return num_rows("SELECT * FROM a_pulang_guru WHERE `$tanggal` = '$row_tgl'");
} ?>

<div class="content-title">
   Absen guru
</div>
<div class="row">
   <div class="col-md-6">
      <div class="card">
         <div class="card-body text-center py-5">
            <div class="py-4 px-3" style="background: #E1E4F9; border-radius: 10px;">
               <div class="mb-3">
                  <img src="<?= base_url() ?>/img/guru/<?= $tb_guru['profil'] ?>" alt="<?= $tb_guru['profil'] ?>" class="img-fluid rounded-circle" height="60" width="60" style="background-size: cover">
               </div>
               <h5><?= $tb_guru['nama'] ?></h5>
               <p><?= 'NIP:' . $tb_guru['nip'] ?></p>
               <span class="f-size-14px">
                  <span class="jam-sekarang f-size-28px"><?= date('H:i:s') ?></span>
                  <br>
                  <?= waktu_sekarang() ?>
               </span>
               <?= $waktu_sekarang ?>
            </div>
            <div class="mt-5">
               <?php
               if ($waktu_sekarang >= $masuk_mulai && $waktu_sekarang < $masuk_akhir) {
                  if (absenMasuk() == 0) { ?>
                     <button type="button" class="btn btn-absen warning waves-effect waves-warning infinite animated pulse" id="click-absen-masuk">
                        Masuk
                     </button>
                  <?php } else { ?>
                     <button type="button" class="btn btn-absen warning infinite animated pulse" disabled="disabled">
                        <i class="la la-check"></i>
                     </button>
                  <?php }
               } elseif ($waktu_sekarang >= $masuk_akhir && $waktu_sekarang < $pulang_mulai) {
                  if (absenMasuk() == 0) { ?>
                     <button type="button" class="btn btn-absen warning" disabled="disabled">
                        <i class="la la-times"></i>
                     </button>
                  <?php } else { ?>
                     <button type="button" class="btn btn-absen warning infinite animated pulse" disabled="disabled">
                        <i class="la la-check"></i>
                     </button>
                  <?php }
               } elseif ($waktu_sekarang >= $pulang_mulai && $waktu_sekarang < $pulang_akhir) {
                  if (absenMasuk() == 0) { ?>
                     <button type="button" class="btn btn-absen danger" disabled="disabled">
                        <i class="la la-times"></i>
                     </button>
                  <?php } elseif (absenPulang() == 0) { ?>
                     <button type="button" class="btn btn-absen danger waves-effect waves-danger infinite animated pulse" id="click-absen-pulang">
                        Pulang
                     </button>
                  <?php } else { ?>
                     <button type="button" class="btn btn-absen danger infinite animated pulse" disabled="disabled">
                        <i class="la la-check"></i>
                     </button>
                  <?php }
               } elseif ($waktu_sekarang >= $pulang_akhir && $waktu_sekarang < '2400') {
                  if (absenPulang() == 0) { ?>
                     <button type="button" class="btn btn-absen danger" disabled="disabled">
                        <i class="la la-times"></i>
                     </button>
                  <?php } else { ?>
                     <button type="button" class="btn btn-absen danger" disabled="disabled">
                        <i class="la la-check"></i>
                     </button>
                  <?php }
               } else { ?>
                  <button type="button" class="btn btn-absen warning" disabled="disabled">
                     Masuk
                  </button>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 my-auto text-center info-waktu">
      <div class="font-italic f-size-20px my-4">
         <p style="color: #343336;">
            <?php
            if ($waktu_sekarang >= $masuk_mulai && $waktu_sekarang < $masuk_akhir) {
               if (absenMasuk() == 0) {
                  echo 'Sekarang waktunya melakukan absen masuk';
               } else {
                  echo 'Kamu sudah melakukan absen masuk hari ini, tunggu absen pulang selanjutnya';
               }
            } elseif ($waktu_sekarang >= $masuk_akhir && $waktu_sekarang < $pulang_mulai) {
               if (absenMasuk() == 0) {
                  echo 'Absen masuk sudah berakhir pada jam ' . $j_guru['masuk_akhir'] . ' yang lalu';
               } else {
                  echo 'Kamu sudah melakukan absen masuk hari ini, tunggu absen pulang selanjutnya';
               }
            } elseif ($waktu_sekarang >= $pulang_mulai && $waktu_sekarang < $pulang_akhir) {
               if (absenMasuk() == 0) {
                  echo 'Kamu tidak melakukan absen masuk, maka tidak bisa melakukan absen pulang hari ini';
               } elseif (absenPulang() == 0) {
                  echo 'Sekarang waktunya melakukan absen pulang';
               } else {
                  echo 'Kamu sudah melakukan absen pulang hari ini';
               }
            } elseif ($waktu_sekarang >= $pulang_akhir && $waktu_sekarang < '2400') {
               if (absenPulang() == 0) {
                  echo 'Absen pulang sudah berakhir pada jam ' . $j_guru['pulang_akhir'] . ' yang lalu';
               } else {
                  echo 'Kamu sudah melakukan absen pulang hari ini';
               }
            } else {
               echo 'Belum waktunya melakukan absen masuk';
            }
            ?>
         </p>
      </div>
      <div id="carouselJadwalAbsen" class="carousel slide" data-ride="carousel">
         <div class="carousel-inner">
            <div class="carousel-item active">
               <div class="row d-flex justify-content-center mx-1">
                  <div class="col-md-6">
                     <div class="card-info-waktu waves-effect waves-light">
                        <div class="waktu-mulai" data-tooltip="tooltip" title="Absen masuk dilakukan pada saat atau sesudah jam <?= $j_guru['masuk_mulai'] ?>">
                           Masuk Mulai <br> <span><?= $j_guru['masuk_mulai'] ?></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="card-info-waktu waves-effect waves-light">
                        <div class="waktu-akhir" data-tooltip="tooltip" title="Batas waktu melakukan absen masuk pada jam <?= $j_guru['masuk_akhir'] ?>">
                           Masuk Akhir <br> <span><?= $j_guru['masuk_akhir'] ?></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="carousel-item">
               <div class="row d-flex justify-content-center mx-1">
                  <div class="col-md-6">
                     <div class="card-info-waktu waves-effect waves-light">
                        <div class="waktu-mulai" data-tooltip="tooltip" title="Absen pulang dilakukan pada saat atau sesudah jam <?= $j_guru['pulang_mulai'] ?>">
                           Pulang Mulai <br> <span><?= $j_guru['pulang_mulai'] ?></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="card-info-waktu waves-effect waves-light">
                        <div class="waktu-akhir" data-tooltip="tooltip" title="Batas waktu melakukan absen pulang pada jam <?= $j_guru['pulang_akhir'] ?>">
                           Pulang Akhir <br> <span><?= $j_guru['pulang_akhir'] ?></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <a class="carousel-control-prev" href="#carouselJadwalAbsen" role="button" data-slide="prev">
            <span><i class="la la-angle-left waves-effect waves-dark ml-n4"></i></span>
            <span class="sr-only">Previous</span>
         </a>
         <a class="carousel-control-next" href="#carouselJadwalAbsen" role="button" data-slide="next">
            <span><i class="la la-angle-right waves-effect waves-dark mr-n4"></i></span>
            <span class="sr-only">Next</span>
         </a>
      </div>
   </div>
</div>


<div class="card my-4">
   <div class="card-body">
      <div class="table-responsive overlay-scrollbars my-3">
         <table class="table table-bordered table-hover">
            <thead class="text-center">
               <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
                  <th colspan="<?= $jml_hari ?>">absen masuk <?= bulan(date('m')) . ' ' . date('Y'); ?></th>
               </tr>
               <tr>
                  <?php
                  for ($i = 1; $i <= $jml_hari; $i++) {
                     if ($i < 10) {
                        $i = 0 . $i;
                     }
                     echo "<th>$i</th>";
                  } ?>
               </tr>
            </thead>
            <tbody class="text-center" id="intervalAbsenMasukMonitoring"></tbody>
         </table>
      </div>
      <div class="table-responsive overlay-scrollbars my-3">
         <table class="table table-bordered table-hover">
            <thead class="text-center">
               <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
                  <th colspan="<?= $jml_hari ?>">absen pulang <?= bulan(date('m')) . ' ' . date('Y'); ?></th>
               </tr>
               <tr>
                  <?php
                  for ($i = 1; $i <= $jml_hari; $i++) {
                     if ($i < 10) {
                        $i = 0 . $i;
                     }
                     echo "<th class='text-center'>$i</th>";
                  } ?>
               </tr>
            </thead>
            <tbody class="text-center" id="intervalAbsenPulangMonitoring"></tbody>
         </table>
      </div>
   </div>
</div>

<?php if ($waktu_sekarang >= $masuk_mulai && $waktu_sekarang < $masuk_akhir) { ?>
   <form id="formAbsenMasuk" enctype="multipart/form-data">
      <div class="modal fade animated zoomIn" id="modalAbsenMasuk" tabindex="-1" role="dialog" aria-labelledby="modalAbsenMasukLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <i class="la la-times"></i>
                  </button>
               </div>
               <div class="modal-body text-center">
                  <input type="hidden" name="id_guru" value="<?= $tb_guru['id_guru'] ?>">
                  <input type="hidden" name="latitude" id="latitude">
                  <input type="hidden" name="longitude" id="longitude">
                  <input type="hidden" name="m_foto" id="m_foto">
                  <div class="form-group" style="color: #1e3056;">
                     <p class="f-size-28px mb-0">Halo, <?= $tb_guru['nama'] ?></p>
                     <p>Sudah siap absen masuk hari ini, pilih salah satu alasan dibawah.</p>
                  </div>
                  <div class="form-group">
                     <label class="btn btn-radio active">Hadir
                        <input type="radio" class="d-none" name="m_alasan" id="btn-radio-hadir" value="hadir" checked="">
                     </label>
                     <label class="btn btn-radio">Izin
                        <input type="radio" class="d-none" name="m_alasan" id="btn-radio-izin" value="izin">
                     </label>
                     <label class="btn btn-radio">Sakit
                        <input type="radio" class="d-none" name="m_alasan" id="btn-radio-sakit" value="sakit">
                     </label>
                  </div>
                  <div class="form-group">
                     <textarea name="m_ket" id="m_ket" rows="3" class="form-control form-control2" placeholder="Berikan keterangan..." required="">Hadir</textarea>
                  </div>
                  <div class="form-group">
                     <div id="my_camera"></div>
                  </div>
                  <p class="text-left font-italic">Posisikan muka kamu di kamera, sampai proses absen selesai dan pastikan GPS kamu dalam keadaan aktif!</p>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-linear-primary btn-lg btn-user btn-block waves-effect waves-light" id="btn-absen-masuk">Absen Masuk</button>
               </div>
            </div>
         </div>
      </div>
   </form>
<?php } ?>
<?php
if ($waktu_sekarang >= $pulang_mulai && $waktu_sekarang < $pulang_akhir) {
   if (absenPulang() == 0 && absenMasuk() !== 0) { ?>
      <form id="formAbsenPulang" enctype="multipart/form-data">
         <div class="modal fade animated zoomIn" id="modalAbsenPulang" tabindex="-1" role="dialog" aria-labelledby="modalAbsenPulangLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="la la-times"></i>
                     </button>
                  </div>
                  <div class="modal-body text-center">
                     <input type="hidden" name="id_guru" value="<?= $tb_guru['id_guru'] ?>">
                     <input type="hidden" name="latitude" id="latitude_pulang">
                     <input type="hidden" name="longitude" id="longitude_pulang">
                     <input type="hidden" name="p_foto" id="p_foto">
                     <div class="form-group" style="color: #1e3056;">
                        <p class="f-size-28px mb-0">Halo, <?= $tb_guru['nama'] ?></p>
                        <p>Sudah siap absen pulang hari ini.</p>
                     </div>
                     <div class="form-group">
                        <div id="my_camera_pulang"></div>
                     </div>
                     <p class="text-left font-italic">Posisikan muka kamu di kamera, sampai proses absen selesai dan pastikan GPS kamu dalam keadaan aktif!</p>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-linear-primary btn-lg btn-user btn-block waves-effect waves-light" id="btn-absen-pulang">Absen Pulang</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
<?php }
} ?>

<script>
   function take_snapshot() {
      Webcam.snap(function(data_uri) {
         $('#result_camera').html('<img src="' + data_uri + '">');
      });
   }

   var masuk_mulai = '<?= $j_guru['masuk_mulai'] ?>:00';
   masuk_akhir = '<?= $j_guru['masuk_akhir'] ?>:00';
   pulang_mulai = '<?= $j_guru['pulang_mulai'] ?>:00';
   pulang_akhir = '<?= $j_guru['pulang_akhir'] ?>:00';
   setInterval(function() {
      $.ajax({
         url: '../jam-sekarang',
         success: function(jamSekarang) {
            if (masuk_mulai == jamSekarang) {
               location.reload();
            } else if (masuk_akhir == jamSekarang) {
               location.reload();
            } else if (pulang_mulai == jamSekarang) {
               location.reload();
            } else if (pulang_akhir == jamSekarang) {
               location.reload();
            }
            $('.jam-sekarang').html(jamSekarang);
         }
      });
   }, 1000);

   setInterval(function() {
      $.ajax({
         url: '../jam-sekarang',
         success: function(jamSekarang) {
            $('.jam-sekarang').html(jamSekarang);
         }
      });
   }, 1000);




   $('#click-absen-masuk').click(function() {
      Webcam.set({
         width: 184,
         height: 230,
         image_format: 'jpeg',
         jpeg_quality: 90
      });
      Webcam.attach('#my_camera');

      if (geo_position_js.init()) {
         geo_position_js.getCurrentPosition(success_callback, error_callback, {
            enableHighAccuracy: true
         });
      } else {
         pesan('Tidak ada fungsi geolocation', 3000);
         return false;
      }

      function success_callback(p) {
         latitude = p.coords.latitude;
         longitude = p.coords.longitude;
         $('#latitude').val(latitude);
         $('#longitude').val(longitude);
      }

      function error_callback(p) {
         pesan('error = ' + p.message, 3000);
         return false;
      }

      $('#modalAbsenMasuk').modal('show');
   })

   $('#formAbsenMasuk').submit(function(e) {
      Webcam.snap(function(data_uri) {
         $('#m_foto').val(data_uri);
      });

      $('#btn-absen-masuk').attr('disabled', 'disabled');
      $('#btn-absen-masuk').html('<div class="spinner-border text-white" role="status"></div>');

      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi-absen?absen_masuk',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               window.location.href = 'terimakasih';
            }

            if (data == 'gagal') {
               pesan('Terdapat kesalahan pada sistem!', 3000);
               $('#btn-absen-masuk').removeAttr('disabled', 'disabled');
               $('#btn-absen-masuk').html('Masuk');
            }
         }
      });
   });

   $('#click-absen-pulang').click(function() {
      Webcam.set({
         width: 184,
         height: 230,
         image_format: 'jpeg',
         jpeg_quality: 90
      });
      Webcam.attach('#my_camera_pulang');

      if (geo_position_js.init()) {
         geo_position_js.getCurrentPosition(success_callback, error_callback, {
            enableHighAccuracy: true
         });
      } else {
         pesan('Tidak ada fungsi geolocation', 3000);
         return false;
      }

      function success_callback(p) {
         latitude = p.coords.latitude;
         longitude = p.coords.longitude;
         $('#latitude_pulang').val(latitude);
         $('#longitude_pulang').val(longitude);
      }

      function error_callback(p) {
         pesan('error = ' + p.message, 3000);
         return false;
      }

      $('#modalAbsenPulang').modal('show');
   });

   $('#formAbsenPulang').submit(function(e) {
      Webcam.snap(function(data_uri) {
         $('#p_foto').val(data_uri);
      });


      $('#btn-absen-pulang').attr('disabled', 'disabled');
      $('#btn-absen-pulang').html('<div class="spinner-border text-white" role="status"></div>');

      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi-absen?absen_pulang',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               window.location.href = 'terimakasih';
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
               $('#click-absen-pulang').removeAttr('disabled', 'disabled');
               $('#click-absen-pulang').html('Pulang');
            }
         }
      });
   });

   setInterval(function() {
      intervalAbsenMasukMonitoring();
      intervalAbsenPulangMonitoring();
   }, 60000);

   intervalAbsenMasukMonitoring();
   intervalAbsenPulangMonitoring();

   function intervalAbsenMasukMonitoring() {
      $.ajax({
         type: 'post',
         url: 'intervalAbsenMasukMonitoringGuru',
         data: {
            m_bulan_tahun: '<?= $bulan_tahun ?>'
         },
         success: function(data) {
            $('#intervalAbsenMasukMonitoring').html(data);
         }
      });
   }

   function intervalAbsenPulangMonitoring() {
      $.ajax({
         type: 'post',
         url: 'intervalAbsenPulangMonitoringGuru',
         data: {
            p_bulan_tahun: '<?= $bulan_tahun ?>'
         },
         success: function(data) {
            $('#intervalAbsenPulangMonitoring').html(data);
         }
      });
   }

   $('#btn-radio-hadir').click(function() {
      $('#m_ket').html('Hadir');
   });

   $('#btn-radio-izin, #btn-radio-sakit').click(function() {
      $('#m_ket').html('');
   });

   $('.btn-radio').click(function() {
      $('.btn-radio.active').removeClass('active');
      $(this).addClass('active');
   });
</script>