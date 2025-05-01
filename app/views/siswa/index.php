<style>
    body {
        background-color: #f4f4f4;
    }

    .dashboard-container {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 900px;
        margin: auto;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-width: 500px;
        position: relative;
    }

    .close {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }


    .status-column {
        text-align: center;
        padding-right: 20px !important;
    }

    .status-label {
        display: inline-block;
        min-width: 100px;
        text-align: center;
    }

    .status-hadir {
        color: green;
        font-weight: bold;
    }

    .status-hadir-tanpa-kartu {
        color: green;
        font-weight: bold;
    }

    .status-absen {
        color: red;
        font-weight: bold;
    }

    .status-sakit {
        color: yellow;
        font-weight: bold;
    }

    .status-izin {
        color: orange;
        font-weight: bold;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .dashboard-container {
            width: 100%;
            padding: 20px;
        }
    }

    #search-input {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 100%;
        max-width: 300px;
        margin-bottom: 10px;
    }

    #search-input:focus {
        outline: none;
        border-color: #2185d0;
        box-shadow: 0 0 5px rgba(33, 133, 208, 0.2);
    }

    .search-container {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
</style>
</head>

<body>

    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='<?= BASE_URL ?>/siswa/index'">x</span>
            <h3 class="ui header">Detail Absensi</h3>
            <div class="ui divider"></div>
            <div id="modalContent"></div>
        </div>
    </div>

    <div class="container-fluid min-vh-100 my-4  bg-light">
        <div class="dashboard-container">
            <div class="ui message">
                <?php
                date_default_timezone_set('Asia/Jakarta');
                $hour = date("H");
                $greeting = ($hour < 12) ? "Selamat Pagi" :
                    (($hour < 15) ? "Selamat Siang" :
                        (($hour < 18) ? "Selamat Sore" : "Selamat Malam"));


                function getStatusClass($status)
                {
                    switch ($status) {
                        case 'Hadir' || 'Hadir Tanpa Kartu':
                            return 'green';
                        case 'Absen':
                            return 'red';
                        case 'Sakit':
                            return 'yellow';
                        case 'Izin':
                            return 'orange';
                        default:
                            return 'basic';
                    }
                }
                ?>
                <i class="info icon"></i> <strong>Halo <?= $greeting ?>,
                    <?= htmlspecialchars($data['siswa']['nama']) ?></strong>. Jangan
                lupa absensi yaa!
            </div>

            <div class="ui segment">
                <h4 class="ui header">Riwayat Absensi</h4>
                <div class="search-container">
                    <div class="ui icon input">
                        <input type="text" id="search-input" placeholder="Cari berdasarkan mata pelajaran...">
                        <i class="search icon"></i>
                    </div>
                </div>

                <table class="ui celled table" id="absensi-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Pelajaran</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="search-results">
                        <?php if (!empty($data['absensi'])): ?>
                            <?php $no = 1;
                            foreach ($data['absensi'] as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="subject"><?= htmlspecialchars($row['nama_mapel'] ?? 'Tidak Ada Mapel') ?></td>
                                    <td class="date">
                                        <?= !empty($row['waktu_scan']) ? date("d/m/Y", strtotime($row['waktu_scan'])) : '-' ?>
                                    </td>
                                    <td class="status-column">
                                        <span class="ui <?= getStatusClass($row['status']) ?> label status-label "
                                            style="cursor: pointer;"
                                            onclick="showDetails('<?= htmlspecialchars($row['nama_mapel']) ?>', 
                             '<?= htmlspecialchars($row['status']) ?>', 
                             '<?= !empty($row['waktu_scan']) ? date("d/m/Y H:i", strtotime($row['waktu_scan'])) : '-' ?>')">
                                            <?= htmlspecialchars($row['status'] ?? 'Belum Absen') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data absensi</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <br><br>

    <script>
        const modal = document.getElementById("detailModal");
        const span = document.getElementsByClassName("close")[0];


        function getStatusClassJS(status) {
            switch (status) {
                case 'Hadir tanpa kartu':
                    return 'green';
                case 'Hadir':
                    return 'green';
                case 'Absen':
                    return 'red';
                case 'Sakit':
                    return 'yellow';
                case 'Izin':
                    return 'orange';
                default:
                    return 'basic';
            }
        }

        function showDetails(mapel, status, waktu) {
            const modalContent = document.getElementById("modalContent");
            modalContent.innerHTML = `
        <div class="ui list">
            <div class="item">
                <i class="book icon"></i>
                <div class="content">
                    <div class="header">Mata Pelajaran</div>
                    <div class="description">${mapel}</div>
                </div>
            </div>
            <div class="item">
                <i class="calendar icon"></i>
                <div class="content">
                    <div class="header">Waktu Absensi</div>
                    <div class="description">${waktu}</div>
                </div>
            </div>
            <div class="item">
                <i class="info circle icon"></i>
                <div class="content">
                    <div class="header">Status</div>
                    <div class="description">
                        <span class="ui ${getStatusClassJS(status)} label">
                            ${status}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    `;
            modal.style.display = "block";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }


        document.getElementById('search-input').addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#search-results tr');

            tableRows.forEach(row => {
                const subjectCell = row.querySelector('.subject');
                if (subjectCell) {
                    const subject = subjectCell.textContent.toLowerCase();
                    if (subject.includes(searchValue)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });

        // Add clear search functionality
        const searchInput = document.getElementById('search-input');
        searchInput.insertAdjacentHTML('afterend', '<button class="ui mini button" id="clear-search" style="margin-left: 10px; margin-bottom: 10px;">Clear</button>');

        document.getElementById('clear-search').addEventListener('click', function () {
            searchInput.value = '';
            document.querySelectorAll('#search-results tr').forEach(row => {
                row.style.display = '';
            });
        });
    </script>

</body>

</html>