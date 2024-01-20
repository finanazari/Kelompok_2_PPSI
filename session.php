<?php
    include "koneksi.php";
    if (!isset($_SESSION)) {
      session_start();
      if (!isset($_SESSION["id_user"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["gambar"]) && $_SESSION["jenis_user"] != "Admin") {
        header("Location: login.php");
        exit;
      }else if (!isset($_SESSION["id_user"]) && !isset($_SESSION["nama"]) && !isset($_SESSION["gambar"]) && $_SESSION["jenis_user"] != "Karyawan") {
          header("Location: login.php");
          exit;
      }
    }
?>