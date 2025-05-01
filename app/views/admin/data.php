<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Siswa</h5>
            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                <div class="btn-group">
                    <button class="btn btn-success btn-sm me-2"
                        onclick="window.location.href = '<?= BASE_URL ?>/siswa/create/'">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </button>
                    <button class="btn btn-secondary btn-sm"
                        onclick="window.location.href = '<?= BASE_URL ?>/Admin/siswa/'">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataSiswa">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data['siswa'] as $siswa): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $siswa['nisn'] ?></td>
                                <td><?= $siswa['nama'] ?></td>
                                <td><?= $siswa['nama_kelas'] ?></td>
                                <td><?= $siswa['alamat'] ?></td>
                                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                    <td>
                                        <div class="btn-group gap-2 ">
                                            <a href="<?= BASE_URL ?>/siswa/edit/<?= $siswa['id'] ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>/siswa/destroy/<?= $siswa['id'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#dataSiswa').DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            },
            "responsive": true,
            "ordering": true,
            "pageLength": 10,
            "order": [[2, 'asc']] 

        });
    });

    function editSiswa(id) {
        window.location.href = `<?= BASE_URL ?>/admin/editSiswa/${id}`;
    }

    function deleteSiswa(id) {
        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            window.location.href = `<?= BASE_URL ?>/admin/destroy${id}`;
        }
    }
</script>

<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .btn-group .btn {
        border-radius: 4px;
    }

    .card {
        border: none;
        border-radius: 8px;
    }

    .card-header {
        border-radius: 8px 8px 0 0 !important;
    }
</style>