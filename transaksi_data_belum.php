<?php
    include "session.php";

    if(!$hasil = $conn->query("SELECT * FROM transaksi join pelanggan on transaksi.id_pelanggan=pelanggan.id_pelanggan
                                        join user on transaksi.id_user=user.id_user where transaksi.id_status_laundry='SL001'")){
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

    <title>Data Transaksi Belum Dijemput</title>

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
                            <h6 class="m-0 font-weight-bold text-primary">DATA TRANSAKSI BELUM DIJEMPUT</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-2 needs-validation" novalidate method="post">
                                <div class="col-md-12 form-group">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                            <th style="width:20px">No.</th>
                                                <th>Nomor Faktur</th>
                                                <th>Tanggal Diantar</th>
                                                <th>Nama Karyawan</th>
                                                <th>Nama Pelanggan</th>
                                                <th style="width:100px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while($row = $hasil->fetch_assoc()){
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row['id_transaksi']; ?></td>
                                                <td><?php echo date('d F Y', strtotime($row['tanggal_diantar'])); ?></td>
                                                <td><?php echo $row['nama']; ?></td>
                                                <td><?php echo $row['nama_pelanggan']; ?></td>
                                                <td class="text-center"> 
                                                    <a role="button" href="transaksi_data_belum_detail.php?id_transaksi=<?php echo $row['id_transaksi'];?>" class="btn btn-outline-info">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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