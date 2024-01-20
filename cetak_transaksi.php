<?php
    include "session.php";
    $id_transaksi = $_REQUEST['id_transaksi'];

    if(isset($_POST['delete'])){
        if(isset($_POST['aksi']) && $_POST['aksi'] == 'hapus'){
            $id_barang_layanan = $_POST['id_barang_layanan'];
 
            $stmt=$conn->prepare("DELETE FROM detail_transaksi WHERE id_barang_layanan= ? AND id_transaksi=?");
            $stmt->bind_param('ss', $id_barang_layanan, $id_transaksi);
            $stmt->execute();
        
            if($conn->affected_rows > 0){
                $pesan_sukses= "Data transaksi barang berhasil dihapus!";
            }
            else{
                $pesan_gagal= "Data transaksi gagal dihapus!";
            }
            $stmt->close();
        }
    }
    else if(isset($_POST['simpan'])){
        $id_status_pembayaran = $_POST['id_status_pembayaran'];

        $stmt=$conn->prepare('UPDATE transaksi SET id_status_pembayaran=? WHERE id_transaksi=?');
        $stmt->bind_param("ss", $id_status_pembayaran, $id_transaksi);
        $stmt->execute();

        if($conn->affected_rows > 0){
            header("Location:transaksi_tambah.php");
        }
        else{
            $pesan_gagal= "Data transaksi gagal disimpan!";
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
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form class="row g-2 needs-validation" novalidate method="post">
                                <div class="col-md-12 form-group">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Nomor Transaksi</th>
                                                <th><?php echo $id_transaksi; ?></th>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Diantar</th>
                                                <th><?php echo date('d F Y', strtotime($tanggal_diantar));?></th>
                                            </tr>
                                            <tr>
                                                <th>Nama Operator</th>
                                                <th><?php echo $nama_karyawan?></th>
                                            </tr>
                                            <tr>
                                                <th>Nama Pelanggan</th>
                                                <th><?php echo $nama_pelanggan?></th>
                                            </tr>
                                            <tr>
                                                <th>Nomor HP</th>
                                                <th><?php echo $no_hp?></th>
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
                            </form>
                        <script>
                            window.print();
                        </script>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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