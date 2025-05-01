<?php

class SiswaModel extends BaseModel
{
    protected $table = "siswa";

    public function getAllSiswa($id = null)
    {
        if ($id !== null) {
            $query = "SELECT `siswa`.*, `kelas`.`nama_kelas`
                     FROM `siswa` 
                     LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id`
                     WHERE siswa.id_kelas = :id_kelas
                     ORDER BY siswa.nama ASC";
            $this->db->query($query);
            $this->db->bind('id_kelas', $id);
        } else {
            $query = "SELECT `siswa`.*, `kelas`.`nama_kelas`
                     FROM `siswa` 
                     LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id`
                     ORDER BY siswa.nama ASC";
            $this->db->query($query);
        }

        return $this->db->multiple();
    }

    public function getSiswaDanKelas()
    {
        $query = "SELECT `siswa`.*, `kelas`.`nama_kelas`
FROM `siswa` 
	LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id`";
        $this->db->query($query);
        return $this->db->multiple();
    }



    public function getAbsensiDetail($kelas_id, $mapel_id)
    {
        $query = "SELECT 
            s.id as siswa_id,
            s.nisn,
            s.nama,
            k.nama_kelas,
            m.nama_mapel,
            COALESCE(a.status, 'Absen') as status,
            a.waktu_scan
        FROM siswa s
        JOIN kelas k ON s.id_kelas = k.id
        CROSS JOIN mapel m 
        LEFT JOIN absensi a ON (
            a.id_siswa = s.id 
            AND a.id_mapel = m.id_mapel 
            AND DATE(a.waktu_scan) = CURRENT_DATE
        )
        WHERE s.id_kelas = :kelas_id 
        AND m.id_mapel = :mapel_id
        ORDER BY s.nama ASC";

        $this->db->query($query);
        $this->db->bind('kelas_id', $kelas_id);
        $this->db->bind('mapel_id', $mapel_id);
        return $this->db->multiple();
    }




    public function storeSiswa($data)
{
    try {

        $checkQuery = "SELECT COUNT(*) as count FROM siswa WHERE nisn = :nisn";
        $this->db->query($checkQuery);
        $this->db->bind('nisn', $data['inp_nis']);
        $result = $this->db->single();

        if ($result['count'] > 0) {
            return [
                'status' => false,
                'error' => 'duplicate_nisn',
                'message' => 'NISN sudah terdaftar'
            ];
        }

        $query = "INSERT INTO siswa (nisn, nama, id_kelas, alamat, tgllahir, telp) 
                 VALUES (:nisn, :nama, :id_kelas, :alamat, :tgllahir, :telp)";

        $this->db->query($query);
        $this->db->bind('nisn', $data['inp_nis']);
        $this->db->bind('nama', $data['inp_nama']);
        $this->db->bind('id_kelas', $data['inp_kelas']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('tgllahir', $data['tgllahir']);
        $this->db->bind('telp', $data['telp']);

        $this->db->execute();
        $siswa_id = $this->db->lastInsertId();

        if ($siswa_id) {
            $userResult = $this->createUserSiswa([
                'nisn' => $data['inp_nis'],
                'id_siswa' => $siswa_id
            ]);

            if ($userResult) {
                $this->db->execute();
                return [
                    'status' => true,
                    'message' => 'Data siswa berhasil ditambahkan'
                ];
            }
        }

        $this->db->rowCount();
        return [
            'status' => false,
            'error' => 'save_error',
            'message' => 'Gagal menyimpan data siswa'
        ];

    } catch (PDOException $e) {
        $this->db->rowCount();
        return [
            'status' => false,
            'error' => 'database_error',
            'message' => 'Error: ' . $e->getMessage()
        ];
    }
}

    public function createUserSiswa($data)
    {
        $defaultPassword = '$2y$10$djXua.hhO3lfVjk/2rU4FO.zTtJ0fib7fBZSVmp5b0Ec1FNTWzysa';

        $query = "INSERT INTO usersiswa (nisn, password, id_siswa) 
              VALUES (:nisn, :password, :id_siswa)";

        try {
            $this->db->query($query);
            $this->db->bind('nisn', $data['nisn']);
            $this->db->bind('password', $defaultPassword);
            $this->db->bind('id_siswa', $data['id_siswa']);

            return $this->db->execute();
        } catch (\Exception $e) {
            return false;
        }
    }





    public function getSiswaById($id)
    {
        $query = "SELECT `siswa`.`id`, `siswa`.`nisn`, `siswa`.`nama`, `siswa`.`id_kelas`, `kelas`.`nama_kelas`, `siswa`.`alamat`, `siswa`.`tgllahir`, `siswa`.`telp`, `siswa`.`image`
FROM `siswa` 
	LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id`
    WHERE siswa.nisn = :nisn";
        $this->db->query($query);
        $this->db->bind('nisn', $id);
        return $this->db->single();
    }
    public function getGabungganData($id)
    {
        $query = "SELECT `siswa`.`id`, `siswa`.`nisn`, `siswa`.`nama`, `kelas`.`nama_kelas`
FROM `siswa` 
	LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id`
    WHERE siswa.nisn=:nisn";

        $this->db->query($query);
        $this->db->bind('nisn', $id);
        return $this->db->single();
    }
    public function getSiswaByNisn($id)
    {
        $query = "SELECT * FROM $this->table WHERE nisn = :nisn";
        $this->db->query($query);
        $this->db->bind('nisn', $id);
        return $this->db->single();
    }
    public function getDataByNisn($nisn)
    {
        $query = "SELECT 
        `siswa`.`id`, 
        `siswa`.`nisn`, 
        `siswa`.`nama`, 
        `siswa`.`id_kelas`, 
        `kelas`.`nama_kelas`, 
        `jadwal`.`hari`, 
        `jadwal`.`jam`, 
        `jadwal`.`waktu_mulai`, 
        `jadwal`.`waktu_selesai`, 
        `mapel`.`id_mapel`,
        `mapel`.`nama_mapel`,
        `absensi`.`id_siswa`, 
        `absensi`.`id_kelas`, 
        `absensi`.`id_mapel`, 
        `absensi`.`status`, 
        `absensi`.`waktu_scan`
    FROM `siswa` 
    LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id` 
    LEFT JOIN `jadwal` ON `jadwal`.`id_kelas` = `kelas`.`id` 
    LEFT JOIN `absensi` ON `absensi`.`id_siswa` = `siswa`.`id`
    LEFT JOIN `mapel` ON `absensi`.`id_mapel` = `mapel`.`id_mapel` 
    WHERE siswa.nisn = :nisn";

        $this->db->query($query);
        $this->db->bind('nisn', $nisn);
        return $this->db->single();
    }

    public function getDetailSiswa($nisn)
    {
        $query = "SELECT 
            s.id, 
            s.nisn, 
            s.nama, 
            s.id_kelas,
            k.nama_kelas,
            j.hari,
            j.jam,
            j.waktu,
            m.id_mapel,
            m.nama_mapel,
            a.status,
            a.waktu_scan
        FROM siswa s
        LEFT JOIN kelas k ON s.id_kelas = k.id
        LEFT JOIN jadwal j ON j.id_kelas = k.id
        LEFT JOIN mapel m ON j.id_mapel = m.id_mapel
        LEFT JOIN absensi a ON (a.id_siswa = s.id AND a.id_mapel = m.id_mapel)
        WHERE s.nisn = :nisn
        ORDER BY j.hari ASC, j.jam ASC";

        $this->db->query($query);
        $this->db->bind('nisn', $nisn);
        return $this->db->multiple();
    }






    public function getSiswaByKelas($id_kelas)
    {
        $query = "SELECT siswa.*, kelas.nama_kelas 
              FROM siswa 
              JOIN kelas ON siswa.id_kelas = kelas.id 
              WHERE siswa.id_kelas = :id_kelas 
              ORDER BY siswa.nama_siswa ASC";

        $this->db->query($query);
        $this->db->bind('id_kelas', $id_kelas);
        return $this->db->rowCount();
    }


    public function updateSiswa($data, $id)
    {

        $query = "UPDATE $this->table SET
                 nisn = :nisn,
                 nama = :nama,
                 id_kelas = :id_kelas,
                 alamat = :alamat,
                 tgllahir = :tgllahir,
                 telp = :telp
                 WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('nisn', $data['inp_nis']);
        $this->db->bind('nama', $data['inp_nama']);
        $this->db->bind('id_kelas', $data['inp_kelas']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('tgllahir', $data['tgllahir']);
        $this->db->bind('telp', $data['telp']);
        $this->db->bind('id', $id);

        $this->db->execute();
        
        

    }


    public function updateUserSiswa($data,$id)
    {

        $query = "UPDATE usersiswa SET 
                 nisn = :nisn
                 WHERE id_siswa = :id_siswa";
        $this->db->query($query);
        $this->db->bind('nisn', $data['inp_nis']);
        $this->db->bind('id_siswa', $id);
        $this->db->execute();
    }


    public function changePassword($nisn, $old_password, $new_password)
    {
        try {
            $query = "SELECT us.password 
                 FROM usersiswa us 
                 INNER JOIN siswa s ON us.id_siswa = s.id 
                 WHERE us.nisn = :nisn";
            $this->db->query($query);
            $this->db->bind('nisn', $nisn);
            $result = $this->db->single();

            if (!$result || !password_verify($old_password, $result['password'])) {
                return [
                    'status' => false,
                    'message' => 'Password lama tidak sesuai'
                ];
            }
            
            if (strlen($new_password) < 6) {
                return [
                    'status' => false,
                    'message' => 'Password baru minimal 6 karakter'
                ];
            }
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 10]);
            $update_query = "UPDATE usersiswa SET password = :password WHERE nisn = :nisn";
            $this->db->query($update_query);
            $this->db->bind('password', $hashed_password);
            $this->db->bind('nisn', $nisn);

            $result = $this->db->execute();

            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Password berhasil diubah'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Gagal mengubah password'
                ];
            }

        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function deleteFoto($nisn)
    {

        $query = "SELECT image FROM siswa WHERE nisn = :nisn";
        $this->db->query($query);
        $this->db->bind('nisn', $nisn);
        $currentImage = $this->db->single();

        if ($currentImage && $currentImage['image']) {
            $imagePath = dirname(dirname(__DIR__)) . '/public/img/profile/' . $currentImage['image'];
            if (file_exists($imagePath) && is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $query = "UPDATE siswa SET image = NULL WHERE nisn = :nisn";
        $this->db->query($query);
        $this->db->bind('nisn', $nisn);

        if ($this->db->execute()) {
            return [
                'status' => true,
                'message' => 'Foto profil berhasil dihapus'
            ];
        }

        return [
            'status' => false,
            'message' => 'Gagal menghapus foto profil'
        ];



    }

    public function updateProfileImage($nisn, $newImage)
    {
        try {
            $query = "SELECT image FROM siswa WHERE nisn = :nisn";
            $this->db->query($query);
            $this->db->bind('nisn', $nisn);
            $currentImage = $this->db->single();

            if ($currentImage && $currentImage['image']) {
                $oldImagePath = dirname(dirname(__DIR__)) . '/public/img/profile/' . $currentImage['image'];
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $query = "UPDATE siswa SET image = :image WHERE nisn = :nisn";
            $this->db->query($query);
            $this->db->bind('image', $newImage);
            $this->db->bind('nisn', $nisn);

            if ($this->db->execute()) {
                return [
                    'status' => true,
                    'message' => 'Foto profil berhasil diupdate'
                ];
            }

            return [
                'status' => false,
                'message' => 'Gagal update foto profil'
            ];
        } catch (\Exception $e) {
            error_log("Error updating profile image: " . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

}