<?php
    include "session.php";

    $data = $conn->query("SELECT MAX(RIGHT(id_transaksi, 3)) as id_transaksi FROM transaksi");
    $no=0;
    while($n = mysqli_fetch_assoc($data)){
        $no = $n['id_transaksi'];
    }
    $sort_num = (int) substr($no, 1, 3);
    $sort_num++;
    $new_code = sprintf("%03s", $sort_num);

    $id_transaksi = "TR".$new_code;

    if(isset($_POST['simpan'])){
        $id_user = $_POST['id_user'];
        $id_pelanggan = $_POST['id_pelanggan'];
        $tanggal_diantar = $_POST['tanggal_diantar'];
        $tanggal_selesai= "0000/00/00";
        $id_status_laundry = "SL001";
        $id_status_pembayaran = "0";
        $id_metode_pembayaran = "0";
        $total_pembayaran = 0;

        $stmt=$conn->prepare('INSERT INTO transaksi VALUES (?,?,?,?,?,?,?,?,?)');
        $stmt->bind_param("ssssssiss", $id_transaksi, $id_user, $id_pelanggan, $id_status_laundry, $id_metode_pembayaran, $id_status_pembayaran, $total_pembayaran, $tanggal_selesai, $tanggal_diantar);
        $stmt->execute();

        if($conn->affected_rows > 0){
            header("Location:transaksi_tambah_barang.php?id_transaksi=$id_transaksi");
        }
        else{
            $pesan_gagal= "Data transaksi gagal disimpan!";
            echo mysqli_error($conn);
        }
    }
    if(!$hasil = $conn->query("SELECT * FROM transaksi where id_transaksi='$id_transaksi' order by id_user")){
        die("gagal meminta data");
    }
    $no = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Form Tambah Transaksi</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php 
        if ($_SESSION["jenis_user"] != "Karyawan"){
            include"admin_sidebar.html";
        }else{
            include"karyawan_sidebar.html";
        }?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include"header.php";?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                    <?php
                        if(isset($pesan_sukses)){
                    ?>
                        <div class="alert alert-success" role="alert">
                        <?php echo '<img src="logo/check.png" width="27" class="me-2">'.$pesan_sukses; ?>
                        </div>
                    <?php
                    }
                    else if(isset($pesan_gagal)){
                    ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo '<img src="logo/cross.png" width="18" class="me-2">'.$pesan_gagal; ?>
                        </div>
                    <?php
                    }
                    else if(isset($pesan_peringatan)){
                    ?>
                        <div class="alert alert-warning" role="alert">
                        <?php echo '<img src="logo/warning.png" width="18" class="me-2">'.$pesan_peringatan;?>
                        </div>
                    <?php
                    } 
                    ?>

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">TAMBAH DATA TRANSAKSI</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-2 needs-validation" novalidate method="post">
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom08" class="form-label">Nomor Struk</label>
                                    <input type="text" class="form-control" style="background-color: #dee2e6" id="validationCustom01" pattern="^[A-Za-z]+([\A-Za-z]+)*" name="id_transaksi" value=<?php echo "$id_transaksi"?> readonly required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom08" class="form-label">Tanggal Diantar</label>
                                    <input type="text" class="form-control" style="background-color: #dee2e6" id="validationCustom08" name="tanggal_diantar" placeholder="Tanggal Diantar" value="<?php echo date('Y/m/d') ?>" readonly required>
                                    <div class="invalid-feedback">
                                        Masukkan Data Tanggal Diantar Dengan Benar!
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom08" class="form-label">Nama Karyawan</label>
                                    <select class="form-control" style="background-color: #dee2e6" id="validationCustom04" name="id_user" required>
                                        <option selected disabled value="">Pilih Karyawan</option>
                                        <?php 
                                            $stmt25 = $conn->query("SELECT * FROM user where jenis_user='Karyawan'");
                                            while($row = $stmt25->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id_user']; ?>"><?php echo $row['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Karyawan Harus Diisi!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom08" class="form-label">Nama Pelanggan</label>
                                    <select class="form-control" style="background-color: #dee2e6" id="validationCustom04" name="id_pelanggan" required>
                                        <option selected disabled value="">Pilih Pelanggan</option>
                                        <?php 
                                            $stmt25 = $conn->query("SELECT * FROM pelanggan");
                                            while($row = $stmt25->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id_pelanggan']; ?>"><?php echo $row['nama_pelanggan']; ?></option>
                                        <?php } ?>
                                    </select>
                                    Pelanggan Belum Terdaftar? <a href="pelanggan_tambah.php">Tambah Pelanggan</a>
                                    <div class="invalid-feedback">
                                        Pelanggan Harus Diisi!
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <button class="btn btn-outline-primary btn-mt far fa-save" type="submit" name="simpan" onclick="return confirm('Apakah Data Yang Dimasukkan Sudah Benar ?')">
                                        Lanjut 
                                    </button>&nbsp;&nbsp;
                                    <button class="btn btn-outline-success btn-mt" type="reset">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                        </svg> Reset
                                    </button>
                                </div>
                            </form>
                            <script>
                            (function () {
                            'use strict'

                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            var forms = document.querySelectorAll('.needs-validation')

                            // Loop over them and prevent submission
                            Array.prototype.slice.call(forms)
                                .forEach(function (form) {
                                form.addEventListener('submit', function (event) {
                                    if (!form.checkValidity()) {
                                    event.preventDefault()
                                    event.stopPropagation()
                                    }

                                    form.classList.add('was-validated')
                                }, false)
                                })
                            })()
                        </script>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php include 'footer.html' ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

</body>

</html>