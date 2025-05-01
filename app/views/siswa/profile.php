<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center space-x-4 mb-6">
            <div class="relative group cursor-pointer">
                <img id="profileImage"
                    class="h-24 w-24 rounded-full object-cover group-hover:opacity-75 transition-opacity" src="<?= !empty($data['siswa']['image'])
                        ? BASE_URL . '/img/profile/' . $data['siswa']['image']
                        : BASE_URL . '/img/profile/Premium Vector _ High school students posing waving hands.jpg' ?>"
                    alt="Profile Picture">
                <input type="file" id="imageUpload" accept="image/png,image/jpeg,image/jpg" class="hidden">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div
                        class="hidden group-hover:flex bg-black bg-opacity-50 rounded-full h-full w-full items-center justify-center">
                        <i class="fas fa-camera text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div>
                <h1 class="text-2xl font-bold"><?= $data['siswa']['nama'] ?></h1>
                <p class="text-gray-600">Kelas: <?= $data['siswa']['nama_kelas'] ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-3">
                <div class="border-b pb-2">
                    <label class="text-gray-600 text-sm">NISN</label>
                    <p class="font-medium"><?= $data['siswa']['nisn'] ?></p>
                </div>

                <div class="border-b pb-2">
                    <label class="text-gray-600 text-sm">Tanggal Lahir</label>
                    <p class="font-medium"><?= $data['siswa']['tgllahir'] ?></p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="border-b pb-2">
                    <label class="text-gray-600 text-sm">Alamat</label>
                    <p class="font-medium"><?= $data['siswa']['alamat'] ?></p>
                </div>

                <div class="border-b pb-2">
                    <label class="text-gray-600 text-sm">No. Telepon</label>
                    <p class="font-medium"><?= $data['siswa']['telp'] ?></p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">

            <button onclick="showPasswordModal()"
                class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors duration-200">
                <i class="fas fa-key mr-2"></i>Ganti Password
            </button>

            <button onclick="confirmDeleteImage()"
                class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors duration-200">
                <i class="fas fa-trash mr-2"></i>Hapus Foto
            </button>

            <a href="<?= BASE_URL ?>"
                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors duration-200">
                Kembali
            </a>
        </div>


        <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 w-96">
                <h3 class="text-lg font-bold mb-4">Ganti Password</h3>

                <form id="passwordForm" action="<?= BASE_URL ?>/password/updateSiswa" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password Lama</label>
                        <input type="password" name="old_password" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" name="new_password" required minlength="6"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" required minlength="6"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="hidePasswordModal()"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<script>
    function showPasswordModal() {
        document.getElementById('passwordModal').classList.remove('hidden');
    }

    function hidePasswordModal() {
        document.getElementById('passwordModal').classList.add('hidden');
    }


    document.getElementById('passwordForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const newPassword = this.querySelector('[name="new_password"]').value;
        const confirmPassword = this.querySelector('[name="confirm_password"]').value;

        if (newPassword !== confirmPassword) {
            Swal.fire({
                title: 'Error!',
                text: 'Password baru dan konfirmasi password tidak cocok!',
                icon: 'error',
                confirmButtonColor: '#EF4444'
            });
            return;
        }

        fetch(this.action, {
            method: 'POST',
            body: new FormData(this)
        })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#10B981'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            hidePasswordModal();
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mengubah password',
                    icon: 'error',
                    confirmButtonColor: '#EF4444'
                });
            });
    });

    document.getElementById('passwordModal').addEventListener('click', function (e) {
        if (e.target === this) {
            hidePasswordModal();
        }
    });


    document.querySelector('.relative.group').addEventListener('click', function () {
        document.getElementById('imageUpload').click();
    });

    document.getElementById('imageUpload').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Hanya file JPG, JPEG, dan PNG yang diperbolehkan',
                    icon: 'error',
                    confirmButtonColor: '#EF4444'
                });
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Ukuran file maksimal 5MB',
                    icon: 'error',
                    confirmButtonColor: '#EF4444'
                });
                return;
            }

            const formData = new FormData();
            formData.append('profile_image', file);

            Swal.fire({
                title: 'Mengupload...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('<?= BASE_URL ?>/siswa/uploadImage', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    Swal.close();
                    if (data.status) {
                        document.getElementById('profileImage').src = '<?= BASE_URL ?>/img/profile/' + data.filename;
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Foto profil berhasil diperbarui',
                            icon: 'success',
                            confirmButtonColor: '#10B981'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Gagal mengupload gambar',
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                });
        }
    });

    function confirmDeleteImage() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Foto profil akan dikembalikan ke default!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('<?= BASE_URL ?>/siswa/deleteImage', {
                    method: 'POST'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Foto profil berhasil dihapus',
                                icon: 'success',
                                confirmButtonColor: '#10B981'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message);
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: error.message || 'Gagal menghapus foto profil',
                            icon: 'error',
                            confirmButtonColor: '#EF4444'
                        });
                    });
            }
        });
    }

</script>