<style>
    .btn-group.gap-2 {
        display: flex;
        gap: 0.5rem !important;
    }

    .btn-group.gap-2 .btn {
        border-radius: 0.25rem !important;
    }

    @media screen and (max-width: 768px) {
        .responsive-table {
            display: block;
        }

        .responsive-table thead {
            display: none;
        }

        .responsive-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
        }

        .responsive-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border: none;
            border-bottom: 1px solid #dee2e6;
        }

        .responsive-table tbody td:last-child {
            border-bottom: none;
        }

        .responsive-table tbody td::before {
            content: attr(data-label);
            font-weight: bold;
            margin-right: 1rem;
        }

        .responsive-table tbody td:last-child::before {
            align-self: flex-start;
            margin-top: 0.5rem;
        }
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Data Guru</h2>
            <button class="btn btn-success btn-sm">
                <a href="<?= BASE_URL; ?>/admin/create">
                    <i class="fas fa-plus"></i> Tambah Data Guru
                </a>
            </button>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover responsive-table" id="dataTable">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>

                            <th>Nama Guru</th>
                            <th>Nuptk</th>
                            <th>Email</th>
                            <th>No. Telp</th>
                            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data['guru'] as $guru): ?>
                            <tr>
                                <td data-label="No"><?= $no++ ?></td>
                               

                                <td data-label="Nama Guru"><?= htmlspecialchars($guru['nama_guru']??'Tidak Ada') ?></td>
                                <td data-label="NIP"><?= htmlspecialchars($guru['nip']??'Tidak Ada') ?></td>
                                <td data-label="Email"><?= htmlspecialchars($guru['email']?? 'Tidak Ada' ) ?></td>
                                <td data-label="No. Telp"><?= htmlspecialchars($guru['telp']??'Tidak Ada') ?></td>
                                <td data-label="Aksi">
                                    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                        <div class="btn-group gap-2">
                                            <a href="<?= BASE_URL ?>/admin/edit/<?= $guru['id'] ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>/admin/destroy/<?= $guru['id'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
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
        $('#dataTable').DataTable({
            "order": [[2, "asc"]], 

            "pageLength": 10,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>