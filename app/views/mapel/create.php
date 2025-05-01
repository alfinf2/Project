<div class="container">
    <div class="row justify-content-lg-center mt-5">
        <div class="col-lg-5 col-sm-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="alert-primary text-center my-4 mt-3">Tambah Mapel</h5>
                    <form id="createSiswaForm" action="<?= BASE_URL; ?>/mapel/store" method="POST"
                        enctype="multipart/form-data">

                        <div class="form-group">
                            <input type="text" class="form-control" id="mapel" name="inp_mapel"
                                placeholder="Masukkan Nama Mapel">
                        </div><br>


                        <div class="form-group mt-4 d-flex justify-content-between">
                            <input type="submit" name="formtambah" value="Simpan" class="btn btn-primary btn-lg"
                                style="width: 32%;">
                            <input type="reset" value="Reset" class="btn btn-danger btn-lg" style="width: 32%;">
                            <a href="<?= BASE_URL ?>/mapel/index" class="btn btn-secondary btn-lg"
                                style="width: 38%;">Kembali</a>
                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('createSiswaForm').addEventListener('submit', function (e) {
        e.preventDefault();


        Swal.fire({
            title: 'Menyimpan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {

                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                }

                return { status: true, message: 'Data berhasil ditambahkan' };
            })
            .then(data => {
                Swal.fire({
                    title: data.status ? 'Berhasil!' : 'Gagal!',
                    text: data.message || (data.status ? 'Data siswa berhasil ditambahkan' : 'Gagal menambahkan mapel'),
                    icon: data.status ? 'success' : 'error',
                    confirmButtonColor: data.status ? '#4CAF50' : '#f44336'
                }).then((result) => {
                    if (result.isConfirmed && data.status) {
                        window.location.href = '<?= BASE_URL ?>/mapel/index';
                    }
                });
            })
            .catch(error => {

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data mapel berhasil ditambahkan',
                    icon: 'success',
                    confirmButtonColor: '#4CAF50'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= BASE_URL ?>/mapel/index';
                    }
                });
            });
    });
</script>