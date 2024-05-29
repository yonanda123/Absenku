<?php
require "../config.php";
$p_bulan_tahun = $_POST['p_bulan_tahun'];
$result = mysqli_query($conn, "SELECT * FROM a_pulang_karyawan ap JOIN tb_karyawan k ON ap . id_karyawan = k . id_karyawan JOIN tb_jabatan tj ON k . id_jabatan = tj . id_jabatan WHERE ap . p_bulan_tahun = '$p_bulan_tahun' ORDER BY k . nama ASC");

$m_bulan = explode('-', $p_bulan_tahun)[0];
$m_tahun = explode('-', $p_bulan_tahun)[1];
$jml_hari = jml_hari($m_bulan, $m_tahun);

$no = 1;
foreach ($result as $a_pulang_karyawan) { ?>
   <tr class="text-uppercase">
      <td><?= $no++ ?></td>
      <td class="text-left"><?= $a_pulang_karyawan['nama'] ?></td>
      <td class="text-left"><?= $a_pulang_karyawan['jabatan'] ?></td>

      <?php
         for ($i = 1; $i <= $jml_hari; $i++) {
            if ($i < 10) {
               $i = 0 . $i;
            }


            if (!empty($a_pulang_karyawan[$i])) {
               echo '<td class="cursor-pointer info-pulang" data-token_pulang="' . $a_pulang_karyawan[$i] . '" data-id_karyawan="' . $a_pulang_karyawan['id_karyawan'] . '"><i class="fa fa-circle text-success"></i></td>';
            } else {
               echo '<td></td>';
            }
         } ?>
   </tr>
<?php }
if (mysqli_num_rows($result) == 0) { ?>
   <tr>
      <td colspan="<?= $jml_hari + 2 ?>" class="text-center">
         tidak ada data yang ditampilkan
      </td>
   </tr>
<?php } ?>