<?php require "../config.php"; ?>

<div class="content-title">Buat kelas</div>
<form id="formBuatKelas">
   <div class="card">
      <div class="card-body">
         <div class="form-group">
            <label for="kelas">Kelas jurusan <span></span></label>
            <input type="text" name="kelas" id="kelas" class="form-control form-control4" placeholder="Contoh: X TKJ" required>
         </div>
         <div class="row">
            <div class="col-md-6">
               <div class="p-4 my-2 my-md-0 b-radius-10px bg-warning shadow-lg">
                  <p class="text-center mb-0 text-white">ABSEN MASUK</p>
                  <h3 class="text-center text-white">
                     <span id="data_masuk_mulai_jam">--</span>:<span id="data_masuk_mulai_menit">--</span> -
                     <span id="data_masuk_akhir_jam">--</span>:<span id="data_masuk_akhir_menit">--</span>
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
                                    echo '<option value="">Jam</option>';
                                    for ($i = 0; $i <= 23; $i++) {
                                       if ($i < 10) {
                                          $i = '0' . $i;
                                       }
                                       echo '<option>' . $i . '</option>';
                                    } ?>
                                 </select>
                              </div>
                              <div class="col-6 pl-2">
                                 <select name="masuk_mulai_menit" id="masuk_mulai_menit" class="custom-select custom-select2 border-0 menit" required></select>
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
                                    <option value="">Jam</option>
                                 </select>
                              </div>
                              <div class="col-6 pl-2">
                                 <select name="masuk_akhir_menit" id="masuk_akhir_menit" class="custom-select custom-select2 border-0 menit" required></select>
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
                     <span id="data_pulang_mulai_jam">--</span>:<span id="data_pulang_mulai_menit">--</span> -
                     <span id="data_pulang_akhir_jam">--</span>:<span id="data_pulang_akhir_menit">--</span>
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
                                    <option value="">Jam</option>
                                 </select>
                              </div>
                              <div class="col-6 pl-2">
                                 <select name="pulang_mulai_menit" id="pulang_mulai_menit" class="custom-select custom-select2 border-0 menit" required></select>
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
                                    <option value="">Jam</option>
                                 </select>
                              </div>
                              <div class="col-6 pl-2">
                                 <select name="pulang_akhir_menit" id="pulang_akhir_menit" class="custom-select custom-select2 border-0 menit" required></select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card-footer text-right">
         <button type="submit" class="btn btn-linear-primary waves-effect waves-light">
            Simpan
         </button>
      </div>
   </div>
</form>

<script>
   $('#formBuatKelas').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi-tambah?tambah_kelas',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               $('#notif-absen-baru').removeAttr('hidden', 'hidden');
               pesan('Data berhasil disimpan', 3000);
               document.getElementById('formBuatKelas').reset();
            } else if (data == 'tidak tersedia') {
               pesan('Kelas kamu tidak tersedia', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });

   $('.menit').html('<option value="">Menit</option>');
   for (i = 0; i <= 59; i++) {
      var i = i < 10 ? '0' + i : i;
      $('.menit').append('<option>' + i + '</option>');
   }


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

   $('[data-tooltip="tooltip"]').tooltip();
</script>