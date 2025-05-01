<style>
    .ui.centered.card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 22rem;
        position: relative;
    }

    .content {
        padding: 10px;
    }

    .header {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
        position: relative;
    }

    .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 24px;
        cursor: pointer;
        color: #888;
    }

    .info-row {
        display: flex;
        margin-bottom: 15px;
    }

    .info-label {
        font-weight: bold;
        width: 150px;
    }

    .info-separator {
        margin: 0 10px;
    }

    .info-value {
        flex: 1;
    }

    .ui.bottom.attached.button {
        margin-top: 20px;
        text-align: center;
    }

    .ui.basic.button {
        padding: 8px 16px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        color: #333;
    }


    .status-hadir {
        color: green;
        font-weight: bold;
    }

    .status-hadir-tanpa-kartu {
        color: green;
        font-weight: bold;
    }

    .status-sakit {
        color: red;
        font-weight: bold;
    }

    .status-izin {
        color: orange;
        font-weight: bold;
    }
</style>
</head>

<body>


    <div class="ui centered card mt-3">
        <div class="content">
            <span class="close-button" onclick="window.location.href='<?= BASE_URL ?>/siswa/index/'">×</span>
            <div class="header">
                Keterangan Daftar Hadir
                <div class="ui centered card" style="width: 18rem;">
                    <div class="header">
                        <?= isset($data['siswa']['nama']) ? htmlspecialchars($data['siswa']['nama']) : 'Data tidak tersedia'; ?>
                    </div>
                    <div class="text-black">
                        <?= isset($data['siswa']['nama_kelas']) ? htmlspecialchars($data['siswa']['nama_kelas']) : 'Mata pelajaran tidak tersedia'; ?>
                    </div>
                    <div class="text-black">
                        <?= isset($data['mapel']['nama_mapel']) ? htmlspecialchars($data['mapel']['nama_mapel']) : 'Mata pelajaran tidak tersedia'; ?>
                    </div>
                    <div class="ui bottom attached button">
                        <a href="<?= BASE_URL; ?>/siswa" class="ui basic button">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>