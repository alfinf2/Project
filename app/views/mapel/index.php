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

    .guru-list {
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }

    .guru-badge {
        background-color: #e2e8f0;
        padding: 0.25rem 0.75rem;
        border-radius: 999px;
        font-size: 0.875rem;
        white-space: nowrap;
    }

    @media screen and (max-width: 768px) {
        .guru-list {
            justify-content: flex-end;
            flex: 1;
        }

        .guru-list::before {
            display: none !important;
        }
    }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Data Mapel</h2>
            <button class="btn btn-success btn-sm">
                <a href="<?= BASE_URL; ?>/mapel/create">
                    <i class="fas fa-plus"></i> Tambah Mapel
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
                            <th>Nama Mapel</th>
                            <th>Nama Guru</th>
                            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data['mapel'] as $guru): ?>
                            <tr>
                                <td data-label="No"><?= $no++ ?></td>
                                <td data-label="Nama Mapel"><?= htmlspecialchars($guru['nama_mapel'] ?? '') ?></td>
                                <td data-label="Nama Guru" class="guru-list">
                                    <?php
                                    if (!empty($guru['guru_names'])) {
                                        $guruArray = explode('| |' , $guru['guru_names']); 
                                        foreach ($guruArray as $index => $namaGuru) {
                                            $namaGuru = trim($namaGuru);
                                            if (!empty($namaGuru)) {
                                                echo '<span class="guru-badge">' . htmlspecialchars($namaGuru) . '</span>';
                                            }
                                        }
                                    } else {
                                        echo '<span class="text-muted">-</span>';
                                    }
                                    ?>
                                </td>
                                <td data-label="Aksi">
                                    <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                        <div class="btn-group gap-2">
                                            <a href="<?= BASE_URL ?>/mapel/edit/<?= $guru['id_mapel'] ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>/mapel/destroy/<?= $guru['id_mapel'] ?>"
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