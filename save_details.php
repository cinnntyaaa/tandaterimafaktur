<?php

$conn = mysqli_connect("localhost", "root", "", "dbantrian");
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

$tgl = $_POST['tgl'];
$nama = $_POST['nama'];
$pt = $_POST['pt'];
$tindakan_json = json_decode($_POST['tindakan_json']);

// $sql = "INSERT INTO `tbl_faktur` (`id`, `tgl`, `nama`, `pt`) VALUES (NULL, '2022-05-20', 'EDP', 'PT. OKE');";
// $sql2 = "INSERT INTO `tbl_listfaktur` (`no_faktur`, `tgl_faktur`, `jml_nominal`, `tbl_faktur_id`) VALUES
// ('0120', '2022-05-19', '9000', LAST_INSERT_ID()),
// ('0121', '2022-05-19', '8000', LAST_INSERT_ID());";

$sql = "INSERT INTO `tbl_faktur` (`id`, `tgl`, `nama`, `pt`)
        VALUES (NULL, '$tgl', '$nama', '$pt');";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$sql2 = "INSERT INTO `tbl_listfaktur` (`no_faktur`, `tgl_faktur`, `jml_nominal`, `tbl_faktur_id`) VALUES ";
if (count($tindakan_json) > 0) {
    foreach ($tindakan_json as $key => $data) {
        if ($key > 0) {
            $sql2 .= ",";
        }
        $sql2 .= "('" . $data->no_faktur . "', '" . $data->tgl_faktur . "', '" . $data->jml_nominal . "', LAST_INSERT_ID())";
    }
    $result2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));
}

if ($result && $result2)
    echo "1";
else
    echo "0";
