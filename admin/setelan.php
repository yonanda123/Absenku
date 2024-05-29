<?php require "../config.php"; ?>

<div class="row">
   <div class="col-md-6">
      <div class="card">
         <div class="card-header">
            <h5 class="text-center">Setelan</h5>
         </div>
         <div class="card-body">
            <form id="formSetelan">
               <div class="form-group">
                  <label for="nama">Nama aplikasi <span></span></label>
                  <input type="text" name="nama" id="nama" class="form-control form-control2" value="<?= $tb_setelan['nama'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="base_url">Base URL <span></span></label>
                  <input type="text" name="base_url" id="base_url" class="form-control form-control2" value="<?= base_url() ?>" required>
               </div>
               <div class="form-group">
                  <label for="chat_id_group">Chat ID Group <span></span></label>
                  <input type="text" name="chat_id_group" id="chat_id_group" class="form-control form-control2" value="<?= $tb_setelan['chat_id_group'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="token_bot">Token Bot <span></span></label>
                  <input type="text" name="token_bot" id="token_bot" class="form-control form-control2" value="<?= $tb_setelan['token_bot'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="url_telegram_group">URL Telegram Group <span></span></label>
                  <input type="text" name="url_telegram_group" id="url_telegram_group" class="form-control form-control2" value="<?= $tb_setelan['url_telegram_group'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="api_maps">API Google Maps <span></span></label>
                  <input type="text" name="api_maps" id="api_maps" class="form-control form-control2" value="<?= $tb_setelan['api_maps'] ?>" required>
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light">
                     Simpan
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="card">
         <div class="card-header">
            <h5 class="text-center">Ubah password</h5>
         </div>
         <div class="card-body">
            <form id="formAdmin">
               <div class="form-group">
                  <label for="username">Username <span></span></label>
                  <input type="text" name="username" id="username" class="form-control form-control2" value="<?= $tb_admin['username'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="password_lama">Password lama <span></span></label>
                  <input type="password" name="password_lama" id="password_lama" class="form-control form-control2" placeholder="*****" required>
               </div>
               <div class="row">
                  <div class="col-md-6 pr-md-2">
                     <div class="form-group">
                        <label for="password1">Password baru <span></span></label>
                        <input type="password" name="password1" id="password1" class="form-control form-control2" placeholder="*****" required>
                     </div>
                  </div>
                  <div class="col-md-6 pl-md-2">
                     <div class="form-group">
                        <label for="password2">Konfirmasi <span></span></label>
                        <input type="password" name="password2" id="password2" class="form-control form-control2" placeholder="*****" required>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light">
                     Simpan
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   $('#formSetelan').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: '../guru/aksi-edit?edit_setelan',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               $('#content').load('setelan');
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });

   $('#formAdmin').submit(function(e) {
      if ($('#password1').val() !== $('#password2').val()) {
         pesan('Konfirmasi password salah', 3000);
         return false;
      }
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: '../guru/aksi-edit?edit_admin',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               $('#content').load('setelan');
            } else if (data == 'password lama') {
               pesan('Password lama salah', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });
</script>