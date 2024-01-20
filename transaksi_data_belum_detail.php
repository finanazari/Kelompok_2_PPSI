<?php
    include "session.php";
    $id_transaksi = $_REQUEST['id_transaksi'];
    $saldoBaru = 0; 

    if(isset($_POST['simpan'])){
        $id_status_pembayaran2 = $_POST['id_status_pembayaran'];
        $id_status_laundry = "SL002";
        $tanggal_selesai = date("Y-m-d");

        if($id_status_pembayaran2 == "SB001"){
            $stmt=$conn->prepare('UPDATE transaksi SET id_status_pembayaran=?, id_status_laundry=?, tanggal_selesai=? WHERE id_transaksi=?');
            $stmt->bind_param("ssss", $id_status_pembayaran2, $id_status_laundry, $tanggal_selesai, $id_transaksi);
            $stmt->execute();

            if ($id_metode_pembayaran == 'MP003'){
                $stmtTotal = $conn->prepare ("SELECT total_pembayaran FROM transaksi WHERE id_transaksi = '$id_transaksi'"); 
                $stmtTotal->bind_param("s", $id_transaksi);
                $stmtTotal->execute();
                if ($stmtTotal->error) {
                    echo "Error: " . $stmtTotal->error; 
                }

                $total = $stmtTotal->get_result();
                $rowTotal = $total->fetch_assoc();
                $total_pembayaran= $rowTotal['total_pembayaran']; 

                $stmtSaldo = $conn->prepare("SELECT saldo FROM pelanggan WHERE id_pelanggan=(SELECT id_pelanggan FROM transaksi WHERE id_transaksi = ?)");
                $stmtSaldo->bind_param("s", $id_transaksi);
                $stmtSaldo->execute();

                $hasilSaldo = $stmtSaldo->get_result();
                $rowSaldo = $hasilSaldo->fetch_assoc();
                $saldoSaatIni= $rowSaldo['saldo'];            

                if ($saldoSaatIni >= $total_pembayaran) {
                    $saldoBaru = $saldoSaatIni - $total_pembayaran;
                        
                    $stmtUpdateSaldo = $conn->prepare("UPDATE pelanggan SET saldo = ? WHERE id_pelanggan = (SELECT id_pelanggan FROM transaksi WHERE id_transaksi = ?)");
                    $stmtUpdateSaldo->bind_param("is", $saldoBaru, $id_transaksi);
                    $stmtUpdateSaldo->execute();
                } 
    
            }

            if($conn->affected_rows > 0){
                header("Location:transaksi_data_selesai.php");
            }
            else{
                $pesan_gagal= "Data transaksi gagal disimpan!";
                echo mysqli_error($conn);
            }
        }else{
            $pesan_gagal= "Bayar Pesanan Terlebih Dahulu!";
            echo mysqli_error($conn);
        }

    }

    if(!$hasil = $conn->query("SELECT * FROM transaksi join pelanggan on transaksi.id_pelanggan=pelanggan.id_pelanggan
                                        join user on transaksi.id_user=user.id_user where transaksi.id_transaksi='$id_transaksi'")){
        die("gagal meminta data");
    }
    
    while($row = $hasil->fetch_assoc()){
        $tanggal_diantar = $row['tanggal_diantar'];
        $nama_pelanggan = $row['nama_pelanggan'];
        $nama_karyawan = $row['nama'];
        $no_hp =  $row['no_hp'];
        $id_status_pembayaran = $row['id_status_pembayaran'];
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
                            <h6 class="m-0 font-weight-bold text-primary">DATA DETAIL BARANG TRANSAKSI</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-2 needs-validation" novalidate method="post">
                                <div class="col-md-12 form-group">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="col-md-6">Nomor Transaksi</th>
                                                <td><?php echo $id_transaksi?></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-6">Tanggal Diantar</th>
                                                <td><?php echo date('d F Y', strtotime($tanggal_diantar))?></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-6">Nama Operator</th>
                                                <td><?php echo $nama_karyawan?></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-6">Nama Pelanggan</th>
                                                <td><?php echo $nama_pelanggan?></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-6">Nomor HP</th>
                                                <td><?php echo $no_hp?></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-12 form-group">
                                    <p class="text-center">DATA PESANAN</p>
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th style="width:20px">No.</th>
                                                <th>Nama Barang</th>
                                                <th>Nama Layanan</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                                <td>Sub Harga</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $hasil2 = $conn->query("SELECT * FROM detail_transaksi join barang_layanan on detail_transaksi.id_barang_layanan=barang_layanan.id_barang_layanan
                                                                        join layanan on barang_layanan.id_layanan=layanan.id_layanan
                                                                        join barang on barang_layanan.id_barang=barang.id_barang where detail_transaksi.id_transaksi='$id_transaksi' order by nama_barang");
                                                $tot[]=0;
                                                while($row = $hasil2->fetch_assoc()){
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row['nama_barang']; ?></td>
                                                <td><?php echo $row['layanan']; ?></td>
                                                <td><?php echo "Rp " . number_format($row['harga'],2,',','.');?></td>
                                                <td><?php echo $row['ukuran']," ", $row['satuan']; ?></td>
                                                <td><?php echo "Rp " . number_format($tot[]= $row['harga'] * $row['ukuran'],2,',','.'); ?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                            <td colspan="8" class="text-center"> Total Pembayaran : <?php echo "Rp " . number_format(array_sum($tot),2,',','.');?> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="validationCustom4" class="form-label">Status Pembayaran</label>
                                    <select class="form-control" id="validationCustom04" name="id_status_pembayaran" required>
                                        <option selected disabled value="">Pilih Status Pembayaran</option>
                                        <?php
                                        $status_pembayaran = $conn->query("SELECT * FROM status_pembayaran where id_status_pembayaran != '0'");
                                        while($data = $status_pembayaran->fetch_assoc()){
                                        ?>
                                            <option value="<?php echo $data['id_status_pembayaran'];?>"
                                            <?php if($id_status_pembayaran == $data['id_status_pembayaran']) {
                                                echo 'selected';
                                            }?>>
                                               <?php echo $data['status_pembayaran']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Status Pembayaran Harus Diisi!
                                    </div>
                                </div>
                                <div class="col-md-12"><br>
                                    <button class="btn btn-outline-primary btn-mt far fa-save" type="submit" name="simpan" onclick="return confirm('Apakah Data Yang Dimasukkan Sudah Benar ?')">
                                        Selesai
                                    </button>&nbsp;&nbsp;
                                    <button class="btn btn-outline-success btn-mt" type="reset">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                                        </svg> Reset
                                    </button>
                                    <a style="float:right" href="transaksi_data_belum.php" class="btn btn-outline-primary btn-mt" name="back">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 1 16 16">
                                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                        </svg>
                                        Back
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