<?php

class MapelModel extends BaseModel
{
    protected $table = "mapel";

    public function getAllMapel()
    {
        $query = "SELECT 
                m.id_mapel,
                m.nama_mapel,
                GROUP_CONCAT(g.nama_guru SEPARATOR '| |') as guru_names
              FROM mapel m
              LEFT JOIN guru_mapel gm ON m.id_mapel = gm.id_mapel
              LEFT JOIN guru g ON gm.id_guru = g.id
              GROUP BY m.id_mapel, m.nama_mapel
              ORDER BY m.nama_mapel ASC";
        $this->db->query($query);
        return $this->db->multiple();
    }

    public function getMapelById($id)
    {
        $query = "SELECT * FROM $this->table WHERE id_mapel = :id_mapel";
        $this->db->query($query);
        $this->db->bind('id_mapel', $id);
        return $this->db->single();
    }


    private function generateKodeMapel($namaMapel)
    {
        $customMappings = [
            'matematika' => 'MTK',
            'pendidikan kewarganegaraan' => 'P.KN',
            'bahasa indonesia' => 'B.Indo',
            'bahasa inggris' => 'B.Ing',
            'ilmu pengetahuan alam' => 'I.PA',
            'ilmu pengetahuan sosial' => 'I.PS',
            'pendidikan agama islam' => 'P.AI',
            'teknologi informasi' => 'T.IK',
            'pendidikan jasmani' => 'P.JOK',
            'seni budaya' => 'S.BD',
            'bahasa arab' => 'B.Arab',
            'bahasa jawa' => 'B.Jawa',
            'prakarya' => 'PKY',
            'al-quran' => 'A.Qur`an',
            'sejarah' => 'SEJ'
        ];

        $namaMapeL = strtolower(trim($namaMapel));

        foreach ($customMappings as $subject => $code) {
            if (strpos($namaMapeL, $subject) !== false) {
                return $code;
            }
        }

        $words = preg_split('/[\s,]+/', $namaMapeL);

        if (count($words) === 1) {
            return strtoupper(substr($words[0], 0, 3));
        } else {
            $kode = strtoupper(substr($words[0], 0, 1)) . '.';
            for ($i = 1; $i < count($words); $i++) {
                if (!empty($words[$i])) {
                    $kode .= strtoupper(substr($words[$i], 0, 1));
                }
            }
            return $kode;
        }
    }

    private function isKodeMapelExists($kode)
    {
        $query = "SELECT COUNT(*) as count FROM $this->table WHERE kode_mapel = :kode_mapel";
        $this->db->query($query);
        $this->db->bind('kode_mapel', $kode);
        return $this->db->single()['count'] > 0;
    }


    public function storeMapel($data)
    {
        $kodeMapel = $this->generateKodeMapel($data['inp_mapel']);

        $query = "INSERT INTO $this->table (nama_mapel, kode_mapel) VALUES (:nama_mapel, :kode_mapel)";
        $this->db->query($query);
        $this->db->bind('nama_mapel', $data['inp_mapel']);
        $this->db->bind('kode_mapel', $kodeMapel);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateMapel($data, $id)
    {
        $kodemapel = $this->generateKodeMapel($data['inp_mapel']);

        $query = "UPDATE $this->table SET nama_mapel = :nama_mapel, kode_mapel = :kode_mapel WHERE id_mapel = :id_mapel";
        $this->db->query($query);
        $this->db->bind('nama_mapel', $data['inp_mapel']);
        $this->db->bind('kode_mapel', $kodemapel);
        $this->db->bind('id_mapel', $id);
        return $this->db->execute();
    }

    public function deleteMapel($id)
    {
        $query = "DELETE FROM $this->table WHERE id_mapel = :id_mapel";
        $this->db->query($query);
        $this->db->bind('id_mapel', $id);
        return $this->db->execute();
    }
}