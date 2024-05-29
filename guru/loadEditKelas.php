<?php
require "../config.php";
$token_kelas = $_GET['token_kelas'];
$tb_kelas = query("SELECT * FROM tb_kelas WHERE token_kelas = '$token_kelas'");
?>

<div class="content-title">Daftar kelas</div>
<div class="card">
   <form id="formEditKelas">
      <input type="hidden" name="token_kelas" value="<?= $tb_kelas['token_kelas'] ?>">
      <input type="hidden" name="kelas_lama" value="<?= $tb_kelas['kelas'] ?>">
      <div class="card-header">
         <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
            <i class="la la-angle-left f-size-18px mr-2"></i>Kelas: <?= $tb_kelas['kelas'] ?>
         </button>
      </div>
      <div class="card-body">
         <div class="form-group">
            <label for="kelas">Kelas jurusan <span></span></label>
            <input type="text" name="kelas" id="kelas" class="form-control form-control4" value="<?= $tb_kelas['kelas'] ?>" required>
         </div>
         <?php
         $masuk_mulai = $tb_kelas['masuk_mulai'];
         $masuk_mulai_jam = explode(':', $masuk_mulai)[0];
         $masuk_mulai_menit = explode(':', $masuk_mulai)[1];

         $masuk_akhir = $tb_kelas['masuk_akhir'];
         $masuk_akhir_jam = explode(':', $masuk_akhir)[0];
         $masuk_akhir_menit = explode(':', $masuk_akhir)[1];

         $pulang_mulai = $tb_kelas['pulang_mulai'];
         $pulang_mulai_jam = explode(':', $pulang_mulai)[0];
         $pulang_mulai_menit = explode(':', $pulang_mulai)[1];

         $pulang_akhir = $tb_kelas['pulang_akhir'];
         $pulang_akhir_jam = explode(':', $pulang_akhir)[0];
         $pulang_akhir_menit = explode(':', $pulang_akhir)[1]; ?>
         <div class="row">
            <div class="col-md-6">
               <div class="p-4 my-2 my-md-0 b-radius-10px bg-warning shadow-lg">
                  <p class="text-center mb-0 text-white">ABSEN MASUK</p>
                  <h3 class="text-center text-white">
                     <span id="data_masuk_mulai_jam"><?= $masuk_mulai_jam ?></span>:<span id="data_masuk_mulai_menit"><?= $masuk_mulai_menit ?></span> -
                     <span id="data_masuk_akhir_jam"><?= $masuk_akhir_jam ?></span>:<span id="data_masuk_akhir_menit"><?= $masuk_akhir_menit ?></span>
                  </h3>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="masuk_mulai">
                              Masuk mulai
                              <i class="la la-question-circle" data-tooltip="tooltip" title="Absen masuk dilakukan pada saat atau sesudah jam sekian"></i>
                              <span></span>
                           </label>
                           <div class="row">
                              <div class="col-6 pr-2">
                                 <select name="masuk_mulai_jam" id="masuk_mulai_jam" class="custom-select custom-select2 border-0" required>
                                    <?php
                                    for ($i = 0; $i <= 23; $i++) {
                                       if ($i < 10) {
                                          $i = '0' . $i;
                                       }
                                       if ($masuk_mulai_jam == $i) {
                                          echo '<option selected="">' . $i . '</option>';
                                       } else {
                                          echo '<option>' . $i . '</option>';
                                       }
                                    } ?>
                                 </select>
                              </div>
                              <div class="col-6 pl-2">
                                 <select name="masuk_mulai_menit" id="masuk_mulai_menit" class="custom-select custom-select2 border-0" required>
                                    <?php
                                    for ($i = 0; $i <= 59; $i++) {
                                       if ($i < 10) {
                                          $i = '0' . $i;
                                       }
                                       if ($masuk_mulai_menit == $i) {
                                          echo '<option selected="">' . $i . '</option>';
                                       } else {
                                          echo '<option>' . $i . '</option>';
                                       }
                                    } ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="masuk_akhir">
                              Masuk akhir
                              <i class="la la-question-circle" data-tooltip="tooltip" title="Batas waktu melakukan absen masuk pada jam sekian"></i>
                              <span></span>
                           </label>
                           <div class="row">
                              <div class="col-6 pr-2">
                                 <select name="masuk_akhir_jam" id="masuk_akhir_jam" class="custom-select custom-select2 border-0" required>
                                    <?php
                                    for ($i = 0; $i <= 23; $i++) {
                                       if ($i < 10) {
                                          $i = '0' . $i;
                                       }
                                       if ($masuk_mulai_jam <= $i) {
                                          if ($masuk_akhir_jam == $i) {
                                             echo '<option selected="">' . $i . '</option>';
                                          } else {
                                             echo '<option>' . $i . '</option>';
                                          }
                                       }
                                    } ?>
                                 </select>
                              </div>
                              <div class="col-6 pl-2">
                                 <select name="masuk_akhir_menit" id="masuk_akhir_menit" class="custom-select custom-select2 border-0" required>
                                    <?php
                                    for ($i = 0; $i <= 59; $i++) {
                                       if ($i < 10) {
                                          $i = '0' . $i;
                                       }
                                       if ($masuk_akhir_menit == $i) {
                                          echo '<option selected="">' . $i . '</option>';
                                       } else {
                                          echo '<option>' . $i . '</option>';
                                       }
                                    } ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="p-4 my-2 my-md-0 b-radius-10px bg-danger shadow-lg">
                  <p class="text-center mb-0 text-white">ABSEN PULANG</p>
                  <h3 class="text-center text-white">
                     <span id="data_pulang_mulai_jam"><?= $pulang_mulai_jam ?></span>:<span id="data_pulang_mulai_menit"><?= $pulang_mulai_menit ?></span> -
                     <span id="data_pulang_akhir_jam"><?= $pulang_akhir_jam ?></span>:<span id="data_pulang_akhir_menit"><?= $pulang_akhir_menit ?></span>
                  </h3>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="pulang_mulai">
                              Pulang mulai
                              <i class="la la-question-circle" data-tooltip="tooltip" title="Absen pulang dilakukan pada saat atau sesudah jam sekian"></i>
                              <span></span>
                           </label>
                           <div class="row">
                              <div class="col-6 pr-2">
                                 <select name="pulang_mulai_jam" id="pulang_mulai_jam" class="custom-select custom-select2 border-0" required>
                                    <?php
                                    for ($i = 0; $i <= 23; $i++) {
                                       if ($i < 10) {
                                          $i = '0' . $i;
                                       }
                                       if ($masuk_akhir_jam <= $i) {
                                          if ($pulang_mulai_jam == $i) {
                                             echo '<option selected="">' . $i . '</option>';
                                          } else {
                                             echo '<option>' . $i . '</option>';
                                          }
                                       }
                                    } ?>
                                 </select>
                              </div>
                              <div class="col-6 pl-2">
                                 <select name="pulang_mulai_menit" id="pulang_mulai_menit" class="custom-select custom-select2 border-0" required>
                                    <?php
                                    for ($i = 0; $i <= 59; $i++) {
                                       if ($i < 10) {
                                          $i = '0' . $i;
                                       }
                                       if ($pulang_mulai_menit == $i) {
                                          echo '<option selected="">' . $i . '</option>';
                                       } else {
                                          echo '<option>' . $i . '</option>';
                                       }
                                    } ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="pulang_akhir">
                              Pulang akhir
                              <i class="la la-question-circle" data-tooltip="tooltip" title="Batas waktu melakukan absen pulang pada jam sekian"></i>
                              <span></span>
                           </label>
                           <div class="row">
                              <div class="col-6 pr-2">
                                 <select name="pulang_akhir_jam" id="pulang_akhir_jam" class="custom-select custom-select2 border-0" required>
                                    <?php
                                    for ($i = 0; $i <= 23; $i++) {
                                       if ($i < 10) {
                                          $i = '0' . $i;
                                       }
                                       if ($pulang_mulai_jam <= $i) {
                                          if ($pulang_akhir_jam == $i) {
                                             echo '<option selected="">' . $i . '</option>';
                                          } else {
                                             echo '<option>' . $i . '</option>';
                                          }
                                       }
                                    } ?>
                                 </select>
                              </div>
                              <div class="col-6 pl-2">
                                 <select name="pulang_akhir_menit" id="pulang_akhir_menit" class="custom-select custom-select2 border-0" required>
                                    <?php
                                    for ($i = 0; $i <= 59; $i++) {
                                       if ($i < 10) {
                                          $i = '0' . $i;
                                       }
                                       if ($pulang_akhir_menit == $i) {
                                          echo '<option selected="">' . $i . '</option>';
                                       } else {
                                          echo '<option>' . $i . '</option>';
                                       }
                                    } ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group mt-4">
            <div class="custom-control custom-switch">
               <input type="hidden" name="notif_absen_telegram" id="notif_absen_telegram" value="<?= $tb_kelas['notif_absen_telegram'] ?>">
               <input type="checkbox" class="custom-control-input" id="checkbox_notif_absen_telegram" <?php if ($tb_kelas['notif_absen_telegram'] == 'Y') {
                                                                                                         echo 'checked';
                                                                                                      } ?>>
               <label class="custom-control-label" for="checkbox_notif_absen_telegram">Notifikasi absen telegram</label>
               <p>Jika siswa melakukan absen, grup absensi di telegram akan menerima notifikasi. Jika diaktifkan, bisa jadi siswa lebih lambat untuk mengakses absen</p>
            </div>
         </div>
      </div>
      <div class="card-footer text-right">
         <button type="submit" class="btn btn-linear-primary waves-effect waves-light">
            Simpan
         </button>
      </div>
   </form>
</div>

<script>
   $('#formEditKelas').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi-edit',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               $('#content').load('daftar-kelas');
            } else if (data == 'tidak tersedia') {
               pesan('Kelas kamu tidak tersedia', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });

   $('#checkbox_notif_absen_telegram').click(function() {
      if ($(this).prop("checked") == true) {
         $('#notif_absen_telegram').val('Y');
         $('.formHargaSilang').removeClass('d-none');
      } else if ($(this).prop("checked") == false) {
         $('#notif_absen_telegram').val('N');
         $('.formHargaSilang').addClass('d-none');
      }
   });

   $('.kembali').click(function() {
      setTimeout(function() {
         $('#content').load('daftar-kelas');
      }, 300);
   });

   $('[data-tooltip="tooltip"]').tooltip();

   $('#masuk_mulai_jam').change(function() {
      var data = $(this).val();
      $('#data_masuk_mulai_jam').html(data);

      $('#masuk_akhir_jam').html('<option value="">Jam</option>');
      for (i = 0; i <= 23; i++) {
         var i = i < 10 ? '0' + i : i;
         if (data <= i) {
            $('#masuk_akhir_jam').append('<option>' + i + '</option>');
         }
      }
      $('#data_masuk_akhir_jam').html('--');
      $('#data_pulang_mulai_jam').html('--');
      $('#data_pulang_akhir_jam').html('--');
      $('#pulang_mulai_jam').html('<option value="">Jam</option>');
      $('#pulang_akhir_jam').html('<option value="">Jam</option>');
   });

   $('#masuk_mulai_menit').change(function() {
      var data = $('#data_masuk_mulai_menit').html($(this).val());
   });

   $('#masuk_akhir_jam').change(function() {
      var data = $(this).val();
      $('#data_masuk_akhir_jam').html(data);

      $('#pulang_mulai_jam').html('<option value="">Jam</option>');
      for (i = 0; i <= 23; i++) {
         var i = i < 10 ? '0' + i : i;
         if (data <= i) {
            $('#pulang_mulai_jam').append('<option>' + i + '</option>');
         }
      }
      $('#data_pulang_akhir_jam').html('--');
      $('#pulang_akhir_jam').html('<option value="">Jam</option>');
   });

   $('#masuk_akhir_menit').change(function() {
      var data = $('#data_masuk_akhir_menit').html($(this).val());
   });


   $('#pulang_mulai_jam').change(function() {
      var data = $(this).val();
      $('#data_pulang_mulai_jam').html(data);

      $('#pulang_akhir_jam').html('<option value="">Jam</option>');
      for (i = 0; i <= 23; i++) {
         var i = i < 10 ? '0' + i : i;
         if (data <= i) {
            $('#pulang_akhir_jam').append('<option>' + i + '</option>');
         }
      }
      $('#data_pulang_akhir_jam').html('--');
   });

   $('#pulang_mulai_menit').change(function() {
      var data = $('#data_pulang_mulai_menit').html($(this).val());
   });

   $('#pulang_akhir_jam').change(function() {
      var data = $('#data_pulang_akhir_jam').html($(this).val());
   });

   $('#pulang_akhir_menit').change(function() {
      var data = $('#data_pulang_akhir_menit').html($(this).val());
   });
</script>