<?php
    include "session.php";

    $id_transaksi = $_REQUEST['id_transaksi'];

    if(isset($_POST['simpan'])){
        $id_barang = $_POST['id_barang'];
        $id_layanan = $_POST['id_layanan'];
        $ukuran = $_POST['ukuran'];

        $data1 = $conn->query("SELECT id_barang_layanan as id FROM barang_layanan where id_barang='$id_barang' AND id_layanan='$id_layanan'");
        while($row2 = $data1->fetch_assoc()){
            $id_barang_layanan = $row2['id'];
        }

        $data = $conn->query("SELECT id_barang_layanan as id FROM detail_transaksi where id_transaksi='$id_transaksi'");
        while($row1 = $data->fetch_assoc()){
            $brag = $row1['id'];}

        if($id_barang_layanan !== $brag){                
            $stmt=$conn->prepare('INSERT INTO detail_transaksi VALUES (?,?,?)');
            $stmt->bind_param("ssi", $id_barang_layanan, $id_transaksi, $ukuran);
            $stmt->execute();

            if($conn->affected_rows > 0){
                header("Location:transaksi_tambah_barang.php?id_transaksi=".$id_transaksi);
            }
            else{
                $pesan_gagal= "Data transaksi gagal disimpan!";
            }
            $stmt->close();
        }else{
            $pesan_gagal= "Data transaksi sudah ada!";
        }
        
    } 
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
                                <div class="col-md-12 form-group">
                                    <label for="validationCustom08" class="form-label">Nomor Struk</label>
                                    <input type="text" class="form-control" style="background-color: #dee2e6" id="validationCustom01" pattern="^[A-Za-z]+([\A-Za-z]+)*" name="id_transaksi" value=<?php echo "$id_transaksi"?> readonly required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="validationCustom08" class="form-label">Nama Barang</label>
                                    <select autofocus class="form-control" style="background-color: #dee2e6" id="validationCustom04" name="id_barang" required>
                                        <option selected disabled value="">Pilih Barang</option>
                                        <?php 
                                            $stmt25 = $conn->query("SELECT * FROM barang");
                                            while($row = $stmt25->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id_barang']; ?>"><?php echo $row['nama_barang']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Karyawan Harus Diisi!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom08" class="form-label">Nama Layanan</label>
                                    <select class="form-control" style="background-color: #dee2e6" id="validationCustom04" name="id_layanan" required>
                                        <option selected disabled value="">Pilih Layanan</option>
                                        <?php 
                                            $stmt25 = $conn->query("SELECT * FROM layanan");
                                            while($row = $stmt25->fetch_assoc()){
                                        ?>
                                        <option value="<?php echo $row['id_layanan']; ?>"><?php echo $row['layanan']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Layanan Harus Diisi!
                                    </div>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="validationCustom08" class="form-label">Jumlah</label>
                                    <input type="number" min="1" class="form-control" style="background-color: #dee2e6" id="validationCustom08" pattern="[0-9]" name="ukuran" placeholder="Jumlah" required>
                                    <div class="invalid-feedback">
                                        Masukkan Data Jumlah Dengan Benar!
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <button class="btn btn-outline-primary btn-mt far fa-save" type="submit" name="simpan" onclick="return confirm('Apakah Data Yang Dimasukkan Sudah Benar ?')">
                                        Simpan 
                                    </button>&nbsp;&nbsp;
                                    <button class="btn btn-outline-success btn-mt" type="reset">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                        </svg> Reset
                                    </button>
                                    <a style="float:right" href="transaksi_tambah_barang.php?id_transaksi=<?php echo $id_transaksi?>" class="btn btn-outline-primary btn-mt" name="back">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 1 16 16">
                                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                            </svg>
                                            Kembali
                                    </a>
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