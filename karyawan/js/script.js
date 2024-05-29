setInterval(function () {
   if (navigator.onLine == false) {
      $('.modal').modal('hide');
      $('#modalNavigatorOnline').modal('show');
   } else {
      $('#modalNavigatorOnline').modal('hide');
   }
}, 10000);

$(function () {
   $('.overlay-scrollbars').overlayScrollbars({
      className: "os-theme-dark",
      scrollbars: {
         autoHide: 'l',
         autoHideDelay: 0
      }
   });
});

$('[data-tooltip="tooltip"]').tooltip();

$('#click-tema-terang').hide();
$('#click-tema-gelap').click(function () {
   $('.topbar').addClass('tema-gelap');
   $('.menu-utama').addClass('tema-gelap');
   $('.copyright').addClass('tema-gelap');
   $(this).hide();
   $('#click-tema-terang').show();
});

$('#click-tema-terang').click(function () {
   $('.topbar').removeClass('tema-gelap');
   $('.menu-utama').removeClass('tema-gelap');
   $('.copyright').removeClass('tema-gelap');
   $('.info-waktu-warning').removeClass('tema-gelap');
   $('.info-waktu-danger').removeClass('tema-gelap');
   $(this).hide();
   $('#click-tema-gelap').show();
});

$('.click-logout').click(function () {
   loader(500);
   setTimeout(function () {
      window.location.href = '../logout';
   }, 500);
});

$('#click-absen-masuk').click(function () {
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

$('#formAbsenMasuk').submit(function (e) {
   Webcam.snap(function (data_uri) {
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
      success: function (data) {
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

$('#click-absen-pulang').click(function () {
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

$('#formAbsenPulang').submit(function (e) {
   Webcam.snap(function (data_uri) {
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
      success: function (data) {
         if (data == 'berhasil') {
            window.location.href = 'terimakasih';
         } else {
            pesan('Terdapat kesalahan pada sistem!', 3000);
            $('#click-absen-pulang').removeAttr('disabled', 'disabled');
            $('#click-absen-pulang').html('Pulang');
         }
      }
   });
})

$('.click-profil').click(function () {
   window.location.href = 'profil';
})

$('#btn-radio-hadir').click(function () {
   $('#m_ket').html('Hadir');
});

$('#btn-radio-izin, #btn-radio-sakit').click(function () {
   $('#m_ket').html('');
});