<?php
session_start();
if(!isset($_SESSION['login'])) {
    echo "<script>
              alert('Anda Harus Login Terlebih Dahulu');
              document.location.href = 'login.php';
              </script>";
              exit;
}

$title = 'ubah Mahasiswa';
// include 'config/database.php';
// include 'config/controller.php';
include 'layout/header.php';
$id_mahasiswa = (int)$_GET['id_mahasiswa'];
$mahasiswa = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa")[0];


if (isset($_POST['ubah'])) {
    if (update_mahasiswa($_POST) > 0) {
        echo "<script>
              alert('Data Mahasiswa Berhasil Diubah');
              document.location.href = 'mahasiswa.php';
                </script>";
    } else {
        echo "<script>
              alert('Data Mahasiswa Gagal Diubah');
              document.location.href = 'mahasiswa.php';
                </script>";
    }
}
?>

<div class="container mt-5">
    <h1>ubah Mahasiswa</h1>
    <hr>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_mahasiswa" value="<?= $mahasiswa['id_mahasiswa'] ?>">
        <input type="hidden" name="foto_lama" value="<?= $mahasiswa['foto'] ?>">

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Mahasiswa..." required value="<?= $mahasiswa['nama'] ?>">
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="prodi" class="form-label">Program Studi</label>
                <select name="prodi" id="prodi" class="form-control" required>
                    <?php $prodi = $mahasiswa['prodi']; ?>
                    <option value="Teknik Informatika" <?= $prodi == 'Teknik Informatika' ? 'selected' : null ?>>Teknik Informatika</option>
                    <option value="Teknik Mesin" <?= $prodi == 'Teknik Mesin' ? 'selected' : null ?>>Teknik Mesin</option>
                    <option value="Teknik Listrik" <?= $prodi == 'Teknik Listrik' ? 'selected' : null ?>>Teknik Listrik</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label for="jk" class="form-label">Jenis Kelamin</label>
                <select name="jk" id="jk" class="form-control" required>

                   <?php $jk = $mahasiswa['jk']; ?>
                    <option value="Laki-laki" <?= $jk == 'Laki-laki' ? 'selected' : null ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $jk == 'Perempuan' ? 'selected' : null ?>>Perempuan</option>
                </select>
                </div>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Telepon Mahasiswa..." required value="<?= $mahasiswa['telepon'] ?>">
        </div>
         <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control"><?= $mahasiswa['alamat']  ?></textarea>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email Mahasiswa..." required value="<?= $mahasiswa['email'] ?>">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" placeholder="foto ...">
            <p>
                <small>Gambar Sebelumnya</small>
            </p>
             <img src="assets/img/<?= $mahasiswa['foto'] ?>" alt="foto" width="100px">
        </div>
        <button type="submit" class="btn btn-primary" style="float: right;" name="ubah">ubah</button>    
        
</div>
<?php include 'layout/footer.php'; ?>