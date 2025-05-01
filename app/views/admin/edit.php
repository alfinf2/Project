<div class="container">
    <div class="row justify-content-lg-center mt-5">
        <div class="col-lg-5 col-sm-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="alert-primary text-center my-4 mt-3">Edit Data Guru</h5>
                    <form id="editGuruForm" action="<?= BASE_URL; ?>/admin/update/<?= $data['guru']['id'] ?>" method="post">

                        <div class="form-group">
                            <input type="text" class="form-control" id="nama" name="inp_user"
                                placeholder="Masukkan Nama Guru" value="<?= $data['guru']['nama_guru'] ?>" required>
                        </div><br>

                        <div class="form-group">
                            <input type="number" class="form-control" min="0" id="nip" name="inp_nip"
                                placeholder="Masukkan Nuptk" value="<?= $data['guru']['nip'] ?>" required>
                        </div><br>

                        <div class="form-group">
                            <textarea class="form-control" id="alamat" name="alamat" rows="4"
                                value="<?= $data['guru']['alamat'] ?>" placeholder="Masukkan Alamat..."></textarea>
                        </div><br>

                        <div class="form-group">
                            <input type="number" class="form-control" id="telp" name="telp"
                                placeholder="Masukkan No. Telp" value="<?= $data['guru']['telp'] ?>" >
                        </div><br>

                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan Email" value="<?= $data['guru']['email'] ?>" >
                        </div><br>


                        <div class="form-group mt-4 d-flex justify-content-between">
                            <input type="submit" name="formtambah" value="Simpan" class="btn btn-primary btn-lg"
                                style="width: 32%;">
                            <a href="<?= BASE_URL; ?>/admin/index" class="btn btn-secondary btn-lg"
                                style="width: 32%;">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('editGuruForm').addEventListener('submit', function(e) {
    e.preventDefault();


    const requiredFields = [
        { id: 'nama', label: 'Nama Guru' },
        { id: 'nip', label: 'NUPTK' },
    ];


    const emptyFields = [];
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (!element.value.trim()) {
            emptyFields.push(field.label);
            element.classList.add('is-invalid');
        } else {
            element.classList.remove('is-invalid');
        }
    });


    if (emptyFields.length > 0) {
        Swal.fire({
            title: 'Peringatan!',
            html: `Data berikut belum diisi:<br><br>${emptyFields.join('<br>')}`,
            icon: 'warning',
            confirmButtonColor: '#ffc107'
        });
        return;
    }


    Swal.fire({
        title: 'Menyimpan Perubahan...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });


    this.submit();
});
</script>

<style>
.is-invalid {
    border: 1px solid #dc3545 !important;
    background-color: #fff8f8 !important;
}

.is-invalid:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}
</style>