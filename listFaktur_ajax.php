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
        <form method="post" action="printFaktur.php" target="_blank">
            <input type="hidden" name="id" value="<?= $id ?>" />
            <div class="col">
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

    <div class="float-end text-center">
        <tr>
            <td>
                Penerima,<br />
                &nbsp;<br />
                &nbsp;<br />
                &nbsp;<br />
                ( . . . . . . . . . . . . . . . . . )
            </td>
        </tr>
    </div>
    <input type="submit" class="btn btn-dark larger" id="print" value="Print" />
        </form>