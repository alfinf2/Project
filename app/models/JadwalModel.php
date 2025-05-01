<?php

class JadwalModel extends BaseModel
{
    protected $table = 'jadwal';

    public function getAllJadwal($id)
    {
        $query = "SELECT `siswa`.`nama`, `siswa`.`id_kelas`, `kelas`.`nama_kelas`, `jadwal`.`hari`, `jadwal`.`jam`, `jadwal`.`waktu`, `jadwal`.`id_kelas`, `mapel`.`nama_mapel`
FROM `siswa` 
	LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id` 
	LEFT JOIN `jadwal` ON `jadwal`.`id_kelas` = `kelas`.`id` 
	LEFT JOIN `mapel` ON `jadwal`.`id_mapel` = `mapel`.`id_mapel`
    WHERE jadwal.id_kelas = :id_kelas";


        $this->db->query($query);
        $this->db->bind('id_kelas', $id);
        return $this->db->multiple();
    }
    public function getJadwalByNisn($id)
    {
        $query = "SELECT `siswa`.`nisn`,`siswa`.`nama` , `kelas`.`id`, `kelas`.`nama_kelas`, `jadwal`.`id_kelas`, `mapel`.`nama_mapel`, `jadwal`.`hari`, `jadwal`.`waktu_mulai`,`jadwal`.`waktu_selesai`, `jadwal`.`jam`
FROM `siswa` 
	LEFT JOIN `kelas` ON `siswa`.`id_kelas` = `kelas`.`id` 
	LEFT JOIN `jadwal` ON `jadwal`.`id_kelas` = `kelas`.`id` 
	LEFT JOIN `mapel` ON `jadwal`.`id_mapel` = `mapel`.`id_mapel`
    WHERE siswa.nisn = :nisn";


        $this->db->query($query);
        $this->db->bind('nisn', $id);
        return $this->db->multiple();
    }



    public function getJadwalById($id)
    {
        $query = "SELECT `jadwal`.`id_kelas`, `jadwal`.`hari`, `mapel`.`nama_mapel`, `kelas`.`id`, `kelas`.`nama_kelas`, `jadwal`.`waktu`, `jadwal`.`jam`
FROM `jadwal` 
	LEFT JOIN `mapel` ON `jadwal`.`id_mapel` = `mapel`.`id_mapel` 
	LEFT JOIN `kelas` ON `jadwal`.`id_kelas` = `kelas`.`id`
    WHERE jadwal.id_kelas = :nisn";
        $this->db->query($query);
        $this->db->bind('nisn', $id);
        return $this->db->multiple();
    }

    public function getJadwalByKelas($id)
    {
        $query = "SELECT j.*, m.nama_mapel, g.nama_guru 
              FROM $this->table j
              JOIN mapel m ON j.id_mapel = m.id_mapel
              JOIN guru g ON j.id_guru = g.id
              WHERE j.id_kelas = :id_kelas";

        $this->db->query($query);
        $this->db->bind('id_kelas', $id);
        return $this->db->multiple();
    }


    public function storeJadwal($data)
    {
        

        $query = "INSERT INTO $this->table (hari, jam, id_kelas, id_mapel, id_guru, waktu_mulai, waktu_selesai) 
                  VALUES (:hari, :jam, :id_kelas, :id_mapel, :id_guru, :waktu_mulai, :waktu_selesai)";

        $this->db->query($query);
        $this->db->bind('hari', $data['hari']);
        $this->db->bind('jam', $data['sesi']);
        $this->db->bind('id_kelas', $data['id_kelas']);
        $this->db->bind('id_mapel', $data['id_mapel']);
        $this->db->bind('id_guru', $data['id_guru']);
        $this->db->bind('waktu_mulai', $data['waktu_mulai']);
        $this->db->bind('waktu_selesai', $data['waktu_selesai']);

        $this->db->execute();
        $jadwal_id = $this->db->lastInsertId();

        
        $query = "INSERT INTO guru_mapel ( id_mapel, id_guru) 
                 VALUES (:id_mapel, :id_guru)";

        $this->db->query($query);
        $this->db->bind('id_mapel', $data['id_mapel']);
        $this->db->bind('id_guru', $data['id_guru']);
        $this->db->execute();

        $this->db->rowCount();

        return [
            'status' => true,
            'message' => 'Jadwal berhasil ditambahkan'
        ];
    }




    public function updateJadwal($data, $id)
    {

        $query = "UPDATE $this->table SET 
                  hari = :hari, 
                  jam = :jam,
                  id_kelas = :id_kelas, 
                  id_mapel = :id_mapel, 
                  id_guru = :id_guru,
                  waktu_mulai = :waktu_mulai, 
                  waktu_selesai = :waktu_selesai 
                  WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('hari', $data['hari']);
        $this->db->bind('jam', $data['sesi']);
        $this->db->bind('id_kelas', $data['id_kelas']);
        $this->db->bind('id_mapel', $data['id_mapel']);
        $this->db->bind('id_guru', $data['id_guru']);
        $this->db->bind('waktu_mulai', $data['waktu_mulai']);
        $this->db->bind('waktu_selesai', $data['waktu_selesai']);
        $this->db->bind('id', $id);

        $this->db->execute();

        $query = "UPDATE guru_mapel SET 
                  id_mapel = :id_mapel,
                  id_guru = :id_guru
                  WHERE id_jadwal = :id_jadwal";

        $this->db->query($query);
        $this->db->bind('id_mapel', $data['id_mapel']);
        $this->db->bind('id_guru', $data['id_guru']);
        $this->db->bind('id_jadwal', $id);
        $this->db->execute();

        $this->db->rowCount();
        return [
            'status' => true,
            'message' => 'Jadwal berhasil diupdate'
        ];
    }

    public function deleteJadwal($id)
    {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->execute();
    }


    public function getDataJadwal()
    {
        $query = "SELECT 
        j.id as jadwal_id,
        j.hari,
        j.jam,
        j.waktu_mulai,
        j.waktu_selesai,
        k.id as kelas_id,
        k.nama_kelas,
        m.id_mapel,
        m.nama_mapel,
        g.id as guru_id,
        g.nama_guru,
        g.nip
    FROM jadwal j
    LEFT JOIN kelas k ON j.id_kelas = k.id
    LEFT JOIN mapel m ON j.id_mapel = m.id_mapel
    LEFT JOIN guru g ON j.id_guru = g.id
    ORDER BY j.hari = 'Senin' DESC, j.hari = 'Selasa' DESC, j.hari = 'Rabu' DESC, j.hari = 'Kamis' DESC, j.hari = 'Jumat' DESC, j.hari = 'Sabtu' DESC, j.jam ASC";

        $this->db->query($query);
        return $this->db->multiple();
    }

}