<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tanda Terima Faktur</title>
    <link rel="icon" type="image/png" href="img/rsim.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/4040daf745.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <form id="hl_form" name="hl_form">
            <input type="hidden" id="form_name" name="form_name" value="add_faktur" />
            <div class="container">
                <div class="row">
                    <div class="text-center h2 mb-4"><u><strong>Tanda Terima Faktur</strong></u></div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label h6"><strong>Tanggal :</strong></label>
                            <input type="text" class="form-control" name="tgl" id="tgl" value="<?= date('Y-m-d'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label h6"><strong>Nama :</strong></label>
                            <input type="text" class="form-control text-uppercase" name="nama" id="nama" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label h6"><strong>PT :</strong></label>
                            <input type="text" class="form-control text-uppercase" name="pt" id="pt" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div>
                            <label class="form-label h6"><strong>Faktur :</strong></label>
                            <div>
                                <input type="button" value="Tambah Faktur" onclick="addRow('dataTable')" />
                                <input type="button" value="Hapus Faktur" onclick="deleteRow('dataTable')" />
                            </div>
                            <span style="font-size: 12px">*centang checkbox jika akan menghapus faktur</span>
                            <table id="dataTable" width="350px" class="table table-striped table-hover">
                                <thead>
                                    <tr class="align-middle text-center">
                                        <th></th>
                                        <th>No. Faktur</th>
                                        <th>Tanggal Faktur</th>
                                        <th>Jumlah Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle"><input type="checkbox" class="form-check-input text-center" name="chk" /></td>
                                        <td class="align-middle"><input type="text" class="form-control text-center" name="no_faktur"></td>
                                        <td class="align-middle"><input class="form-control text-center datepicker" name="tgl_faktur"></td>
                                        <td class="align-middle"><input type="text" class="form-control text-center nominal" name="jml_nominal"></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                        <div class="mb-3">
                            <label class="form-label h6"><strong>Total :</strong></label>
                            <span id="jumlahRaw" hidden></span><span id="jumlah"></span>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary float-end" name="add" id="add">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });

        function hitungJumlah() {
            const rupiah = (money) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 2
                }).format(money);
            }

            let sum = 0;
            $('.nominal').each(function() {
                sum += Number($(this).val());
            });

            $("#jumlah").text(rupiah(sum));
            $("#jumlahRaw").text((sum));
            // let uangTotal = $('.nominal');
            // let uangTot = $('.nominal').val();
            // for (let index = 0; index < uangTotal.length; index++) {
            //     uang = isNaN(parseInt(uangTot[index].value)) ? 0 : parseInt(uangTot[index].value);
            //     sum += uang;
            // }
        }

        $('.nominal').keyup(function(event) {
            hitungJumlah();
        });

        function addRow(tableID) {
            $(function() {
                $(".datepicker").datepicker({
                    dateFormat: "yy-mm-dd"
                });
            });

            let table = document.getElementById(tableID);
            let rowCount = table.rows.length;
            let row = table.insertRow(rowCount);
            let colCount = table.rows[0].cells.length;

            for (var i = 0; i < colCount; i++) {
                var newcell = row.insertCell(i);
                // newcell.innerHTML = table.rows[1].cells[i].innerHTML;
                row.innerHTML = `<tr>
                                    <td class='align-middle'><input type='checkbox' class='form-check-input text-center' name='chk' /></td>
                                    <td class='align-middle'><input type='text' class='form-control text-center' name='no_faktur'></td>
                                    <td class='align-middle'><input class='form-control text-center datepicker' name='tgl_faktur'></td>
                                    <td class='align-middle'><input type='text' class='form-control text-center nominal' name='jml_nominal'></td>
                                </tr>`;
                $('.nominal').keyup(function(event) {
                    hitungJumlah()
                });
            }
        }

        function deleteRow(tableID) {
            try {
                var table = document.getElementById(tableID);
                var rowCount = table.rows.length;

                for (var i = 0; i < rowCount; i++) {
                    var row = table.rows[i];
                    var chkbox = row.cells[0].childNodes[0];
                    if (null != chkbox && true == chkbox.checked) {
                        if (rowCount <= 1) {
                            alert("Cannot delete all the rows.");
                            break;
                        }
                        table.deleteRow(i);
                        rowCount--;
                        i--;
                    }
                }
            } catch (e) {
                alert(e);
            }
        }

        function addData() {
            let btn_button = $(this);
            // if (document.forms["hl_form"]["no_faktur"].value != "" && document.forms["hl_form"]["tgl_faktur"].value != "" && document.forms["hl_form"]["jml_nominal"].value != "") {
            btn_button.html(' <i class="fa fa fa-spinner fa-spin"></i> Processing...');
            btn_button.attr("disabled", true);

            let tgl = $('#tgl').val();
            let nama = $('#nama').val();
            let pt = $('#pt').val();

            let tindakan_glob = new Array();

            tindakan_glob.length = 0;
            let table_tind = document.getElementById('dataTable');
            let rows_tind = table_tind.rows;
            for (x = 1; x < rows_tind.length; x++) {
                let temps = {
                    'no_faktur': rows_tind[x].cells[1].getElementsByTagName('input')[0].value,
                    'tgl_faktur': rows_tind[x].cells[2].getElementsByTagName('input')[0].value,
                    'jml_nominal': rows_tind[x].cells[3].getElementsByTagName('input')[0].value
                }
                tindakan_glob.push(temps);
            }

            let tindakan_json = JSON.stringify(tindakan_glob);
            console.log(tindakan_json);
            $.ajax({
                url: 'save_details.php',
                type: 'POST',
                data: {
                    tgl: tgl,
                    nama: nama,
                    pt: pt,
                    tindakan_json: tindakan_json
                },
                success: function(result) {
                    console.log(result)
                },
                error: function() {
                    alert("Something went wrong!");
                }
            });
            // } else {
            //     alert("Lengkapi Form No.Faktur, Tanggal Faktur dan Jumlah Nomminal!");
            // }
        }

        $(document).on('click', '#add', function(ev) {
            ev.preventDefault();
            addData();
        });
    </script>
</body>

</html>
