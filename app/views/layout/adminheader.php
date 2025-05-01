<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/schmich/instascan-builds@master/instascan.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/favicon-32x32.png">
    <script src="https://cdn.tailwindcss.com"></script>

    <title><?= APP_NAME ?></title>

    <style>
        .fa-chevron-down {
            transform: rotate(0deg);
            transition: transform 0.2s ease-in-out;
        }

        #downloadOptions {
            transform-origin: top;
            transition: all 0.2s ease-in-out;
        }

        .sidebar-transition {
            transition: all 0.3s ease-in-out !important;
        }

        body.sidebar-open {
            overflow: hidden !important;
        }

        .mobile-menu {
            transform: translateX(-100%) !important;
            transition: transform 0.3s ease-in-out !important;
        }

        .mobile-menu.active {
            transform: translateX(0) !important;
        }

        #sidebar {
            background-color: rgb(31, 41, 55) !important;
            color: white !important;
        }

        .hover\:bg-green-600:hover {
            background-color: rgb(22, 163, 74) !important;
        }

        @media (max-width: 1066px) {
            .header-title {
                font-size: 1.2rem !important;
            }
        }
    </style>
</head>

<body class="flex flex-col min-h-screen bg-gray-100">
    <header class="bg-green-700 text-white p-3 flex items-center justify-between shadow-md z-50 fixed w-full top-0">
        <div class="flex items-center space-x-3">
            <button class="text-white p-2 rounded-lg hover:bg-green-600 md:hidden" id="menu-button">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <img alt="School Logo" class="h-10 w-10" src="<?= BASE_URL; ?>/img/logo.png" />
            <h1 class="text-xl font-bold md:block hidden">
                SMP MUHAMMADIYAH 16 LUBUK PAKAM
            </h1>
            <h1 class="text-lg font-bold md:hidden">
                SMP MUH 16
            </h1>
        </div>
    </header>

    <div class="flex h-screen pt-16">
        <div id="sidebar-backdrop"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden transition-opacity"></div>

        <aside id="sidebar" class="fixed md:static inset-y-0 left-0 z-40 
                      bg-gray-800 text-white w-72 md:w-64
                      transform -translate-x-full md:translate-x-0
                      transition-transform duration-300 ease-in-out
                      h-full md:h-[calc(100vh-4rem)]
                      overflow-y-auto shadow-lg">

            <div class="p-4 border-b border-gray-700">
                <div class="flex items-center space-x-4">
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                            <img class="h-10 w-10 rounded-full" src="<?= BASE_URL; ?>/img/admin.png" alt="admin">
                        <?php else: ?>
                            <?php if (isset($_SESSION['user'])): ?>
                                <img class="h-10 w-10 rounded-full" src="<?= BASE_URL; ?>/img/guru.png" alt="Guru">
                            <?php else: ?>
                                <!-- Upload Image Button -->
                                <!-- <form action="<?= BASE_URL; ?>/profile/upload" method="post" enctype="multipart/form-data"
                                    class="hidden" id="uploadForm">
                                    <input type="file" name="profile_image" id="profileImage" accept="image/*" class="hidden">
                                </form>
                                <button onclick="document.getElementById('profileImage').click()"
                                    class="text-xs text-gray-400 hover:text-white ml-2">
                                    <i class="fas fa-camera"></i>
                                </button> -->
                            <?php endif; ?>
                        <?php endif; ?>
                        <div>
                            <h2 class="text-lg font-semibold">
                                <?= ucfirst($_SESSION['user']['username']); ?>
                            </h2>
                            <p class="text-sm text-gray-400">
                                <?= $_SESSION['user']['role'] == 'admin' ? 'Administrator' : 'Guru'; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (isset($_SESSION['user'])): ?>
                <nav class="p-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="<?= BASE_URL ?>/absensi/index" class="flex items-center space-x-3 p-3 rounded-lg
                                      hover:bg-green-600 transition-colors duration-200">
                                <i class="fas fa-home text-lg"></i>
                                <span>Home</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?= BASE_URL ?>/jadwal/index" class="flex items-center space-x-3 p-3 rounded-lg
    hover:bg-green-600 transition-colors duration-200">
                                <i class="fas fa-clock text-lg"></i>
                                <span>Data Jadwal</span>
                            </a>
                        </li>

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?>
                            <li>
                                <a href="<?= BASE_URL ?>/admin/index" class="flex items-center space-x-3 p-3 rounded-lg
              hover:bg-green-600 transition-colors duration-200">
                                    <i class="fas fa-users text-lg"></i>
                                    <span>Data Guru</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>/Admin/siswa" class="flex items-center space-x-3 p-3 rounded-lg
              hover:bg-green-600 transition-colors duration-200">
                                    <i class="fas fa-user-graduate text-lg"></i>
                                    <span>Data Siswa</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= BASE_URL ?>/mapel/index" class="flex items-center space-x-3 p-3 rounded-lg
              hover:bg-green-600 transition-colors duration-200">
                                    <i class="fas fa-book text-lg"></i>
                                    <span>Data Mapel</span>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            <?php endif; ?>

            <div class="mt-auto p-4 border-t border-gray-700">
                <?php if ($_SESSION['user']['role'] == 'guru'): ?>
                    <a href="<?= BASE_URL ?>/password/index" class="flex items-center space-x-3 p-3 rounded-lg
                          hover:bg-yellow-600 transition-colors duration-200 mb-2">
                        <i class="fas fa-key text-lg"></i>
                        <span>Ganti Password</span>
                    </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/login/logout" class="flex items-center space-x-3 p-3 rounded-lg
                          hover:bg-red-600 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span>Keluar</span>
                </a>
            </div>
                        <!--
                ⚠️ PENTING! JANGAN DIHAPUS
            Bagian ini adalah copyright resmi untuk aplikasi KejoedId
            Dibuat oleh Alfin Fahreza (https://github.com/alfinf2)
                -->
            <div class="mt-auto p-4">
                <div
                    class="rounded-2xl border border-gray-700 bg-gray-800/30 text-center text-sm text-gray-400 hover:text-white transition-all duration-200 shadow-md backdrop-blur-sm">
                    <p class="py-2 px-3">
                        &copy; <span id="copyright-year"></span>
                        <span class="font-semibold text-green-400">
                            <a href="https://github.com/KejoetID" class="hover:underline"><?= APP_NAME ?></a>
                        </span><br>
                        Created by
                        <a href="https://github.com/alfinf2" target="_blank"
                            class="font-semibold text-white hover:text-green-400 hover:underline">
                            <i class="fab fa-github text-lg"></i><span> Alfin Fahreza </span>
                        </a>
                    </p>
                </div>
            </div>



        </aside>


        <main class="flex-1 overflow-y-auto p-4 md:p-6 ml-0">

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const menuButton = document.getElementById('menu-button');
                    const sidebar = document.getElementById('sidebar');
                    const backdrop = document.getElementById('sidebar-backdrop');
                    const downloadBtn = document.getElementById('downloadBtn');
                    const downloadOptions = document.getElementById('downloadOptions');
                    const chevron = downloadBtn.querySelector('.fa-chevron-down');

                    downloadBtn.addEventListener('click', function (e) {
                        downloadOptions.classList.toggle('hidden');
                        chevron.style.transform = downloadOptions.classList.contains('hidden')
                            ? 'rotate(0deg)'
                            : 'rotate(180deg)';
                    });

                    function toggleSidebar() {
                        sidebar.classList.toggle('-translate-x-full');
                        backdrop.classList.toggle('hidden');
                        document.body.classList.toggle('sidebar-open');
                    }

                    menuButton.addEventListener('click', toggleSidebar);
                    backdrop.addEventListener('click', toggleSidebar);

                    document.addEventListener('click', function (event) {
                        const isMobile = window.innerWidth < 1066;
                        if (isMobile &&
                            !sidebar.contains(event.target) &&
                            !menuButton.contains(event.target) &&
                            !sidebar.classList.contains('-translate-x-full')) {
                            toggleSidebar();
                        }
                    });

                    window.addEventListener('resize', function () {
                        const isMobile = window.innerWidth < 1066;
                        if (!isMobile) {
                            sidebar.classList.remove('-translate-x-full');
                            backdrop.classList.add('hidden');
                            document.body.classList.remove('sidebar-open');
                        } else if (!sidebar.classList.contains('-translate-x-full')) {
                            backdrop.classList.remove('hidden');
                        }
                    });
                });

                document.getElementById('profileImage')?.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        document.getElementById('uploadForm').submit();
                    }
                });


                document.addEventListener("DOMContentLoaded", function () {
                    document.getElementById("copyright-year").textContent = new Date().getFullYear();
                });
            </script>
</body>

</html>