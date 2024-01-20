<?php
    include "session.php";
    $bulan = date('m');
    $tahun = date('Y');
    $hari_ini = date('Y/m/d');

    $query = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='$bulan' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
    $data = $query->fetch_assoc();
    $pendapatan = $data['pendapatan'];

    $query2 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan_hari from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE tanggal_selesai='$hari_ini'");
    $data2 = $query2->fetch_assoc();
    $pendapatan_hari_ini = $data2['pendapatan_hari'];

    $query3 = $conn->query("SELECT count(id_transaksi) as jumlah from transaksi where month(tanggal_selesai)='$bulan' and 
                            year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
    $data3 = $query3->fetch_assoc();
    $jumlah_transaksi = $data3['jumlah'];

    $query4 = $conn->query("SELECT count(id_transaksi) as jumlah from transaksi where tanggal_selesai='$hari_ini'");
    $data4 = $query4->fetch_assoc();
    $jumlah_transaksi_hari_ini = $data4['jumlah'];

    $query5 = $conn->query("SELECT count(id_pelanggan) as jumlah from pelanggan");
    $data5 = $query5->fetch_assoc();
    $jumlah_pelanggan = $data5['jumlah'];

    $query6 = $conn->query("SELECT count(id_user) as jumlah from user where jenis_user='Karyawan'");
    $data6 = $query6->fetch_assoc();
    $jumlah_karyawan = $data6['jumlah'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Pendapatan Hari Ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "Rp " . number_format($pendapatan_hari_ini,2,',','.');?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Pendapatan Bulan Ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo "Rp " . number_format($pendapatan,2,',','.');?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Jumlah Transaksi Hari Ini</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_transaksi_hari_ini?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Transaksi Bulan Ini
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $jumlah_transaksi?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Karyawan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_karyawan;?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Jumlah Pelanggan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlah_pelanggan?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-md-6 mb-4 ">
                            <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                    <div class="col-xl-12">
                                    <canvas id="bar-chart"></canvas>
                                    </div>
                                    </div>
                                </div>
                            </div>
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

    <script type="text/javascript">
        // Bar chart
        new Chart(document.getElementById("bar-chart"), {
            type: 'bar',
            data: {
                labels: ["Januari", "Fabruari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                datasets: [
                {
                    label: "Total Pendapatan",
                    backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9"],
                    data: [

                    <?php

                    $query8 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='1' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data8 = $query8->fetch_assoc();
                    echo $jumlah_transaksi8 = $data8['pendapatan'];

                    ?>

                    ,

                    <?php

                    $query10 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='2' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data10 = $query10->fetch_assoc();
                    echo $jumlah_transaksi10 = $data10['pendapatan'];

                    ?>

                    ,

                    <?php

                    $query11 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='3' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data11 = $query11->fetch_assoc();
                    echo $jumlah_transaksi11 = $data11['pendapatan'];

                    ?>
                    
                    ,

                    <?php

                    $query12 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='4' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data12 = $query12->fetch_assoc();
                    echo $jumlah_transaksi12 = $data12['pendapatan'];

                    ?>
                    
                    ,

                    <?php

                    $query13 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='5' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data13 = $query13->fetch_assoc();
                    echo $jumlah_transaksi13 = $data13['pendapatan'];

                    ?>

                    ,

                    <?php

                    $query14 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='6' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data14 = $query14->fetch_assoc();
                    echo $jumlah_transaksi14 = $data14['pendapatan'];

                    ?>
                    ,

                    <?php

                    $query15 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='7' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data15 = $query15->fetch_assoc();
                    echo $jumlah_transaksi15 = $data15['pendapatan'];

                    ?>
                    ,

                    <?php

                    $query16 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='8' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data16 = $query16->fetch_assoc();
                    echo $jumlah_transaksi16 = $data16['pendapatan'];

                    ?>
                    ,

                    <?php

                    $query17 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='9' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data17 = $query17->fetch_assoc();
                    echo $jumlah_transaksi17 = $data17['pendapatan'];

                    ?>
                    ,

                    <?php

                    $query18 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='10' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data18 = $query18->fetch_assoc();
                    echo $jumlah_transaksi18 = $data18['pendapatan'];

                    ?>

                    ,

                    <?php

                    $query19 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='11' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data19 = $query19->fetch_assoc();
                    echo $jumlah_transaksi19 = $data19['pendapatan'];

                    ?>
                    ,

                    <?php

                    $query20 = $conn->query("SELECT sum(detail_transaksi.ukuran*barang_layanan.harga) as pendapatan from detail_transaksi join transaksi
                    on transaksi.id_transaksi=detail_transaksi.id_transaksi join barang_layanan on detail_transaksi.id_barang_layanan
                    =barang_layanan.id_barang_layanan WHERE transaksi.id_status_pembayaran='SB001' and month(tanggal_selesai)='12' and 
                    year(tanggal_selesai)='$tahun' and tanggal_selesai != '0000-00-00'");
                    $data20 = $query20->fetch_assoc();
                    echo $jumlah_transaksi20 = $data20['pendapatan'];

                    ?>

                    ,0]
                }
                ]
            },
            options: {
                legend: { display: false },
                title: {
                display: true,
                text: 'Data Total Pendapatan Per Bulan Pada Tahun <?php echo $tahun?>'
                }
            }
        });
 </script>  
    
</body>

</html>