<div class="min-h-screen flex flex-col justify-start py-6">
    <div class="relative sm:max-w-xl sm:mx-auto mt-4">
        <div class="relative px-4 py-8 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-8">
            <div class="max-w-md mx-auto">

                <div class="flex items-center space-x-5 mb-6">
                    <div class="rounded-full bg-green-100 p-2">
                        <i class="fas fa-key text-green-500 text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-700">Ganti Password</h2>
                </div>

                <form id="passwordForm" action="<?= BASE_URL; ?>/password/update" method="POST" class="space-y-6">

                    <div class="space-y-4">
                        <div class="relative">
                            <label class="text-gray-600 mb-2 block">Password Lama</label>
                            <div class="relative">
                                <input type="password" name="old_password" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200">
                                <button type="button"
                                    class="toggle-password absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="text-gray-600 mb-2 block">Password Baru</label>
                            <div class="relative">
                                <input type="password" name="new_password" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200">
                                <button type="button"
                                    class="toggle-password absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="relative">
                            <label class="text-gray-600 mb-2 block">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input type="password" name="confirm_password" required
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200">
                                <button type="button"
                                    class="toggle-password absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="flex space-x-4 pt-4 border-t">
                        <a href="<?= BASE_URL; ?>/absensi/index"
                            class="flex-1 px-6 py-3 rounded-lg text-gray-700 bg-gray-100 hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <button type="submit"
                            class="flex-1 px-6 py-3 rounded-lg text-white bg-green-500 hover:bg-green-600 transition duration-200 flex items-center justify-center">
                            <i class="fas fa-check mr-2"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });


    document.getElementById('passwordForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#10B981',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        }
                    }).then(() => {
                        window.location.href = '<?= BASE_URL ?>/absensi/index';
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                }
            });
    });


    <?php if (isset($_SESSION['flash'])): ?>
        Swal.fire({
            title: '<?= $_SESSION['flash']['type'] === 'success' ? 'Berhasil!' : 'Gagal!' ?>',
            text: '<?= $_SESSION['flash']['message'] ?>',
            icon: '<?= $_SESSION['flash']['type'] ?>',
            confirmButtonColor: '<?= $_SESSION['flash']['type'] === 'success' ? '#10B981' : '#EF4444' ?>'
        });
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
</script>