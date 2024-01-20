<?php
    
    $conn = new mysqli('localhost', 'root', '', 'db_laundry');

    if($conn->connect_errno > 0){
        echo "<script>
                alert('Koneksi Database Gagal');
            </script>";
    }

?>