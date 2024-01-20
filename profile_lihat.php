<?php
    include "session.php";
    $id_user = $_SESSION['id_user'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE id_user = ?");
    $stmt->bind_param("s", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    while($data = $result->fetch_assoc()){
        $id_user = $data['id_user'];
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $no_hp = $data['no_hp'];
        $NIK = $data['NIK'];
        $username = $data['username'];
        $gambar = "img/".$data['gambar'];
    }
    $stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lihat Profile</title>

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
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">LIHAT PROFILE</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-2 needs-validation" novalidate method="post">
                                <div>
                                    <input type="hidden" class="form-control" style="background-color: #dee2e6" id="validationCustom01" pattern="^[A-Za-z]+([\A-Za-z]+)*" name="id_user" value=<?php echo $id_user ?> readonly required>
                                </div>
                                    <img style="margin:auto" src="<?php echo $gambar; ?>" width="100">
                                <div class="col-md-12 form-group">
                                    <br><a style="display: block; margin-left: auto; margin-right: auto;" href="profile_edit.php?id_user=<?php echo $id_user?>" class="btn btn-outline-warning btn-mt fa fa-edit">
                                        Edit Profile
                                    </a><br><br>
                                    <table class="table table-bordered" width="100%" cellspacing="1">
                                        <thead>
                                            <tr>
                                                <th class="col-md-6">NIK</th>
                                                <td><?php echo $NIK?></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-6">Username</th>
                                                <td><?php echo $username?></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-6">Nama </th>
                                                <td><?php echo $nama?></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-6">No HP</th>
                                                <td><?php echo $no_hp?></td>
                                            </tr>
                                            <tr>
                                                <th class="col-md-6">Alamat</th>
                                                <td><?php echo $alamat?></td>
                                            </tr>
                                        </thead>
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