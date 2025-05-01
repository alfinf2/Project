<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>
        Absensi Login
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="icon" type="image/png" href="<?=BASE_URL?>/img/favicon-32x32.png">

</head>

<body class="bg-white flex items-center justify-center min-h-screen">
    <div class="flex flex-col md:flex-row items-center justify-center w-full max-w-4xl mx-auto">
        <div class="w-full md:w-1/2 bg-yellow-400 p-8 rounded-lg">
            <div class="text-center">
                <h1 class="text-2xl font-bold mb-4">
                    Assalamualaikum
                </h1>
                <img alt="School logo" class="mx-auto mb-4" height="100" src="<?= BASE_URL; ?>/img/logo.png"
                    width="200" />
                <h2 class="text-xl font-bold mb-2">
                    Selamat Datang
                </h2>
                <p class="mb-4">
                    Silahkan Login &amp; Pastikan Hadir Tepat Waktu
                </p>
                <hr class="border-t-2 border-green-600 mb-4" />
                <h3 class="text-lg font-bold mb-4 text-green-600">
                    Masuk
                </h3>
            </div>
            <form id="frm-login" action="<?= BASE_URL ?>/login/proses" method="post" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div>
                    <label class="block text-sm font-medium" for="nisn">
                        Nomor Induk Siswa Nasional
                    </label>
                    <input class="w-full p-2 border rounded-2xl" id="nisn" name="nisn" id="nisn" autocomplete="off"
                        required placeholder="Masukkan NISN" />
                </div>
                <div>
                    <label class="block text-sm font-medium" for="password">
                        Password
                    </label>
                    <div class="relative">
                        <input class="w-full p-2 border rounded-2xl" id="password" name="password" required
                            placeholder="Masukkan Password" type="password" />
                        <i class="fas fa-eye absolute right-3 top-3 text-gray-500">
                        </i>
                    </div>
                </div>
                <div class="text-left">
                    <button type="button"
                        class="text-sm text-blue-700 hover:text-blue-800 hover:underline transition-colors duration-200"
                        onclick="showForgotPasswordAlert()">
                        Lupa Password ?
                    </button>
                </div>
                <button class="w-full bg-green-700 text-white p-2 rounded-lg" type="submit"
                    onclick="document.getElementById('frm-login').submit()">
                    Masuk
                </button>
            </form>
            <p class="text-center text-xs mt-4">
                © <?= date('Y') ?> SMP Muhammadiyah 16 Lubuk Pakam
                <br />
                "Sesungguhnya sholatku, ibadahku, hidupku dan matiku hanya untuk Allah"
            </p>
        </div>
    </div>




    <script>

        document.addEventListener('DOMContentLoaded', function () {
           
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('.fa-eye');

            eyeIcon.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });

            const loginForm = document.getElementById('frm-login');
            loginForm.addEventListener('submit', function (e) {
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = 'Mohon Tunggu...';

                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Masuk';
                }, 10000);
            });
        });


        function showForgotPasswordAlert() {
            Swal.fire({
                title: 'Lupa Password?',
                html: '<div class="text-gray-600">Silakan hubungi guru Anda untuk mengatur ulang password</div>',
                icon: 'info',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#047857',
                width: '400px',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
          
            <?php if (isset($_SESSION['flash'])) : ?>
                Swal.fire({
                    icon: '<?= $_SESSION['flash']['type'] ?>',
                    title: '<?= $_SESSION['flash']['title'] ?>',
                    text: '<?= $_SESSION['flash']['message'] ?>',
                    confirmButtonColor: '#047857',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            <?php 
                unset($_SESSION['flash']);
            endif; ?>

            const loginForm = document.getElementById('frm-login');
            loginForm.addEventListener('submit', function (e) {
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mohon Tunggu...';

                submitButton.classList.add('opacity-75', 'cursor-not-allowed');

                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Masuk';
                    submitButton.classList.remove('opacity-75', 'cursor-not-allowed');
                }, 10000);
            });
        });
    </script>
</body>

</html>