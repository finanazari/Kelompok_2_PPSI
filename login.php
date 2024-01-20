<?php
    session_start();
    include "koneksi.php"; 

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
    
        $login = $conn->query("select * from user where username='$username' and password='$password'");
        $cek = mysqli_num_rows($login);
        if ($cek > 0) {
            $data = mysqli_fetch_array($login);
    
            if ($data['jenis_user'] == "Admin") {
    
                $_SESSION['id_user'] = $data['id_user'];
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['jenis_user'] = $data['jenis_user'];
                $_SESSION['gambar'] = $data['gambar'];
    
                header("Location: admin_dashboard.php");
            }
    
            if ($data['jenis_user'] == "Karyawan") {
                $_SESSION['id_user'] = $data['id_user'];
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['jenis_user'] = $data['jenis_user'];
                $_SESSION['gambar'] = $data['gambar'];
    
                header("Location: admin_dashboard.php");
            }
        } else {
            $pesan_gagal="Anda Gagal Login";
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

    <title>Halaman Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="" style="background-color: #0A57A2;">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-4 col-md-10">
                <div  class="card o-hidden border-0 shadow-lg my-3" style="display:grid;" >
                    <div class="card-body p-1">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="p-5">
                                <?php
                                    if(isset($pesan_gagal)){
                                ?>
                                    <div class="alert alert-danger" role="alert">
                                    <?php echo '<img src="logo/EVIE.png" width="20" class="me-2">   '.$pesan_gagal; ?>
                                    </div>
                                <?php
                                }
                                ?>
                                <form class="user" method="post" action="">
                                    <hr>
                                    <div class="text-center">
                                        <img src="logo/EVIE.png" width="100px" height="100px">
                                        <h1 class="h4 text-gray-900 mb-4 mt-3">Selamat Datang di Sistem Informasi Pengelolaan Data Evie Laundry</h1>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <input type="username" name="username" class="form-control form-control-user" placeholder="Masukkan Username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user" placeholder="Masukkan Password">
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" name="submit" type="submit" style="background-color: #0A57A2;">
                                        Login
                                    </button>
                                    <br><hr>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>