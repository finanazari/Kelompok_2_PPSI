<?php
    include "session.php";

    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];

    if(!$hasil = $conn->query("SELECT * FROM transaksi WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='$bulan' and 
                                year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'")){
        die("gagal meminta data");
    }

    if($bulan == 1){ $nama_bulan="Januari";}
    else if($bulan == 2){ $nama_bulan="Februari";}
    else if($bulan == 3){ $nama_bulan="Maret";}
    else if($bulan == 4){ $nama_bulan="April";}
    else if($bulan == 5){ $nama_bulan="Mei";}
    else if($bulan == 6){ $nama_bulan="Juni";}
    else if($bulan == 7){ $nama_bulan="Julii";}
    else if($bulan == 8){ $nama_bulan="Agustus";}
    else if($bulan == 9){ $nama_bulan="September";}
    else if($bulan == 10){ $nama_bulan="Oktober";}
    else if($bulan == 11){ $nama_bulan="November";}
    else if($bulan == 12){ $nama_bulan="Desember";}
    
    $no = 1; $tot[] = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DATA TRANSAKSI BULAN <?php echo strtoupper($nama_bulan), " ", $tahun?></h6>
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
                                                <th>Tanggal Selesai</th>
                                                <th>Nama Karyawan</th>
                                                <th>Nama Pelanggan</th>
                                                <th style="width:100px;">Total Transaksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while($row = $hasil->fetch_assoc()){
                                                $id_transaksi = $row['id_transaksi']; 
                                                $query = $conn->query("SELECT pelanggan.nama_pelanggan as nama_pelanggan, user.nama as nama, transaksi.tanggal_selesai as tanggal_selesai, 
                                                                        transaksi.tanggal_diantar as tanggal_diantar, sum(detail_transaksi.ukuran*barang_layanan.harga) as total from transaksi 
                                                                        join pelanggan on transaksi.id_pelanggan=pelanggan.id_pelanggan 
                                                                        join user on transaksi.id_user=user.id_user 
                                                                        join detail_transaksi on transaksi.id_transaksi=detail_transaksi.id_transaksi 
                                                                        join barang_layanan on detail_transaksi.id_barang_layanan=barang_layanan.id_barang_layanan 
                                                                        where transaksi.id_transaksi='$id_transaksi'");
                                                $data = $query->fetch_assoc();
                                                $nama_pelanggan = $data['nama_pelanggan'];
                                                $nama_user = $data['nama'];
                                                $tanggal_diantar = $data['tanggal_diantar'];
                                                $tanggal_selesai = $data['tanggal_selesai'];
                                                $total = $data['total'];
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td width="10%"><?php echo $id_transaksi; ?></td>
                                                <td><?php echo date('d F Y', strtotime($row['tanggal_diantar'])); ?></td>
                                                <td><?php echo date('d F Y', strtotime($row['tanggal_selesai'])); ?></td>
                                                <td><?php echo $nama_user; ?></td>
                                                <td><?php echo $nama_pelanggan; ?></td>
                                                <td width="15%"><?php $tot[] = $total; echo "Rp " . number_format($total,2,',','.');?></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="8" class="text-center"> Total Pendapatan : <?php echo "Rp " . number_format(array_sum($tot),2,',','.');?> </td>
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