<?php

class AbsensiModel extends BaseModel
{
    protected $table = 'absensi';

    public function getAllAbsensi()
    {
        $query = "SELECT a.*, s.nama as nama_siswa, k.nama_kelas, m.nama_mapel 
                  FROM $this->table a
                  JOIN siswa s ON a.id_siswa = s.id
                  JOIN kelas k ON a.id_kelas = k.id
                  JOIN mapel m ON a.id_mapel = m.id_mapel";
        $this->db->query($query);
        return $this->db->multiple();
    }
    public function getAbsensiByNisn($nisn)
    {
        $query = "SELECT 
            absensi.id as absensi_id,
            siswa.nisn,
            siswa.nama as nama_siswa,
            kelas.nama_kelas,
            mapel.nama_mapel,
            absensi.status,
            absensi.waktu_scan,
            mapel.id_mapel
        FROM absensi
        INNER JOIN siswa ON absensi.id_siswa = siswa.id
        INNER JOIN kelas ON absensi.id_kelas = kelas.id
        INNER JOIN mapel ON absensi.id_mapel = mapel.id_mapel
        WHERE siswa.nisn = :nisn
        ORDER BY absensi.waktu_scan DESC";

        $this->db->query($query);
        $this->db->bind('nisn', $nisn);
        return $this->db->multiple();
    }

    public function getDetail($id_siswa = null, $id_mapel = null)
    {
        $query = "SELECT 
        a.id as absensi_id,
        a.status,
        a.waktu_scan,
        s.id as siswa_id,
        s.nisn,
        s.nama as nama_siswa,
        k.id as kelas_id,
        k.nama_kelas,
        m.id_mapel,
        m.nama_mapel,
        j.hari,
        j.jam,
        j.waktu
    FROM absensi a
    INNER JOIN siswa s ON a.id_siswa = s.id
    INNER JOIN kelas k ON a.id_kelas = k.id
    INNER JOIN mapel m ON a.id_mapel = m.id_mapel
    LEFT JOIN jadwal j ON (j.id_kelas = k.id AND j.id_mapel = m.id_mapel)
    WHERE 1=1";

        if ($id_siswa !== null) {
            $query .= " AND a.id_siswa = :id_siswa";
        }
        if ($id_mapel !== null) {
            $query .= " AND a.id_mapel = :id_mapel";
        }

        $query .= " ORDER BY a.waktu_scan DESC";

        try {
            $this->db->query($query);

            if ($id_siswa !== null) {
                $this->db->bind('id_siswa', $id_siswa);
            }
            if ($id_mapel !== null) {
                $this->db->bind('id_mapel', $id_mapel);
            }

            return $this->db->multiple();
        } catch (PDOException $e) {
            error_log("Error in getDetail: " . $e->getMessage());
            return false;
        }
    }




    public function getAbsensiById($id)
    {
        $query = "SELECT a.*,s.id, s.nama as nama_siswa, k.nama_kelas, m.nama_mapel 
                  FROM $this->table a
                  JOIN siswa s ON a.id_siswa = s.id
                  JOIN kelas k ON a.id_kelas = k.id
                  JOIN mapel m ON a.id_mapel = m.id_mapel
                  WHERE a.id_siswa = :id_siswa";
        $this->db->query($query);
        $this->db->bind('id_siswa', $id);
        return $this->db->multiple();
    }

    public function getAbsensiDetail($kelas_id, $mapel_id, $waktu_scan)
    {
        $query = "SELECT 
        s.id as siswa_id,
        s.nisn,
        s.nama,
        k.nama_kelas,
        m.nama_mapel,
        COALESCE(a.status, 'Absen') as status,
        COALESCE(a.waktu_scan, :waktu_scan) as waktu_scan
    FROM siswa s
    JOIN kelas k ON s.id_kelas = k.id
    CROSS JOIN mapel m 
    LEFT JOIN absensi a ON (
        a.id_siswa = s.id 
        AND a.id_mapel = m.id_mapel 
        AND DATE(a.waktu_scan) = DATE(:waktu_scan)
    )
    WHERE s.id_kelas = :kelas_id 
    AND m.id_mapel = :mapel_id 
    ORDER BY s.nama ASC";

        try {
            $this->db->query($query);
            $this->db->bind('kelas_id', $kelas_id);
            $this->db->bind('mapel_id', $mapel_id);
            $this->db->bind('waktu_scan', $waktu_scan);

            $result = $this->db->multiple();

            if (!$result) {
                error_log("No results found for kelas_id: $kelas_id, mapel_id: $mapel_id, waktu_scan: $waktu_scan");
            }

            return $result;

        } catch (PDOException $e) {
            error_log("Error in getAbsensiDetail: " . $e->getMessage());
            return false;
        }
    }

    public function getAbsensiByIdSiswa($nisn)
    {
        $query = "SELECT `absensi`.`id`, `siswa`.`nisn`, `siswa`.`nama`, `kelas`.`nama_kelas`, `mapel`.`nama_mapel`, `absensi`.`status`
FROM `absensi` 
	LEFT JOIN `siswa` ON `absensi`.`id_siswa` = `siswa`.`id` 
	LEFT JOIN `kelas` ON `absensi`.`id_kelas` = `kelas`.`id` 
	LEFT JOIN `mapel` ON `absensi`.`id_mapel` = `mapel`.`id_mapel`
    WHERE siswa.nisn = :nisn 
";
        $this->db->query($query);
        $this->db->bind('nisn', $nisn);
        return $this->db->multiple();
    }

    public function getAbsensiByIdMapel($id)
    {
        $query = "SELECT `absensi`.*, `mapel`.`nama_mapel`
FROM $this->table 
	LEFT JOIN `mapel` ON `absensi`.`id_mapel` = `mapel`.`id_mapel` 
    WHERE absensi.id_mapel = :id_mapel
";

        $this->db->query($query);
        $this->db->bind("id_mapel", $id);
        return $this->db->multiple();
    }

    public function getAllDataTable($id)
    {
        $query = 'SELECT `absensi`.*, `siswa`.`nama`, `kelas`.`nama_kelas`, `mapel`.`nama_mapel`
FROM `absensi` 
	LEFT JOIN `siswa` ON `absensi`.`id_siswa` = `siswa`.`id` 
	LEFT JOIN `kelas` ON `absensi`.`id_kelas` = `kelas`.`id` 
	LEFT JOIN `mapel` ON `absensi`.`id_mapel` = `mapel`.`id_mapel`
    WHERE absensi.id_mapel =:id_mapel;';
        $this->db->query($query);
        $this->db->bind(':id_mapel', $id);
        return $this->db->multiple();

    }




    public function getAbsensiByKelas($id_kelas, $tanggal)
    {
        $query = "SELECT a.*, s.nama as nama_siswa, m.nama_mapel 
                  FROM $this->table a
                  JOIN siswa s ON a.id_siswa = s.id
                  JOIN mapel m ON a.id_mapel = m.id_mapel
                  WHERE a.id_kelas = :id_kelas AND DATE(a.waktu_scan) = :tanggal";
        $this->db->query($query);
        $this->db->bind('id_kelas', $id_kelas);
        $this->db->bind('tanggal', $tanggal);
        return $this->db->multiple();
    }



    public function getAbsensiByMapel($keyword)
    {
        $query = "SELECT `absensi`.*, `mapel`.`nama_mapel`, DATE(`absensi`.`waktu_scan`) AS tanggal_scan
              FROM `absensi`
              LEFT JOIN `mapel` ON `absensi`.`id_mapel` = `mapel`.`id_mapel`
              WHERE `mapel`.`nama_mapel` LIKE :keyword";

        $this->db->query($query);
        $this->db->bind(':keyword', "%$keyword%");
        return $this->db->multiple();
    }



    public function getAllSiswaByKelas($id)
    {
        $id = (int) $id;
        $query = ("SELECT 
    `siswa`.`id`, 
    `siswa`.`nama`, 
    `siswa`.`nisn`, 
    `siswa`.`id_kelas`, 
    `kelas`.`nama_kelas`, 
    `mapel`.`id_mapel`, 
    `mapel`.`nama_mapel`
FROM `siswa` 
LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id`
CROSS JOIN `mapel`
WHERE `kelas`.`id` = :id_kelas");

        $this->db->query($query);
        $this->db->bind('id_kelas', $id);
        $this->db->execute();
        return $this->db->multiple();
    }
    public function getMapelById($id)
    {
        $id = (int) $id;
        $query = ("SELECT 
    `siswa`.`id`, 
    `siswa`.`nama`, 
    `siswa`.`nisn`, 
    `siswa`.`id_kelas`, 
    `kelas`.`nama_kelas`, 
    `mapel`.`id_mapel`, 
    `mapel`.`nama_mapel`
FROM `siswa` 
LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id`
CROSS JOIN `mapel`
WHERE `mapel`.`id_mapel` = :id_mapel");

        $this->db->query($query);
        $this->db->bind('id_mapel', $id);
        return $this->db->multiple();
    }


    public function getAllSiswaByKelasDanMapel($kelas_id, $mapel_id)
    {
        $kelas_id = (int) $kelas_id;
        $mapel_id = (int) $mapel_id;

        $query = ("SELECT 
        `siswa`.`id`, 
        `siswa`.`nama`, 
        `siswa`.`nisn`, 
        `siswa`.`id_kelas`, 
        `kelas`.`nama_kelas`, 
        `mapel`.`id_mapel`,
        `mapel`.`nama_mapel`
    FROM `siswa` 
    LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id`
    LEFT JOIN `mapel` ON `mapel`.`id_mapel` = :id_mapel
    WHERE `kelas`.`id` = :kelas_id
    ORDER BY `siswa`.`nama` ASC");

        $this->db->query($query);
        $this->db->bind('kelas_id', $kelas_id);
        $this->db->bind('id_mapel', $mapel_id);
        $this->db->bind('id_mapel', $mapel_id);
        return $this->db->multiple();
    }



}