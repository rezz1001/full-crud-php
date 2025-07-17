<?php
//fungsi menampilkan (read)
if (!function_exists('select')) {
    function select($query){
        global $db;

        $result = mysqli_query($db, $query);
        $rows = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}

//fungsi menampilkan (create)
if (!function_exists('create_barang')) {
    function create_barang($post){
        global $db;

        $nama = $post['nama'];
        $jumlah = $post['jumlah'];
        $harga = $post['harga'];
        $barcode = rand(100000, 999999); 
        
        $query = "INSERT INTO barang VALUES ('', '$nama', '$jumlah', '$harga','$barcode', CURRENT_TIMESTAMP())";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

//fungsi mengubah 

if (!function_exists('update_barang')) {
    function update_barang($post){
        global $db;
        
        $id_barang = $post['id_barang'];
        $nama = $post['nama'];
        $jumlah = $post['jumlah'];
        $harga = $post['harga'];
        
        $query = "UPDATE barang SET
                    nama = '$nama',
                    jumlah = '$jumlah',
                    harga = '$harga' 
                    WHERE id_barang = $id_barang";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

//fungsi menghapus data barang
if (!function_exists('delete_barang')) {
    function delete_barang($id_barang){
        global $db;
        $query = "DELETE FROM barang  WHERE id_barang = $id_barang";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

//fungsi menampilkan (create)
if (!function_exists('create_mahasiswa')) {
    function create_mahasiswa($post){
        global $db;

        $nama =strip_tags($post['nama']);
        $prodi =strip_tags($post['prodi']);
        $jk =strip_tags($post['jk']);
        $telepon =strip_tags($post['telepon']);
        $alamat=$post['alamat'];
        $email =strip_tags($post['email']);
        $foto = upload_file();

        // cek upload foto
        if (!$foto) {
            return false;
        }
        $query = "INSERT INTO mahasiswa VALUES (null, '$nama', '$prodi', '$jk', '$telepon','$alamat', '$email', '$foto')";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

if (!function_exists('upload_file')) {
    function upload_file() {
        $namaFile = $_FILES['foto']['name'];
        $ukuranFile = $_FILES['foto']['size'];
        $error = $_FILES['foto']['error'];
        $tmpName = $_FILES['foto']['tmp_name'];

        // Validasi ekstensi file
        $exstensifileValid = ['jpg', 'jpeg', 'png'];
        $exstensiFile = explode('.', $namaFile);
        $exstensiFile = strtolower(end($exstensiFile));

        if (!in_array($exstensiFile, $exstensifileValid)) {
            echo "<script>
            alert('Format file tidak valid!');
            document.location.href = 'tambah-mahasiswa.php';
            </script>";
            die();
        }

        // Validasi ukuran file
        if ($ukuranFile > 2048000) { 
            echo "<script>
            alert('Format file tidak valid!');
            document.location.href = 'tambah-mahasiswa.php';
            </script>";
            die();
        }

        // Generate nama baru untuk file
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $exstensiFile;

        // Pindahkan file ke direktori yang diinginkan
        move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);

        return $namaFileBaru;
    }
}

//fungsi menghapus data mahasiswa
if (!function_exists('delete_mahasiswa')) {
    function delete_mahasiswa($id_mahasiswa){
        global $db;

        // ambil foto sesuai data yang dipilih 
        $foto = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];
        unlink('assets/img/' . $foto['foto']); // hapus foto 

        $query = "DELETE FROM mahasiswa  WHERE id_mahasiswa = $id_mahasiswa";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

if (!function_exists('update_mahasiswa')) {
    function update_mahasiswa($post){
        global $db;

        $id_mahasiswa =strip_tags($post['id_mahasiswa']);
        $nama =strip_tags($post['nama']);
        $prodi =strip_tags($post['prodi']);
        $jk =strip_tags($post['jk']);
        $telepon =strip_tags($post['telepon']);
        $alamat=$post['alamat'];
        $email =strip_tags($post['email']);
        $fotoLama = strip_tags($post['fotoLama']);
        
        // cek apakah user upload foto baru
        if ($_FILES['foto']['error'] === 4) {
            $foto = $fotoLama; 
        } else {
            $foto = upload_file(); 
        }

        // cek upload foto
        if (!$foto) {
            return false;
        }
    
        $query = "UPDATE mahasiswa SET
                    nama = '$nama',
                    prodi = '$prodi',
                    jk = '$jk',
                    telepon = '$telepon',
                    alamat = '$alamat',
                    email = '$email',
                    foto = '$foto'
                    WHERE id_mahasiswa = $id_mahasiswa";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

if (!function_exists('create_akun')) {
    function create_akun($post){
        global $db;

        $nama =strip_tags($post['nama']);
        $username =strip_tags($post['username']);
        $email =strip_tags($post['email']);
        $password =strip_tags($post['password']);
        $level =strip_tags($post['level']);

        $password=password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO akun VALUES (null, '$nama', '$username', '$email', '$password', '$level')";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

if (!function_exists('delete_akun')) {
    function delete_akun($id_akun){
        global $db;

        $query = "DELETE FROM akun  WHERE id_akun = $id_akun";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}

if (!function_exists('update_akun')) {
    function update_akun($post){
        global $db;

        $id_akun =strip_tags($post['id_akun']);
        $nama =strip_tags($post['nama']);
        $username =strip_tags($post['username']);
        $email =strip_tags($post['email']);
        $password =strip_tags($post['password']);
        $level =strip_tags($post['level']);

        $password=password_hash($password, PASSWORD_DEFAULT);

         $query = "UPDATE akun SET
                    nama = '$nama',
                    username = '$username',
                    email = '$email',
                    password = '$password',
                    level = '$level'
                    WHERE id_akun = $id_akun";
        mysqli_query($db, $query);

        return mysqli_affected_rows($db);
    }
}