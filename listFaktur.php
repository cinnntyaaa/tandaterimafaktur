<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Faktur</title>
    <link rel="icon" type="image/png" href="img/rsim.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/4040daf745.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <link href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="text-center h2 mb-4"><u><strong>Daftar Tanda Terima Faktur</strong></u></div>
            <table class="table table-bordered table-striped table-hover" id="myTable">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">PT</th>
                        <th class="text-center">Proses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "dbantrian");
                    if (mysqli_connect_errno()) {
                        echo "Koneksi database gagal : " . mysqli_connect_error();
                    }

                    $no = 1;
                    $sql = "SELECT * FROM tbl_faktur";
                    $outp = array();
                    // Execute multi query
                    if (mysqli_multi_query($conn, $sql)) {
                        do {
                            // Store first result set
                            if ($result = mysqli_store_result($conn)) {
                                $outp = $result->fetch_all(MYSQLI_ASSOC);
                                // Fetch one and one row
                            }
                        } while (mysqli_next_result($conn));
                        foreach ($outp as $data) {
                            $data2 = json_encode($data);
                            echo "
								<tr>
									<td class='text-center align-middle'>$no</td>
									<td class='align-middle'>" . $data['tgl'] . "</td>
									<td class='align-middle'>" . $data['nama'] . "</td>
									<td class='align-middle'>" . $data['pt'] . "</td>
									<td class='text-center'>
									<a onclick='print(" . $data['id'] . ")'>Print</a>
									</td>
								</tr>";
                            $no++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tanda Terima Faktur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="coba">

                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Print</button>
                </div> -->
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ]
            });
        });

        function print(id) {
            $.ajax({
                url: 'listFaktur_ajax.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(result) {
                    $("#myModal").modal("show");
                    $("#coba").html(result);
                },
                error: function() {
                    alert("Something went wrong!");
                }
            });
        }
    </script>
</body>

</html>