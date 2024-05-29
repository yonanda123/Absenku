<?php
require "../config.php";
$token_kelas = $_POST['token_kelas'];
$p_bulan_tahun = $_POST['p_bulan_tahun'];
$result = mysqli_query($conn, "SELECT * FROM a_pulang ap JOIN tb_siswa s ON ap . id_siswa = s . id_siswa WHERE ap . p_bulan_tahun = '$p_bulan_tahun' && ap . token_kelas = '$token_kelas' ORDER BY s . nama_depan,nama_belakang ASC");

$m_bulan = explode('-', $p_bulan_tahun)[0];
$m_tahun = explode('-', $p_bulan_tahun)[1];
$jml_hari = jml_hari($m_bulan, $m_tahun);

$no = 1;
foreach ($result as $a_pulang) { ?>
   <tr class="text-uppercase">
      <td><?= $no++ ?></td>
      <td class="text-left"><?= $a_pulang['nama_depan'] . ' ' . $a_pulang['nama_belakang'] ?></td>

      <?php
         for ($i = 1; $i <= $jml_hari; $i++) {
            if ($i < 10) {
               $i = 0 . $i;
            }

            if (!empty($a_pulang[$i])) {
               echo '<td class="cursor-pointer info-pulang" data-token_pulang="' . $a_pulang[$i] . '" data-id_siswa="' . $a_pulang['id_siswa'] . '"><i class="fa fa-circle text-success"></i></td>';
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

<script>
   $('.info-pulang').click(function() {
      $('#modalInfoPulang').modal('show');
      var id_siswa = $(this).attr('data-id_siswa');
      token_pulang = $(this).attr('data-token_pulang');
      $('#loadInfoPulang').load('../guru/loadInfoAPulang?id_siswa=' + id_siswa + '&token_pulang=' + token_pulang);
   });
</script>