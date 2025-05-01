<body>
    <div class="ui bottom fixed one item white inverted menu">
        <div class="item">
            <b>Copyright &copy;</b>
            <?= date('Y') ?> -
            <a href="https://github.com/KejoetID"> <?= APP_NAME ?> </a> -
            &nbsp;<a href="https://github.com/alfinf2"><strong>Alfin Fahreza</strong></a>
        </div>
    </div>


    <script>
        function debounce(func, wait) {
            let timeout;
            return function (...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        $(document).ready(function () {
            $("#search-input").on("input", debounce(function () {
                let keyword = $(this).val().toLowerCase().trim();

                $.post("<?= BASE_URL ?>/siswa/cari", { keyword: keyword }, function (data) {
                    let results = JSON.parse(data);
                    let tbody = $("#absensi-table tbody");
                    tbody.empty();

                    if (results.length > 0) {
                        results.forEach((row, index) => {
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${row.mata_pelajaran}</td>
                                    <td>${row.tanggal}</td>
                                    <td>Sesi ${row.sesi}</td>
                                    <td class="status-${row.keterangan.toLowerCase()}">${row.keterangan}</td>
                                    <td><a href="<?= BASE_URL ?>/siswa/detail/${row.nisn}/${encodeURIComponent(row.tanggal)}" class="ui basic button"><i class="eye icon"></i> Detail</a></td>
                                </tr>
                            `);
                        });
                    } else {
                        tbody.append("<tr><td colspan='6' class='text-center'>Tidak ada hasil</td></tr>");
                    }
                });
            }, 300));
        });
    </script>

    <script src="<?= BASE_URL ?>/js/semantic.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>