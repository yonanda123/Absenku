<?php
require "../config.php";
if ($_POST['what_rekap'] == 'Siswa') {
   $token_kelas = $_POST['token_kelas'];
   $m_bulan_tahun = $_POST['m_bulan_tahun'];
   $result_a_masuk = mysqli_query($conn, "SELECT * FROM a_masuk am JOIN tb_siswa s ON am . id_siswa = s . id_siswa WHERE am . m_bulan_tahun = '$m_bulan_tahun' && am . token_kelas = '$token_kelas' ORDER BY s . nama_depan,nama_belakang ASC");
   $result_a_pulang = mysqli_query($conn, "SELECT * FROM a_pulang ap JOIN tb_siswa s ON ap . id_siswa = s . id_siswa WHERE ap . p_bulan_tahun = '$m_bulan_tahun' && ap . token_kelas = '$token_kelas' ORDER BY s . nama_depan,nama_belakang ASC");

   $tb_kelas = query("SELECT id_guru,kelas,token_kelas FROM tb_kelas WHERE token_kelas = '$token_kelas'");
   $tb_guru = query("SELECT id_guru,nama FROM tb_guru WHERE id_guru = '$tb_kelas[id_guru]'");

   $m_bulan = explode('-', $m_bulan_tahun)[0];
   $m_tahun = explode('-', $m_bulan_tahun)[1];
   $jml_hari = jml_hari($m_bulan, $m_tahun); ?>
   <style>
      td,
      th {
         text-align: center;
         text-transform: uppercase;
      }
   </style>
   <table cellpadding="5" cellspacing="0">
      <tr>
         <td class="text-left">Kelas</td>
         <td>:</td>
         <td class="text-left"><?= $tb_kelas['kelas'] ?></td>
      </tr>
      <tr>
         <td class="text-left">Waktu</td>
         <td>:</td>
         <td class="text-left"><?= bulan($m_bulan) . ' ' . $m_tahun ?></td>
      </tr>
      <tr>
         <td class="text-left">Wali kelas</td>
         <td>:</td>
         <td class="text-left"><?= $tb_guru['nama'] ?></td>
      </tr>
      <tr>
         <td class="text-left">Keterangan</td>
         <td>:</td>
         <td class="text-left">H = HADIR, I = IZIN, S = SAKIT, P = PULANG</td>
      </tr>
   </table>
   <div class="text-center my-4">
      <button type="button" class="btn btn-excel btn-lg border-0 waves-effect waves-light" id="click-export-excel" data-file_name="<?= 'REKAP ABSEN KELAS ' . $tb_kelas['kelas'] . ' BULAN ' . bulan($m_bulan) . ' ' . $m_tahun ?>">
         <i class="fa fa-file-excel fa-fw"></i> Export Absen
      </button>
   </div>
   <div class="label-menu">
      absen masuk siswa
   </div>
   <div class="table-responsive mt-4 overlay-scrollbars">
      <table class="table table-bordered table-hover">
         <thead>
            <tr>
               <th rowspan="2">No</th>
               <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
               <th colspan="<?= $jml_hari ?>">Tanggal</th>
               <th rowspan="2">Hadir</th>
               <th rowspan="2">Izin</th>
               <th rowspan="2">Sakit</th>
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
         <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result_a_masuk) !== 0) {
               foreach ($result_a_masuk as $a_masuk) { ?>
                  <tr class="text-uppercase">
                     <td><?= $no++ ?></td>
                     <td class="text-left"><?= $a_masuk['nama_depan'] . ' ' . $a_masuk['nama_belakang'] ?></td>
                     <?php
                     for ($i = 1; $i <= $jml_hari; $i++) {
                        if ($i < 10) {
                           $i = 0 . $i;
                        }

                        if (!empty($a_masuk[$i])) {
                           $a_masukket = query("SELECT * FROM a_masukket WHERE token_masuk = '$a_masuk[$i]'");
                           if ($a_masukket['m_alasan'] == 'hadir') {
                              echo '<td class="bg-success text-white">H ' . date('H:i', $a_masukket["m_pada"]) . '</td>';
                           } elseif ($a_masukket['m_alasan'] == 'izin') {
                              echo '<td class="bg-warning text-white">I ' . date('H:i', $a_masukket["m_pada"]) . '</td>';
                           } elseif ($a_masukket['m_alasan'] == 'sakit') {
                              echo '<td class="bg-danger text-white">S ' . date('H:i', $a_masukket["m_pada"]) . '</td>';
                           }
                        } else {
                           echo '<td></td>';
                        }
                     } ?>
                     <td><?= $a_masuk['hadir'] ?></td>
                     <td><?= $a_masuk['izin'] ?></td>
                     <td><?= $a_masuk['sakit'] ?></td>
                  </tr>
               <?php }
            } else { ?>
               <tr>
                  <td class="text-lowercase" colspan="<?= $jml_hari + 2 ?>">tidak ada data yang ditampilkan</td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>

   <div class="label-menu mt-5">
      absen pulang siswa
   </div>
   <div class="table-responsive mt-4 overlay-scrollbars">
      <table class="table table-bordered table-hover">
         <thead>
            <tr>
               <th rowspan="2">No</th>
               <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
               <th colspan="<?= $jml_hari ?>">Tanggal</th>
               <th rowspan="2">Pulang</th>
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
         <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result_a_pulang) !== 0) {
               foreach ($result_a_pulang as $a_pulang) { ?>
                  <tr class="text-uppercase">
                     <td><?= $no++ ?></td>
                     <td class="text-left"><?= $a_pulang['nama_depan'] . ' ' . $a_pulang['nama_belakang'] ?></td>

                     <?php
                     for ($i = 1; $i <= $jml_hari; $i++) {
                        if ($i < 10) {
                           $i = 0 . $i;
                        }

                        if (!empty($a_pulang[$i])) {
                           $a_pulangket = query("SELECT * FROM a_pulangket WHERE token_pulang = '$a_pulang[$i]'");
                           echo '<td class="bg-success text-white">P ' . date('H:i', $a_pulangket["p_pada"]) . '</td>';
                        } else {
                           echo '<td></td>';
                        }
                     } ?>
                     <td><?= $a_pulang['pulang'] ?></td>
                  </tr>
               <?php }
            } else { ?>
               <tr>
                  <td class="text-lowercase" colspan="<?= $jml_hari + 2 ?>">tidak ada data yang ditampilkan</td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>

   <table class="table2excel d-none" border="1">
      <tr>
         <td colspan="<?= $jml_hari + 2 ?>">KELAS: <?= $tb_kelas['kelas'] ?></td>
      </tr>
      <tr>
         <td colspan="<?= $jml_hari + 2 ?>">WAKTU: <?= bulan($m_bulan) . ' ' . $m_tahun ?></td>
      </tr>
      <tr>
         <td colspan="<?= $jml_hari + 2 ?>">WALI KELAS: <?= $tb_guru['nama'] ?></td>
      </tr>
      <tr>
         <td colspan="<?= $jml_hari + 2 ?>">KETERANGAN: H = HADIR, I = IZIN, S = SAKIT, P = PULANG</td>
      </tr>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th colspan="<?= $jml_hari + 2 ?>">ABSEN MASUK SISWA</th>
      </tr>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th rowspan="2">No</th>
         <th rowspan="2">Nama</th>
         <th colspan="<?= $jml_hari ?>">Tanggal</th>
         <th rowspan="2">Hadir</th>
         <th rowspan="2">Izin</th>
         <th rowspan="2">Sakit</th>
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
      <?php
      $no = 1;
      foreach ($result_a_masuk as $a_masuk) { ?>
         <tr>
            <td><?= $no++ ?></td>
            <td><?= $a_masuk['nama_depan'] . ' ' . $a_masuk['nama_belakang'] ?></td>
            <?php
            for ($i = 1; $i <= $jml_hari; $i++) {
               if ($i < 10) {
                  $i = 0 . $i;
               }

               if (!empty($a_masuk[$i])) {
                  $a_masukket = query("SELECT * FROM a_masukket WHERE token_masuk = '$a_masuk[$i]'");
                  if ($a_masukket['m_alasan'] == 'hadir') {
                     echo '<td style="background: green; color: white;">H ' . date('H:i', $a_masukket["m_pada"]) . '</td>';
                  } elseif ($a_masukket['m_alasan'] == 'izin') {
                     echo '<td style="background: yellow; color: black">I ' . date('H:i', $a_masukket["m_pada"]) . '</td>';
                  } elseif ($a_masukket['m_alasan'] == 'sakit') {
                     echo '<td style="background: red; color: white">S ' . date('H:i', $a_masukket["m_pada"]) . '</td>';
                  }
                  echo '</td>';
               } else {
                  echo '<td></td>';
               }
            } ?>
            <td><?= $a_masuk['hadir'] ?></td>
            <td><?= $a_masuk['izin'] ?></td>
            <td><?= $a_masuk['sakit'] ?></td>
         </tr>
      <?php } ?>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th colspan="<?= $jml_hari + 2 ?>">ABSEN PULANG SISWA</th>
      </tr>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th rowspan="2">No</th>
         <th rowspan="2">Nama</th>
         <th colspan="<?= $jml_hari ?>">Tanggal</th>
         <th rowspan="2">Pulang</th>
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
      <?php
      $no = 1;
      foreach ($result_a_pulang as $a_pulang) { ?>
         <tr>
            <td><?= $no++ ?></td>
            <td><?= $a_pulang['nama_depan'] . ' ' . $a_pulang['nama_belakang'] ?></td>

            <?php
            for ($i = 1; $i <= $jml_hari; $i++) {
               if ($i < 10) {
                  $i = 0 . $i;
               }

               if (!empty($a_pulang[$i])) {
                  $a_pulangket = query("SELECT * FROM a_pulangket WHERE token_pulang = '$a_pulang[$i]'");
                  echo '<td style="background: green; color: white;">P ' . date('H:i', $a_pulangket["p_pada"]) . '</td>';
               } else {
                  echo '<td></td>';
               }
            } ?>
            <td><?= $a_pulang['pulang'] ?></td>
         </tr>
      <?php } ?>
   </table>

   <script>
      $(function() {
         $('#click-export-excel').click(function() {
            var file_name = $(this).attr('data-file_name');
            $(".table2excel").table2excel({
               exclude: ".noExl",
               name: "Excel Document Name",
               filename: file_name,
               fileext: ".xls",
               exclude_img: true,
               exclude_links: true,
               exclude_inputs: true
            });
         });
      });
   </script>

<?php } elseif ($_POST['what_rekap'] == 'Guru') {

   $m_bulan_tahun = $_POST['m_bulan_tahun'];
   $result_a_masuk_guru = mysqli_query($conn, "SELECT * FROM a_masuk_guru am JOIN tb_guru s ON am . id_guru = s . id_guru WHERE am . m_bulan_tahun = '$m_bulan_tahun' ORDER BY s . nama ASC");
   $result_a_pulang_guru = mysqli_query($conn, "SELECT * FROM a_pulang_guru ap JOIN tb_guru s ON ap . id_guru = s . id_guru WHERE ap . p_bulan_tahun = '$m_bulan_tahun' ORDER BY s . nama ASC");

   $m_bulan = explode('-', $m_bulan_tahun)[0];
   $m_tahun = explode('-', $m_bulan_tahun)[1];
   $jml_hari = jml_hari($m_bulan, $m_tahun); ?>
   <style>
      td,
      th {
         text-align: center;
         text-transform: uppercase;
      }
   </style>
   <table cellpadding="5" cellspacing="0">
      <tr>
         <td class="text-left">Waktu</td>
         <td>:</td>
         <td class="text-left"><?= bulan($m_bulan) . ' ' . $m_tahun ?></td>
      </tr>
      <tr>
         <td class="text-left">Keterangan</td>
         <td>:</td>
         <td class="text-left">H = HADIR, I = IZIN, S = SAKIT, P = PULANG</td>
      </tr>
   </table>
   <div class="text-center my-4">
      <button type="button" class="btn btn-excel btn-lg border-0 waves-effect waves-light" id="click-export-excel-guru" data-file_name="<?= 'REKAP ABSEN GURU BULAN ' . bulan($m_bulan) . ' ' . $m_tahun ?>">
         <i class="fa fa-file-excel fa-fw"></i> Export Absen
      </button>
   </div>
   <div class="label-menu">
      absen masuk guru
   </div>
   <div class="table-responsive mt-4 overlay-scrollbars">
      <table class="table table-bordered table-hover">
         <thead>
            <tr>
               <th rowspan="2">No</th>
               <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
               <th colspan="<?= $jml_hari ?>">Tanggal</th>
               <th rowspan="2">Hadir</th>
               <th rowspan="2">Izin</th>
               <th rowspan="2">Sakit</th>
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
         <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result_a_masuk_guru) !== 0) {
               foreach ($result_a_masuk_guru as $a_masuk) { ?>
                  <tr class="text-uppercase">
                     <td><?= $no++ ?></td>
                     <td class="text-left"><?= $a_masuk['nama']  ?></td>
                     <?php
                     for ($i = 1; $i <= $jml_hari; $i++) {
                        if ($i < 10) {
                           $i = 0 . $i;
                        }

                        if (!empty($a_masuk[$i])) {
                           $a_masukket_guru = query("SELECT * FROM a_masukket_guru WHERE token_masuk = '$a_masuk[$i]'");
                           if ($a_masukket_guru['m_alasan'] == 'hadir') {
                              echo '<td class="bg-success text-white">H ' . date('H:i', $a_masukket_guru["m_pada"]) . '</td>';
                           } elseif ($a_masukket_guru['m_alasan'] == 'izin') {
                              echo '<td class="bg-warning text-white">I ' . date('H:i', $a_masukket_guru["m_pada"]) . '</td>';
                           } elseif ($a_masukket_guru['m_alasan'] == 'sakit') {
                              echo '<td class="bg-danger text-white">S ' . date('H:i', $a_masukket_guru["m_pada"]) . '</td>';
                           }
                        } else {
                           echo '<td></td>';
                        }
                     } ?>
                     <td><?= $a_masuk['hadir'] ?></td>
                     <td><?= $a_masuk['izin'] ?></td>
                     <td><?= $a_masuk['sakit'] ?></td>
                  </tr>
               <?php }
            } else { ?>
               <tr>
                  <td class="text-lowercase" colspan="<?= $jml_hari + 2 ?>">tidak ada data yang ditampilkan</td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>

   <div class="label-menu mt-5">
      absen pulang guru
   </div>
   <div class="table-responsive mt-4 overlay-scrollbars">
      <table class="table table-bordered table-hover">
         <thead>
            <tr>
               <th rowspan="2">No</th>
               <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
               <th colspan="<?= $jml_hari ?>">Tanggal</th>
               <th rowspan="2">Pulang</th>
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
         <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result_a_pulang_guru) !== 0) {
               foreach ($result_a_pulang_guru as $a_pulang) { ?>
                  <tr class="text-uppercase">
                     <td><?= $no++ ?></td>
                     <td class="text-left"><?= $a_pulang['nama'] ?></td>

                     <?php
                     for ($i = 1; $i <= $jml_hari; $i++) {
                        if ($i < 10) {
                           $i = 0 . $i;
                        }

                        if (!empty($a_pulang[$i])) {
                           $a_pulangket_guru = query("SELECT * FROM a_pulangket_guru WHERE token_pulang = '$a_pulang[$i]'");
                           echo '<td class="bg-success text-white">P ' . date('H:i', $a_pulangket_guru["p_pada"]) . '</td>';
                        } else {
                           echo '<td></td>';
                        }
                     } ?>
                     <td><?= $a_pulang['pulang'] ?></td>
                  </tr>
               <?php }
            } else { ?>
               <tr>
                  <td class="text-lowercase" colspan="<?= $jml_hari + 2 ?>">tidak ada data yang ditampilkan</td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>

   <table class="table2excel d-none" border="1">
      <tr>
         <td colspan="<?= $jml_hari + 5 ?>">WAKTU: <?= bulan($m_bulan) . ' ' . $m_tahun ?></td>
      </tr>
      <tr>
         <td colspan="<?= $jml_hari + 5 ?>">KETERANGAN: H = HADIR, I = IZIN, S = SAKIT, P = PULANG</td>
      </tr>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th colspan="<?= $jml_hari + 5 ?>">ABSEN MASUK GURU</th>
      </tr>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th rowspan="2">No</th>
         <th rowspan="2">Nama</th>
         <th colspan="<?= $jml_hari ?>">Tanggal</th>
         <th rowspan="2">Hadir</th>
         <th rowspan="2">Izin</th>
         <th rowspan="2">Sakit</th>
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
      <?php
      $no = 1;
      foreach ($result_a_masuk_guru as $a_masuk) { ?>
         <tr>
            <td><?= $no++ ?></td>
            <td><?= $a_masuk['nama'] ?></td>
            <?php
            for ($i = 1; $i <= $jml_hari; $i++) {
               if ($i < 10) {
                  $i = 0 . $i;
               }

               if (!empty($a_masuk[$i])) {
                  $a_masukket_guru = query("SELECT * FROM a_masukket_guru WHERE token_masuk = '$a_masuk[$i]'");
                  if ($a_masukket_guru['m_alasan'] == 'hadir') {
                     echo '<td style="background: green; color: white;">H ' . date('H:i', $a_masukket_guru["m_pada"]) . '</td>';
                  } elseif ($a_masukket_guru['m_alasan'] == 'izin') {
                     echo '<td style="background: yellow; color: black">I ' . date('H:i', $a_masukket_guru["m_pada"]) . '</td>';
                  } elseif ($a_masukket_guru['m_alasan'] == 'sakit') {
                     echo '<td style="background: red; color: white">S ' . date('H:i', $a_masukket_guru["m_pada"]) . '</td>';
                  }
                  echo '</td>';
               } else {
                  echo '<td></td>';
               }
            } ?>
            <td><?= $a_masuk['hadir'] ?></td>
            <td><?= $a_masuk['izin'] ?></td>
            <td><?= $a_masuk['sakit'] ?></td>
         </tr>
      <?php } ?>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th colspan="<?= $jml_hari + 3 ?>">ABSEN PULANG GURU</th>
      </tr>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th rowspan="2">No</th>
         <th rowspan="2">Nama</th>
         <th colspan="<?= $jml_hari ?>">Tanggal</th>
         <th rowspan="2">Pulang</th>
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
      <?php
      $no = 1;
      foreach ($result_a_pulang_guru as $a_pulang) { ?>
         <tr>
            <td><?= $no++ ?></td>
            <td><?= $a_pulang['nama'] ?></td>

            <?php
            for ($i = 1; $i <= $jml_hari; $i++) {
               if ($i < 10) {
                  $i = 0 . $i;
               }

               if (!empty($a_pulang[$i])) {
                  $a_pulangket_guru = query("SELECT * FROM a_pulangket_guru WHERE token_pulang = '$a_pulang[$i]'");
                  echo '<td style="background: green; color: white;">P ' . date('H:i', $a_pulangket_guru["p_pada"]) . '</td>';
               } else {
                  echo '<td></td>';
               }
            } ?>
            <td><?= $a_pulang['pulang'] ?></td>
         </tr>
      <?php } ?>
   </table>

   <script>
      $(function() {
         $('#click-export-excel-guru').click(function() {
            var file_name = $(this).attr('data-file_name');
            $(".table2excel").table2excel({
               exclude: ".noExl",
               name: "Excel Document Name",
               filename: file_name,
               fileext: ".xls",
               exclude_img: true,
               exclude_links: true,
               exclude_inputs: true
            });
         });
      });
   </script>

<?php } elseif ($_POST['what_rekap'] == 'Karyawan') {

   $m_bulan_tahun = $_POST['m_bulan_tahun'];
   $result_a_masuk_karyawan = mysqli_query($conn, "SELECT * FROM a_masuk_karyawan am JOIN tb_karyawan s ON am . id_karyawan = s . id_karyawan JOIN tb_jabatan tj ON s . id_jabatan = tj . id_jabatan WHERE am . m_bulan_tahun = '$m_bulan_tahun' ORDER BY s . nama ASC");
   $result_a_pulang_karyawan = mysqli_query($conn, "SELECT * FROM a_pulang_karyawan ap JOIN tb_karyawan s ON ap . id_karyawan = s . id_karyawan JOIN tb_jabatan tj ON s . id_jabatan = tj . id_jabatan WHERE ap . p_bulan_tahun = '$m_bulan_tahun' ORDER BY s . nama ASC");

   $m_bulan = explode('-', $m_bulan_tahun)[0];
   $m_tahun = explode('-', $m_bulan_tahun)[1];
   $jml_hari = jml_hari($m_bulan, $m_tahun); ?>
   <style>
      td,
      th {
         text-align: center;
         text-transform: uppercase;
      }
   </style>
   <table cellpadding="5" cellspacing="0">
      <tr>
         <td class="text-left">Waktu</td>
         <td>:</td>
         <td class="text-left"><?= bulan($m_bulan) . ' ' . $m_tahun ?></td>
      </tr>
      <tr>
         <td class="text-left">Keterangan</td>
         <td>:</td>
         <td class="text-left">H = HADIR, I = IZIN, S = SAKIT, P = PULANG</td>
      </tr>
   </table>
   <div class="text-center my-4">
      <button type="button" class="btn btn-excel btn-lg border-0 waves-effect waves-light" id="click-export-excel-karyawan" data-file_name="<?= 'REKAP ABSEN KARYAWAN BULAN ' . bulan($m_bulan) . ' ' . $m_tahun ?>">
         <i class="fa fa-file-excel fa-fw"></i> Export Absen
      </button>
   </div>
   <div class="label-menu">
      absen masuk karyawan
   </div>
   <div class="table-responsive mt-4 overlay-scrollbars">
      <table class="table table-bordered table-hover">
         <thead>
            <tr>
               <th rowspan="2">No</th>
               <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
               <th rowspan="2" class="text-left" style="min-width: 350px;">Jabatan</th>
               <th colspan="<?= $jml_hari ?>">Tanggal</th>
               <th rowspan="2">Hadir</th>
               <th rowspan="2">Izin</th>
               <th rowspan="2">Sakit</th>
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
         <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result_a_masuk_karyawan) !== 0) {
               foreach ($result_a_masuk_karyawan as $a_masuk) { ?>
                  <tr class="text-uppercase">
                     <td><?= $no++ ?></td>
                     <td class="text-left"><?= $a_masuk['nama']  ?></td>
                     <td class="text-left"><?= $a_masuk['jabatan']  ?></td>
                     <?php
                     for ($i = 1; $i <= $jml_hari; $i++) {
                        if ($i < 10) {
                           $i = 0 . $i;
                        }

                        if (!empty($a_masuk[$i])) {
                           $a_masukket_karyawan = query("SELECT * FROM a_masukket_karyawan WHERE token_masuk = '$a_masuk[$i]'");
                           if ($a_masukket_karyawan['m_alasan'] == 'hadir') {
                              echo '<td class="bg-success text-white">H ' . date('H:i', $a_masukket_karyawan["m_pada"]) . '</td>';
                           } elseif ($a_masukket_karyawan['m_alasan'] == 'izin') {
                              echo '<td class="bg-warning text-white">I ' . date('H:i', $a_masukket_karyawan["m_pada"]) . '</td>';
                           } elseif ($a_masukket_karyawan['m_alasan'] == 'sakit') {
                              echo '<td class="bg-danger text-white">S ' . date('H:i', $a_masukket_karyawan["m_pada"]) . '</td>';
                           }
                        } else {
                           echo '<td></td>';
                        }
                     } ?>

                     <td><?= $a_masuk['hadir'] ?></td>
                     <td><?= $a_masuk['izin'] ?></td>
                     <td><?= $a_masuk['sakit'] ?></td>
                  </tr>
               <?php }
            } else { ?>
               <tr>
                  <td class="text-lowercase" colspan="<?= $jml_hari + 2 ?>">tidak ada data yang ditampilkan</td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>

   <div class="label-menu mt-5">
      absen pulang karyawan
   </div>
   <div class="table-responsive mt-4 overlay-scrollbars">
      <table class="table table-bordered table-hover">
         <thead>
            <tr>
               <th rowspan="2">No</th>
               <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
               <th rowspan="2" class="text-left" style="min-width: 350px;">Jabatan</th>
               <th colspan="<?= $jml_hari ?>">Tanggal</th>
               <th rowspan="2">Pulang</th>
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
         <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($result_a_pulang_karyawan) !== 0) {
               foreach ($result_a_pulang_karyawan as $a_pulang) { ?>
                  <tr class="text-uppercase">
                     <td><?= $no++ ?></td>
                     <td class="text-left"><?= $a_pulang['nama'] ?></td>
                     <td class="text-left"><?= $a_pulang['jabatan'] ?></td>

                     <?php
                     for ($i = 1; $i <= $jml_hari; $i++) {
                        if ($i < 10) {
                           $i = 0 . $i;
                        }

                        if (!empty($a_pulang[$i])) {
                           $a_pulangket_karyawan = query("SELECT * FROM a_pulangket_karyawan WHERE token_pulang = '$a_pulang[$i]'");
                           echo '<td class="bg-success text-white">P ' . date('H:i', $a_pulangket_karyawan["p_pada"]) . '</td>';
                        } else {
                           echo '<td></td>';
                        }
                     } ?>
                     <td><?= $a_pulang['pulang'] ?></td>
                  </tr>
               <?php }
            } else { ?>
               <tr>
                  <td class="text-lowercase" colspan="<?= $jml_hari + 2 ?>">tidak ada data yang ditampilkan</td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
   </div>

   <table class="table2excel d-none" border="1">
      <tr>
         <td colspan="<?= $jml_hari + 5 ?>">WAKTU: <?= bulan($m_bulan) . ' ' . $m_tahun ?></td>
      </tr>
      <tr>
         <td colspan="<?= $jml_hari + 5 ?>">KETERANGAN: H = HADIR, I = IZIN, S = SAKIT, P = PULANG</td>
      </tr>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th colspan="<?= $jml_hari + 5 ?>">ABSEN MASUK KARYAWAN</th>
      </tr>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th rowspan="2">No</th>
         <th rowspan="2">Nama</th>
         <th rowspan="2">Jabatan</th>
         <th colspan="<?= $jml_hari ?>">Tanggal</th>
         <th rowspan="2">Hadir</th>
         <th rowspan="2">Izin</th>
         <th rowspan="2">Sakit</th>
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
      <?php
      $no = 1;
      foreach ($result_a_masuk_karyawan as $a_masuk) { ?>
         <tr>
            <td><?= $no++ ?></td>
            <td><?= $a_masuk['nama'] ?></td>
            <td><?= $a_masuk['jabatan'] ?></td>
            <?php
            for ($i = 1; $i <= $jml_hari; $i++) {
               if ($i < 10) {
                  $i = 0 . $i;
               }

               if (!empty($a_masuk[$i])) {
                  $a_masukket_karyawan = query("SELECT * FROM a_masukket_karyawan WHERE token_masuk = '$a_masuk[$i]'");
                  if ($a_masukket_karyawan['m_alasan'] == 'hadir') {
                     echo '<td style="background: green; color: white;">H ' . date('H:i', $a_masukket_karyawan["m_pada"]) . '</td>';
                  } elseif ($a_masukket_karyawan['m_alasan'] == 'izin') {
                     echo '<td style="background: yellow; color: black">I ' . date('H:i', $a_masukket_karyawan["m_pada"]) . '</td>';
                  } elseif ($a_masukket_karyawan['m_alasan'] == 'sakit') {
                     echo '<td style="background: red; color: white">S ' . date('H:i', $a_masukket_karyawan["m_pada"]) . '</td>';
                  }
                  echo '</td>';
               } else {
                  echo '<td></td>';
               }
            } ?>
            <td><?= $a_masuk['hadir'] ?></td>
            <td><?= $a_masuk['izin'] ?></td>
            <td><?= $a_masuk['sakit'] ?></td>
         </tr>
      <?php } ?>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th colspan="<?= $jml_hari + 3 ?>">ABSEN PULANG KARYAWAN</th>
      </tr>
      <tr>
         <td></td>
      </tr>
      <tr>
         <th rowspan="2">No</th>
         <th rowspan="2">Nama</th>
         <th rowspan="2">Jabatan</th>
         <th colspan="<?= $jml_hari ?>">Tanggal</th>
         <th rowspan="2">Pulang</th>
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
      <?php
      $no = 1;
      foreach ($result_a_pulang_karyawan as $a_pulang) { ?>
         <tr>
            <td><?= $no++ ?></td>
            <td><?= $a_pulang['nama'] ?></td>
            <td><?= $a_pulang['jabatan'] ?></td>

            <?php
            for ($i = 1; $i <= $jml_hari; $i++) {
               if ($i < 10) {
                  $i = 0 . $i;
               }

               if (!empty($a_pulang[$i])) {
                  $a_pulangket_karyawan = query("SELECT * FROM a_pulangket_karyawan WHERE token_pulang = '$a_pulang[$i]'");
                  echo '<td style="background: green; color: white;">P ' . date('H:i', $a_pulangket_karyawan["p_pada"]) . '</td>';
               } else {
                  echo '<td></td>';
               }
            } ?>
            <td><?= $a_pulang['pulang'] ?></td>
         </tr>
      <?php } ?>
   </table>

   <script>
      $(function() {
         $('#click-export-excel-karyawan').click(function() {
            var file_name = $(this).attr('data-file_name');
            $(".table2excel").table2excel({
               exclude: ".noExl",
               name: "Excel Document Name",
               filename: file_name,
               fileext: ".xls",
               exclude_img: true,
               exclude_links: true,
               exclude_inputs: true
            });
         });
      });
   </script>

<?php } ?>

<script>
   $('.overlay-scrollbars').overlayScrollbars({
      className: "os-theme-dark",
      scrollbars: {
         autoHide: 'l',
         autoHideDelay: 0
      }
   });
</script>