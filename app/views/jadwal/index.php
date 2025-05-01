<style>
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-container {
            margin: -8px;
        }

        td,
        th {
            padding: 0.75rem 1rem;
        }

        .mobile-info {
            display: block;
            margin-top: 0.25rem;
        }
    }

    /* Custom scrollbar for better UX */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
<div class="flex-1 p-6 overflow-y-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Data Jadwal Pelajaran</h2>
            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                <button onclick="window.location.href='<?= BASE_URL ?>/jadwal/create'"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-2"></i>Tambah Jadwal
                </button>
            <?php endif; ?>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Hari
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mapel
                        </th>
                        <th
                            class="hidden md:table-cell px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Guru
                        </th>
                        <th
                            class="hidden md:table-cell px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sesi
                        </th>
                        <th
                            class="hidden md:table-cell px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Waktu
                        </th>
                        <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $no = 1;
                    foreach ($data['jadwal'] as $jadwal): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                <?= $no++ ?>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                <?= $jadwal['hari'] ?>
                            </td>
                            <td class="px-3 py-2">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-900"> <?= $jadwal['nama_mapel'] ?> </span>

                                    <div class="md:hidden space-y-1 mt-1">
                                        <span class="text-xs text-gray-500"> <?= $jadwal['nama_kelas'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden md:table-cell px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                <?= $jadwal['nama_kelas'] ?>
                            </td>
                            <td class="px-3 py-2">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-900"><?= $jadwal['nama_guru'] ?></span>

                                    <div class="md:hidden space-y-1 mt-1">
                                        <span class="text-xs text-gray-500">Sesi <?= $jadwal['jam'] ?></span>
                                        <div class="flex items-center space-x-1 text-xs text-gray-500">
                                            <span><?= $jadwal['waktu_mulai'] ?> - <?= $jadwal['waktu_selesai'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden md:table-cell px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                Sesi <?= $jadwal['jam'] ?>
                            </td>
                            <td class="hidden md:table-cell px-3 py-2 whitespace-nowrap text-sm text-gray-900">
                                <?= $jadwal['waktu_mulai'] ?> - <?= $jadwal['waktu_selesai'] ?>
                            </td>
                            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                                <td class="px-3 py-2 text-left">
                                    <button
                                        onclick="window.location.href='<?= BASE_URL ?>/jadwal/edit/<?= $jadwal['jadwal_id'] ?>'"
                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200 p-1">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href='<?= BASE_URL ?>/jadwal/destroy/<?= $jadwal['jadwal_id'] ?>'
                                        class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data?')"
                                        class="text-red-600 hover:text-red-900 transition-colors duration-200 p-1">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function deleteSchedule() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data jadwal akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                

                Swal.fire({
                    title: 'Menghapus...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });


            }
        });
    }
</script>