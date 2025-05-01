<div class="container">
    <div class="row justify-content-lg-center mt-5">
        <div class="col-lg-5 col-sm-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="alert-primary text-center my-4 mt-3">Edit Data Siswa</h5>
                    <form action="<?= BASE_URL; ?>/siswa/update/<?= $data['siswa']['id'] ?>" method="post">

                        <div class="form-group">
                            <input type="number" required class="form-control" min="0" id="nis" name="inp_nis"
                                placeholder="Masukkan Nisn Siswa" value="<?= $data['siswa']['nisn'] ?>">
                        </div><br>

                        <div class="form-group">
                            <input type="text" required class="form-control" id="nama" name="inp_nama"
                                placeholder="Masukkan Nama Siswa" value="<?= $data['siswa']['nama'] ?>">
                        </div><br>

                        <div class="form-group">
                            <select class="form-control" id="kelas" required name="inp_kelas">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($data['kelas'] as $kelas): ?>
                                    <option value="<?= $kelas['id'] ?>" 
                                    <?= ($data['siswa']['id_kelas'] == $kelas['id']) ? 'selected' : '' ?>>
                                        <?= $kelas['nama_kelas'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div><br>

                        <div class="form-group">
                            <textarea class="form-control" id="alamat" name="alamat" rows="4"
                                value="<?= $data['siswa']['alamat'] ?>" placeholder="Masukkan Alamat..."></textarea>
                        </div><br>

                        <div class="form-group">
                            <h3>Masukkan Tanggal Lahir</h3>
                            <input type="date" class="form-control" id="tgllahir" name="tgllahir"
                                value="<?= $data['siswa']['tgllahir'] ?>">
                        </div><br>
                        <div class="form-group">
                            <h3>Masukkan No Telp</h3>
                            <input type="number" class="form-control" id="telp" name="telp"
                                value="<?= $data['siswa']['telp'] ?>">
                        </div><br>



                        <div class="form-group mt-4 d-flex justify-content-between">
                            <input type="submit" name="formtambah" value="Simpan" class="btn btn-primary btn-lg"
                                style="width: 32%;">
                            <a href="<?= BASE_URL; ?>/Admin/siswa" class="btn btn-secondary btn-lg"
                                style="width: 32%;">Kembali</a>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault();

        const nisn = document.getElementById('nis').value.trim();
        const nama = document.getElementById('nama').value.trim();
        const kelas = document.getElementById('kelas').value;

        
        if (!nisn || !nama || !kelas) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap!',
                text: 'NISN, Nama, dan Kelas harus diisi!',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        Swal.fire({
            title: 'Menyimpan Data...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        this.submit();
    });
</script>