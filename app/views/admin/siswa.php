

<main class="flex-1 p-6 overflow-y-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Data Siswa</h2>
            <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                <button onclick="window.location.href='<?= BASE_URL ?>/siswa/create'"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-plus mr-2"></i>Tambah Siswa
                </button>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700" for="kelas">
                    Filter Kelas
                </label>
                <select id="kelas" name="kelas"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($data['kelas'] as $kelas): ?>
                        <option value="<?= htmlspecialchars($kelas['id']); ?>">
                            <?= htmlspecialchars($kelas['nama_kelas']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-end">
                <button id="cariButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </div>


        <div class="overflow-x-auto mt-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                            No</th>
                        <th
                            class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500  tracking-wider">
                            Nisn</th>
                        <th
                            class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500  tracking-wider hidden md:table-cell">
                            Nama</th>
                        <th
                            class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500  tracking-wider hidden sm:table-cell">
                            Kelas</th>
                        <th
                            class="px-3 py-2 md:px-6 md:py-3 text-left text-xs font-medium text-gray-500  tracking-wider hidden lg:table-cell">
                            Alamat</th>
                            <?php if($_SESSION['user']['role'] == 'admin'): ?>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500  tracking-wider">Aksi
                        </th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="siswaTableBody">
                    <?php if (!empty($data['siswa'])): ?>
                        <?php $no = 1;
                        foreach ($data['siswa'] as $siswa): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm"><?= $no++ ?></td>
                                <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm">
                                    <div class="flex flex-col md:flex-row md:items-center">
                                        <span><?= htmlspecialchars($siswa['nisn']??'') ?></span>
                                        <span
                                            class="md:hidden text-gray-500 text-xs mt-1"><?= htmlspecialchars($siswa['nama']??'') ?></span>
                                        <span
                                            class="md:hidden text-gray-500 text-xs mt-1"><?= htmlspecialchars($siswa['nama_kelas']??'') ?></span>
                                    </div>
                                </td>
                                <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm hidden md:table-cell">
                                    <?= htmlspecialchars($siswa['nama']??'') ?>
                                </td>
                                <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm hidden sm:table-cell">
                                    <?= htmlspecialchars($siswa['nama_kelas']??'') ?>
                                </td>
                                <td class="px-3 py-2 md:px-6 md:py-4 whitespace-nowrap text-sm hidden lg:table-cell">
                                    <?= htmlspecialchars($siswa['alamat']??'') ?>
                                </td>

                                <?php if ($_SESSION['user']['role'] == 'admin'): ?>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="<?= BASE_URL ?>/siswa/edit/<?= $siswa['id'] ?>"
                                            class="text-yellow-600 hover:text-yellow-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/siswa/destroy/<?= $siswa['id'] ?>"
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Yakin ingin menghapus data?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-3 py-2 md:px-6 md:py-4 text-center text-gray-500 text-sm">
                                Tidak ada data siswa
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        @media (max-width: 640px) {
            .table-container {
                margin: -8px;
            }

            table {
                font-size: 0.875rem;
            }

            td,
            th {
                padding: 0.5rem 0.75rem;
            }

            .mobile-stack {
                display: block;
            }

            .mobile-stack>span:first-child {
                font-weight: 500;
            }

            .mobile-stack>span:last-child {
                color: #6b7280;
                font-size: 0.875rem;
            }
        }


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

</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cariButton = document.getElementById("cariButton");
        const kelasSelect = document.getElementById("kelas");

        cariButton.addEventListener("click", function () {
            const selectedKelas = kelasSelect.value;

            if (!selectedKelas) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Silakan pilih kelas terlebih dahulu',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#3085d6',
                    customClass: {
                        container: 'my-swal'
                    }
                });
                return;
            }


            Swal.fire({
                title: 'Memuat Data...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });


            setTimeout(() => {
                window.location.href = `<?= BASE_URL ?>/admin/data/${selectedKelas}`;
            }, 500);
        });
    });
</script>

<style>
    .my-swal {
        z-index: 9999;
    }

    .swal2-popup {
        font-size: 0.9rem;
    }
</style>