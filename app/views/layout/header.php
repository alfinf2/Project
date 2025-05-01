<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="icon" type="image/png" href="<?= BASE_URL?>/img/favicon-32x32.png">

    <title><?= APP_NAME ?></title>

</head>


<body>



    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="<?= BASE_URL; ?>">
                <?= APP_NAME ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= BASE_URL; ?>">Home</a>
                    </li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= BASE_URL; ?>/Siswa/index">Riwayat Absensi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= BASE_URL ?>/login/logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= BASE_URL ?>/siswa/index">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="d-flex align-items-center">
                        <a href="<?= BASE_URL ?>/siswa/profile" class="cursor-pointer mr-2"> 
                            <img class="rounded-circle w-10 h-10 object-cover transition-opacity duration-200"
                                src="<?= !empty($data['siswa']['image'])
                                    ? BASE_URL . '/img/profile/' . $data['siswa']['image']
                                    : BASE_URL . '/img/profile/Premium Vector _ High school students posing waving hands.jpg' ?>"
                                alt="Profile Picture" />
                        </a>
                        <div class="text-white"> 
                            <strong>
                                <?= $data['siswa']['nama']; ?><br>
                                <?= $data['siswa']['nama_kelas']; ?>
                            </strong>
                        </div>
                    </div>
                <?php endif; ?>
               
            </div>
        </div>
    </nav>
</body>

</html>