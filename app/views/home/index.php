<style>

</style>



<div class="container my-3">
    <div class="ui message">
        <?php
        date_default_timezone_set('Asia/Jakarta');
        $hour = date("H");
        $greeting = ($hour < 12) ? "Selamat Pagi" :
            (($hour < 15) ? "Selamat Siang" :
                (($hour < 18) ? "Selamat Sore" : "Selamat Malam"));
        ?>
        <i class="info icon"></i> <strong>Halo <?= $greeting ?>,
            <?= htmlspecialchars($data['siswa']['nama']) ?></strong>. Semangat Belajar untuk hari ini!
    </div>
    <div class="ui segment">
        

        <div class="flex flex-col lg:flex-row m-4 space-y-4 lg:space-y-0 lg:space-x-4">
            

            <div class="bg-white p-4 rounded-lg shadow-md flex-1">
                <div class="bg-yellow-400 p-4 rounded-lg flex justify-center items-center gap-2">
                    <span class="text-white text-2xl font-bold text-center">Absensi Siswa</span>
                    <i class="fas fa-calendar-alt text-white text-2xl"></i>
                </div>

            </div>

            <?php
            

            $hadir = 0;
            $sakit = 0;
            $izin = 0;


            foreach ($data['absensi'] as $absen) {
                if ($absen['status'] === 'Hadir') {
                    $hadir++;
                } elseif ($absen['status'] === 'Sakit') {
                    $sakit++;
                } elseif ($absen['status'] === 'Hadir tanpa kartu') {
                    $hadir++;
                } elseif ($absen['status'] === 'Izin') {
                    $izin++;
                }
            }
            ?>


            <div class="bg-white p-4 rounded-lg shadow-md flex-1">
                <div class="flex flex-wrap justify-center md:justify-start space-x-4">
                    <div class="bg-red-500 text-white text-center p-4 rounded-lg mb-2 md:mb-0">
                        <p class="text-2xl font-bold"><?= htmlspecialchars($sakit) ?></p>
                        <p>Sakit</p>
                    </div>
                    <div class="bg-yellow-400 text-white text-center p-4 rounded-lg mb-2 md:mb-0">

                        <p class="text-2xl font-bold"><?= htmlspecialchars($izin) ?></p>
                        <p>Izin</p>

                    </div>
                    <div class="bg-green-500 text-white text-center p-4 rounded-lg mb-2 md:mb-0">
                        <p class="text-2xl font-bold"><?= htmlspecialchars($hadir) ?></p>
                        <p>Hadir</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h2 class="text-2xl font-semibold text-black-800 mb-3">Roster Jadwal Kelas :
                <span class="text-black-600">

                    <?= htmlspecialchars($data['kelas']['nama_kelas']) ?>

                </span>
            </h2>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <?php

                    $formatter = new IntlDateFormatter(
                        'id_ID',
                        IntlDateFormatter::FULL,
                        IntlDateFormatter::NONE,
                        'Asia/Jakarta',
                        IntlDateFormatter::GREGORIAN
                    );
                    echo '<p id="date-range">' . $formatter->format(new DateTime()) . '</p>';
                    ?>
                </div>
            </div>

            <div id="jadwal-content" class="overflow-x-auto">
                <table class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden text-center">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-3">Hari</th>
                            <th class="px-4 py-3">Mata Pelajaran</th>
                            <th class="px-4 py-3">Waktu</th>
                            <th class="px-4 py-3">Sesi</th>
                        </tr>
                    </thead>
                    <tbody id="search-results">
                        <?php if (!empty($data['jadwal'])): ?>
                            <?php $no = 1;
                            foreach ($data['jadwal'] as $key => $row): ?>
                                <tr>
                                    <td class="border px-4 py-2"><?= htmlspecialchars($row['hari'] ?? '') ?></td>
                                    <td class="border px-4 py-2"><?= htmlspecialchars($row['nama_mapel'] ?? '') ?></td>
                                    <td class="border px-4 py-2">
                                        <?= htmlspecialchars($row['waktu_mulai']?? '') ?> -
                                        <?= htmlspecialchars($row['waktu_selesai'])?>
                                    </td>
                                    <td class="border px-4 py-2"><?= htmlspecialchars($row['jam'] ?? '') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center border px-4 py-2">Belum ada jadwal</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <br><br>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>