<style>
    
    input[type="time"] {
        position: relative;
        -webkit-appearance: textfield;
        -moz-appearance: textfield;
        appearance: textfield;
    }

    input[type="time"]::-webkit-datetime-edit-ampm-field {
        display: none !important;
    }

    input[type="time"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-clear-button,
    input[type="time"]::-webkit-inner-spin-button {
        display: none;
    }

    input[type="time"]::-webkit-datetime-edit-hour-field,
    input[type="time"]::-webkit-datetime-edit-minute-field {
        -webkit-appearance: none;
    }

    @-moz-document url-prefix() {
        input[type="time"] {
            -moz-appearance: textfield;
            text-align: center;
        }
    }

    .custom-time-picker {
        position: absolute;
        background: white;
        border: 1px solid #ccc;
        z-index: 1000;
        display: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .custom-time-picker table {
        border-collapse: collapse;
        width: 100%;
    }

    .custom-time-picker td {
        padding: 8px;
        text-align: center;
        cursor: pointer;
    }

    .custom-time-picker td:hover {
        background-color: #f0f0f0;
    }

    .time-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .time-input-wrapper input {
        padding-right: 35px;
    }

    .time-icon {
        position: absolute;
        right: 10px;
        cursor: pointer;
        color: #666;
    }

    .time-icon:hover {
        color: #333;
    }

    .time-picker-popup {
        display: none;
        position: absolute;
        background: white;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        right: 0;
    }

    .time-picker-popup select {
        margin: 5px;
        padding: 3px;
    }
</style>

<div class="container">
    <div class="row justify-content-lg-center mt-5">
        <div class="col-lg-5 col-sm-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="alert-primary text-center my-4 mt-3">Edit Jadwal Pelajaran</h5>
                    <form id="createJadwalForm" action="<?= BASE_URL; ?>/jadwal/update/<?= $data['jadwal']['id'] ?>"
                        method="post">

                        <div class="form-group">
                            <select class="form-control" id="hari" name="hari" required>
                                <option value=""><?= $data['jadwal']['hari'] ?></option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div><br>

                        <div class="form-group">
                            <select class="form-control" id="sesi" name="sesi" required>
                                <option value=""> Sesi <?= $data['jadwal']['jam'] ?></option>
                                <option value="1">Sesi 1</option>
                                <option value="2">Sesi 2</option>
                                <option value="3">Sesi 3</option>
                                <option value="4">Sesi 4</option>
                                <option value="5">Sesi 5</option>
                                <option value="6">Sesi 6</option>
                                <option value="7">Sesi 7</option>
                                <option value="8">Sesi 8</option>
                            </select>
                        </div><br>

                        <div class="form-group">
                            <select class="form-control" id="mapel" name="id_mapel" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                <?php foreach ($data['mapel'] as $mapel): ?>
                                    <option value="<?= $mapel['id_mapel'] ?>"
                                        <?= ($data['jadwal']['id_mapel'] == $mapel['id_mapel']) ? 'selected' : '' ?>>
                                        <?= $mapel['nama_mapel'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div><br>

                        <div class="form-group">
                            <select class="form-control" id="guru" name="id_guru" required>
                                <option value="">Pilih Guru</option>
                                <?php foreach ($data['guru'] as $guru): ?>
                                    <option value="<?= $guru['id'] ?>" 
                                        <?= ($data['jadwal']['id_guru'] == $guru['id']) ? 'selected' : '' ?>>
                                        <?= $guru['nama_guru'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div><br>

                        <div class="form-group">
                            <select class="form-control" id="kelas" name="id_kelas" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($data['kelas'] as $kelas): ?>
                                    <option value="<?= $kelas['id'] ?>"
                                        <?= ($data['jadwal']['id_kelas'] == $kelas['id']) ? 'selected' : '' ?>>
                                        <?= $kelas['nama_kelas'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div><br>

                        <div class="form-group">
                            <label for="waktu_mulai">Jam Mulai</label>
                            <div class="time-input-wrapper">
                                <input type="text" class="form-control" value="<?=$data['jadwal']['waktu_mulai']?>" id="waktu_mulai" name="waktu_mulai">
                                <i class="fas fa-clock time-icon" data-target="waktu_mulai"></i>
                                <div class="time-picker-popup" id="waktu_mulai_picker"></div>
                            </div>
                        </div><br>

                        <div class="form-group">
                            <label for="waktu_selesai">Jam Selesai</label>
                            <div class="time-input-wrapper">
                                <input type="text" class="form-control" value="<?=$data['jadwal']['waktu_selesai']?>" id="waktu_selesai" name="waktu_selesai">
                                <i class="fas fa-clock time-icon" data-target="waktu_selesai"></i>
                                <div class="time-picker-popup" id="waktu_selesai_picker"></div>
                            </div>
                        </div><br>

                        <div class="form-group gap-2 mt-4 d-flex justify-content-between">
                            <input type="submit" value="Simpan" class="btn btn-primary btn-lg" style="width: 32%;">
                            <input type="reset" value="Reset" class="btn btn-danger btn-lg" style="width: 32%;">
                            <a href="<?= BASE_URL ?>/jadwal/index" class="btn btn-secondary btn-lg"
                                style="width: 35%;">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('createJadwalForm').addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Menyimpan Jadwal...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                }
                return { status: true, message: 'Jadwal berhasil ditambahkan' };
            })
            .then(data => {
                Swal.fire({
                    title: data.status ? 'Berhasil!' : 'Gagal!',
                    text: data.message || (data.status ? 'Jadwal berhasil ditambahkan' : 'Gagal menambahkan jadwal'),
                    icon: data.status ? 'success' : 'error',
                    confirmButtonColor: data.status ? '#4CAF50' : '#f44336'
                }).then((result) => {
                    if (result.isConfirmed && data.status) {
                        window.location.href = '<?= BASE_URL ?>/jadwal/index';
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan jadwal',
                    icon: 'error',
                    confirmButtonColor: '#f44336'
                });
            });
    });

    document.addEventListener('DOMContentLoaded', function () {
        function createTimePicker(targetId) {
            const picker = document.getElementById(`${targetId}_picker`);
            let html = '<div class="d-flex">';

            html += '<select class="hour-select form-control">';
            for (let i = 0; i < 24; i++) {
                html += `<option value="${String(i).padStart(2, '0')}">${String(i).padStart(2, '0')}</option>`;
            }
            html += '</select>';

            html += '<span class="mx-1">:</span>';

            html += '<select class="minute-select form-control">';
            for (let i = 0; i < 60; i += 1) {
                html += `<option value="${String(i).padStart(2, '0')}">${String(i).padStart(2, '0')}</option>`;
            }
            html += '</select>';

            html += '</div>';
            picker.innerHTML = html;

            const hourSelect = picker.querySelector('.hour-select');
            const minuteSelect = picker.querySelector('.minute-select');

            function updateTime() {
                const input = document.getElementById(targetId);
                input.value = `${hourSelect.value}:${minuteSelect.value}`;
                input.dispatchEvent(new Event('change'));
            }

            hourSelect.addEventListener('change', updateTime);
            minuteSelect.addEventListener('change', updateTime);

            const input = document.getElementById(targetId);
            if (input.value) {
                const [hours, minutes] = input.value.split(':');
                hourSelect.value = hours;
                minuteSelect.value = minutes;
            }
        }

        createTimePicker('waktu_mulai');
        createTimePicker('waktu_selesai');

        document.querySelectorAll('.time-icon').forEach(icon => {
            icon.addEventListener('click', function (e) {
                const targetId = this.getAttribute('data-target');
                const picker = document.getElementById(`${targetId}_picker`);

                document.querySelectorAll('.time-picker-popup').forEach(p => {
                    if (p !== picker) p.style.display = 'none';
                });

                picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
            });
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.time-input-wrapper')) {
                document.querySelectorAll('.time-picker-popup').forEach(picker => {
                    picker.style.display = 'none';
                });
            }
        });

        const waktuMulaiInput = document.getElementById('waktu_mulai');
        const waktuSelesaiInput = document.getElementById('waktu_selesai');

        if (!waktuMulaiInput.value) {
            waktuMulaiInput.value = "06:00";
            const [hours, minutes] = "06:00".split(':');
            const mulaiPicker = document.getElementById('waktu_mulai_picker');
            if (mulaiPicker) {
                mulaiPicker.querySelector('.hour-select').value = hours;
                mulaiPicker.querySelector('.minute-select').value = minutes;
            }
        }

        waktuMulaiInput.addEventListener('change', function () {
            const waktuMulai = this.value;
            const timeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;

            if (!timeRegex.test(waktuMulai)) return;

            const [startHour, startMinute] = waktuMulai.split(':').map(Number);
            const startTimeInMinutes = (startHour * 60) + startMinute;
            const newEndTimeInMinutes = startTimeInMinutes + 35;
            let newEndHour = Math.floor(newEndTimeInMinutes / 60) % 24;
            const newEndMinute = newEndTimeInMinutes % 60;

            waktuSelesaiInput.value = `${String(newEndHour).padStart(2, '0')}:${String(newEndMinute).padStart(2, '0')}`;

            const selesaiPicker = document.getElementById('waktu_selesai_picker');
            if (selesaiPicker) {
                selesaiPicker.querySelector('.hour-select').value = String(newEndHour).padStart(2, '0');
                selesaiPicker.querySelector('.minute-select').value = String(newEndMinute).padStart(2, '0');
            }
        });

        document.getElementById('createJadwalForm').addEventListener('submit', function (event) {
            const waktuMulaiValue = waktuMulaiInput.value;
            const waktuSelesaiValue = waktuSelesaiInput.value;
            const timeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;

            if (!timeRegex.test(waktuMulaiValue) || !timeRegex.test(waktuSelesaiValue)) {
                event.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Format waktu harus HH:MM dalam format 24 jam',
                    icon: 'error',
                    confirmButtonColor: '#f44336'
                });
            }
        });
    });

</script>