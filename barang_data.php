<?php
    include "session.php";

    if(isset($_POST['delete'])){
        if(isset($_POST['aksi']) && $_POST['aksi'] == 'hapus'){
            $id_barang = $_POST['id_barang'];
 
            $stmt=$conn->prepare("DELETE FROM barang WHERE id_barang= ?");
            $stmt->bind_param('s', $id_barang);
            $stmt->execute();
        
            if($conn->affected_rows > 0){
                $pesan_sukses= "Data barang berhasil dihapus!";
            }
            else{
                $pesan_gagal= "Data barang gagal dihapus!";
            }
            $stmt->close();
        }
    }

    if(!$hasil = $conn->query("SELECT * FROM barang order by id_barang")){
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

    <title>Tabel Barang</title>

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

                        <?php if(isset($pesan_sukses)){?>
                            <div class="alert alert-success" role="alert">
                                <?php echo '<img src="logo/check.png" width="27" class="me-2">  '.$pesan_sukses; ?>
                            </div>
                        <?php } else if(isset($pesan_gagal)){ ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo '<img src="logo/cross.png" width="20" class="me-2">  '.$pesan_gagal; ?>
                            </div>
                        <?php } ?>

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">TABEL DATA BARANG</h6>
                        </div>
                        <div class="card-body">
                        <a href="barang_tambah.php" class="btn btn-outline-info btn-mt">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-plus-circle" viewBox="1 1 15 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg> Tambah Data Barang
                        </a><br><br>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width:20px">No.</th>
                                            <th>Nama Barang</th>
                                            <th  style="width:100px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            while($row = $hasil->fetch_assoc()){
                                        ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['nama_barang']; ?></td>
                                            <td class="text-center">
                                                <form method="POST" action="barang_data.php">
                                                    <a role="button" href="barang_edit.php?id_barang=<?php echo $row['id_barang'];?>" class="btn btn-outline-warning btn-sm fa fa-edit">
                                                    </a> &nbsp;`    
                                                    <input type="hidden" name="aksi" value="hapus">
                                                    <input type="hidden" name="id_barang" value="<?php echo $row['id_barang'];?>">
                                                    <button class="btn btn-outline-danger btn-sm" type="submit" name="delete" onclick="return confirm('Anda yakin akan menghapus data barang ini?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 14 15">
                                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                        </svg>
                                                    </button> 
                                                </td>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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

</body>

</html>