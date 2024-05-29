<?php
require "../config.php";
$m_bulan_tahun = $_POST['m_bulan_tahun'];
$result = mysqli_query($conn, "SELECT * FROM a_masuk_guru am JOIN tb_guru s ON am . id_guru = s . id_guru WHERE am . m_bulan_tahun = '$m_bulan_tahun' ORDER BY s . nama ASC");

$m_bulan = explode('-', $m_bulan_tahun)[0];
$m_tahun = explode('-', $m_bulan_tahun)[1];
$jml_hari = jml_hari($m_bulan, $m_tahun);

$no = 1;
foreach ($result as $a_masuk_guru) { ?>
   <tr class="text-uppercase">
      <td><?= $no++ ?></td>
      <td class="text-left"><?= $a_masuk_guru['nama'] ?></td>

      <?php
         for ($i = 1; $i <= $jml_hari; $i++) {
            if ($i < 10) {
               $i = 0 . $i;
            }


            if (!empty($a_masuk_guru[$i])) {
               $a_masukket_guru = query("SELECT * FROM a_masukket_guru WHERE token_masuk = '$a_masuk_guru[$i]'");
               echo '<td class="cursor-pointer info-masuk" data-token_masuk="' . $a_masuk_guru[$i] . '" data-id_guru="' . $a_masuk_guru['id_guru'] . '">';
               if ($a_masukket_guru['m_alasan'] == 'hadir') {
                  echo '<i class="fa fa-circle text-success"></i>';
               } elseif ($a_masukket_guru['m_alasan'] == 'izin') {
                  echo '<i class="fa fa-circle text-warning"></i>';
               } elseif ($a_masukket_guru['m_alasan'] == 'sakit') {
                  echo '<i class="fa fa-circle text-danger"></i>';
               }
               echo '</td>';
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