<div class="container">
    <div class="row justify-content-lg-center mt-5">
        <div class="col-lg-5 col-sm-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="alert-primary text-center my-4 mt-3">Tambah Data Siswa</h5>
                    <form id="createSiswaForm" action="<?= BASE_URL; ?>/siswa/store" method="POST"
                        enctype="multipart/form-data">

                        <div class="form-group">
                            <input type="number" required class="form-control" min="0" id="nip" name="inp_nis"
                                placeholder="Masukkan Nisn Siswa">
                        </div><br>

                        <div class="form-group">
                            <input type="text" required class="form-control" id="nama" name="inp_nama"
                                placeholder="Masukkan Nama Siswa">
                        </div><br>

                        <div class="form-group">
                            <select class="form-control" required id="mapel" name="inp_kelas">
                                <option value="kelas">Pilih Kelas</option>
                                <?php foreach ($data['kelas'] as $mapel): ?>
                                    <option value="<?= $mapel['id'] ?>"><?= $mapel['nama_kelas'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div><br>

                        <div class="form-group">
                            <textarea class="form-control" id="alamat" name="alamat" rows="4"
                                placeholder="Masukkan Alamat..."></textarea>
                        </div><br>

                        <div class="form-group">
                            <h3>Masukkan Tanggal Lahir</h3>
                            <input type="date" class="form-control" id="tgllahir" name="tgllahir"
                                placeholder="Masukkan Tanggal Lahir">
                        </div><br>

                        <div class="form-group">
                            <input type="number" class="form-control" id="telp" name="telp"
                                placeholder="Masukkan No Telepon">
                        </div><br>


                        <div class="form-group mt-4 d-flex justify-content-between">
                            <input type="submit" name="formtambah" value="Simpan" class="btn btn-primary btn-lg"
                                style="width: 32%;">
                            <input type="reset" value="Reset" class="btn btn-danger btn-lg" style="width: 32%;">
                            <a href="<?= BASE_URL ?>/Admin/siswa" class="btn btn-secondary btn-lg"
                                style="width: 35%;">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="nisnModal" tabindex="-1" aria-labelledby="nisnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="nisnModalLabel">Peringatan!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>NISN sudah terdaftar! Silakan gunakan NISN lain.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('createSiswaForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (!data.status && data.error === 'duplicate_nisn') {

                    const nisnModal = new bootstrap.Modal(document.getElementById('nisnModal'));
                    nisnModal.show();
                } else if (data.status) {
                    window.location.href = '<?= BASE_URL ?>/Admin/siswa';
                } else {

                    window.location.href = '<?= BASE_URL ?>/admin/siswa';

                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>