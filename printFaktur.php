<?php

$conn = mysqli_connect("localhost", "root", "", "dbantrian");
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
function rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 2, '.', ',');
    return $hasil_rupiah;
}
$id = $_POST['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Print Faktur</title>
    <link rel="icon" type="image/png" href="img/rsim.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <script>
        window.print()
    </script>
</head>

<body id="page-top">
    <div class="ms-2 me-2">
        <table align="center" width="100%" id="kop" border="0">
            <tr>
                <td class="text-center align-middle">
                    <image src="img/rsim.png" width="90"></image>
                </td>
                <td class="text-center">
                    <font size="6"><strong>RSI MUHAMMADIYAH SUMBERREJO</strong></font><br>
                    <font size="4">Jl. Raya no. 1193 Sumberrejo - Bojonegoro 62191</font><br>
                    <font size="4">Telp. 0353 331056 Email : rsimsumberrejo@yahoo.co.id</font>
                </td>
            </tr>
        </table>
        <br>

        <?php
        $sql = "SELECT * FROM tbl_faktur WHERE id = $id";
        $outp = array();
        if (mysqli_multi_query($conn, $sql)) {
            do {
                if ($result = mysqli_store_result($conn)) {
                    $outp = $result->fetch_all(MYSQLI_ASSOC);
                }
            } while (mysqli_next_result($conn));
            foreach ($outp as $data) {
                $data2 = json_encode($data);
        ?>
                <div class="col mt-4">
                    <div class="row g-3 align-items-center mb-2">
                        <div class="col-2 text-start">
                            <label class="col-form-label h6"><strong>Tanggal </strong></label>
                        </div>
                        <div class="col-auto">
                            :
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" value="<?= $data['tgl'] ?>" readonly>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center mb-2">
                        <div class="col-2 text-start">
                            <label class="col-form-label h6"><strong>Nama </strong></label>
                        </div>
                        <div class="col-auto">
                            :
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" value="<?= $data['nama'] ?>" readonly>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center mb-2">
                        <div class="col-2 text-start">
                            <label class="col-form-label h6"><strong>PT </strong></label>
                        </div>
                        <div class="col-auto">
                            :
                        </div>
                        <div class="col-auto">
                            <input type="text" class="form-control" value="<?= $data['pt'] ?>" readonly>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
        <table id="dataTable" class="table table-striped table-hover table-bordered">
            <thead>
                <tr class="align-middle text-center">
                    <th>No. Faktur</th>
                    <th>Tanggal Faktur</th>
                    <th>Jumlah Nominal</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $sql = "SELECT a.id AS 'id', a.tgl AS 'tgl', a.nama AS 'nama', a.pt AS 'pt',
            b.no_faktur AS 'no_fak', b.tgl_faktur AS 'tgl_fak', b.jml_nominal AS 'jml', b.tbl_faktur_id
            FROM tbl_listfaktur b
            INNER JOIN tbl_faktur a ON b.tbl_faktur_id = a.id
            WHERE b.tbl_faktur_id = $id";
                $outp = array();
                if (mysqli_multi_query($conn, $sql)) {
                    do {
                        if ($result = mysqli_store_result($conn)) {
                            $outp = $result->fetch_all(MYSQLI_ASSOC);
                        }
                    } while (mysqli_next_result($conn));
                    $jumlahSum = 0;
                    foreach ($outp as $data) {
                        echo "
                        <tr>
                            <td class='align-middle'>" . $data['no_fak'] . "</td>
                            <td class='align-middle'>" . $data['tgl_fak'] . "</td>
                            <td class='align-middle text-end'>" . rupiah($data['jml']) . "</td>
                        </tr>";
                        $jumlahSum += (float)$data['jml'];
                    }
                }
                ?>
                <td colspan="2" class="text-center">Total :</td>
                <td class="text-end"><?= rupiah($jumlahSum) ?></td>
            </tbody>
        </table>

        <!-- <div class="col-6"></div>
        <div class="col-6"> -->
        <div class="float-end text-center">
            <table>
                <tr>
                    <td>Penerima,<br />
                        &nbsp;<br />
                        &nbsp;<br />
                        &nbsp;<br />
                        ( . . . . . . . . . . . . . . . . . )</td>
                </tr>
            </table>
        </div>
        <!-- </div> -->
    </div>
</body>

</html>