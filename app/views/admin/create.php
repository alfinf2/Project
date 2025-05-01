<div class="container">
    <div class="row justify-content-lg-center mt-5">
        <div class="col-lg-5 col-sm-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="alert-primary text-center my-4 mt-3">Tambah Data Guru</h5>
                    <form id="createGuruForm" action="<?= BASE_URL; ?>/admin/store" method="post"
                        enctype="multipart/form-data">

                        <div class="form-group">
                            <input type="text" class="form-control" id="nama" name="inp_user"
                                placeholder="Masukkan Nama Guru *">
                        </div><br>

                        <div class="form-group">
                            <input type="number" class="form-control" min="0" id="nip" name="inp_nip"
                                placeholder="Masukkan Nuptk Guru *">
                        </div><br>

                        <div class="form-group">
                            <textarea class="form-control" id="alamat" name="alamat" rows="4"
                                placeholder="Masukkan Alamat..."></textarea>
                        </div><br>

                        <div class="form-group">
                            <input type="number" class="form-control" id="telp" name="telp"
                                placeholder="Masukkan No Telepon">
                        </div><br>

                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan Alamat Email">
                        </div><br>


                        <div class="form-group gap-2 mt-4 d-flex justify-content-between">
                            <input type="submit" name="formtambah" value="Simpan" class="btn btn-primary btn-lg"
                                style="width: 32%;">
                            <input type="reset" value="Reset" class="btn btn-danger btn-lg" style="width: 32%;">
                            <a href="<?= BASE_URL ?>/Admin/index" class="btn btn-secondary btn-lg"
                                style="width: 35%;">Kembali</a>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('createGuruForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const requiredFields = [
        { id: 'nama', label: 'Nama Guru' },
        { id: 'nip', label: 'NUPTK' },
    ];


    const emptyRequiredFields = [];
    requiredFields.forEach(field => {
        const element = document.getElementById(field.id);
        if (!element.value.trim()) {
            emptyRequiredFields.push(field.label);
            element.classList.add('is-invalid');
        } else {
            element.classList.remove('is-invalid');
        }
    });

    if (emptyRequiredFields.length > 0) {
        Swal.fire({
            title: 'Peringatan!',
            html: `Data wajib berikut belum diisi:<br><br>${emptyRequiredFields.join('<br>')}`,
            icon: 'warning',
            confirmButtonColor: '#ffc107'
        });
        return;
    }

    Swal.fire({
        title: 'Menyimpan...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const formData = new FormData(this);

    const optionalFields = ['alamat', 'telp', 'email'];
    optionalFields.forEach(field => {
        if (!formData.get(field)) {
            formData.set(field, '');
        }
    });

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            title: data.status ? 'Berhasil!' : 'Gagal!',
            text: data.message,
            icon: data.status ? 'success' : 'error',
            confirmButtonColor: data.status ? '#4CAF50' : '#f44336'
        }).then((result) => {
            if (result.isConfirmed && data.status) {
                window.location.href = '<?= BASE_URL ?>/Admin/index';
            }
        });
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Terjadi kesalahan saat menyimpan data',
            icon: 'error',
            confirmButtonColor: '#f44336'
        });
    });
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