<?php

class GuruModel extends BaseModel
{

    protected $table = "guru";


    public function getAllData(){
        $query = "SELECT * FROM guru
        ORDER BY nama_guru ASC";
        $this->db->query($query);
        return $this->db->multiple();
    }


    public function getGuruByKode($id)
    {
        $query = "SELECT `guru`.`id`, `guru`.`kode_guru`, `guru`.`nama_guru`, `useradmin`.`guru_id`
FROM `guru` 
	LEFT JOIN `useradmin` ON `useradmin`.`guru_id` = `guru`.`id`
    WHERE guru.id =:id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }


    public function getGuruDanMapel()
    {
        $query = "SELECT `guru`.`id`, `guru`.`kode_guru`, `guru`.`nama_guru`, 
                     `guru`.`nip`, `guru`.`id_mapel`, `mapel`.`nama_mapel`, 
                     `mapel`.`kode_mapel`,`mapel`.`id_guru`, `guru`.`alamat`, `guru`.`telp`, 
                     `guru`.`email`
             FROM `guru` 
             LEFT JOIN `mapel` ON `guru`.`id_mapel` = `mapel`.`id_mapel`
             ORDER BY `guru`.`nama_guru` ASC";

        $this->db->query($query);
        return $this->db->multiple();
    }

    private function generateKodeGuru($nama)
    {
        $words = explode(' ', strtoupper($nama));
        $kode = '';
        foreach ($words as $word) {
            $kode .= substr($word, 0, 1);
        }
        return $kode;
    }

    public function storeGuru($data)
    {
        $kode_guru = $this->generateKodeGuru($data['inp_user']);

        $query = "INSERT INTO guru (
            kode_guru, nama_guru, nip, alamat, telp, email
        ) VALUES (
            :kode_guru, :nama_guru, :nip, :alamat, :telp, :email
        )";

        $this->db->query($query);

        $this->db->bind('kode_guru', $kode_guru);
        $this->db->bind('nama_guru', $data['inp_user']);
        $this->db->bind('nip', $data['inp_nip']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('telp', $data['telp']);
        $this->db->bind('email', $data['email']);

        $this->db->execute();

        $guru_Id = $this->db->lastInsertId();

        if ($guru_Id) {
            $userResult = $this->createUserGuru([
                'username' => $data['inp_user'],
                'nuptk' => $data['inp_nip'],
                'guru_id' => $guru_Id
            ]);

            if ($userResult) {
                $this->db->rowCount();
                return true;
            }
        }

    }


    public function createUserGuru($data)
    {
        $defaultPassword = '$2y$10$djXua.hhO3lfVjk/2rU4FO.zTtJ0fib7fBZSVmp5b0Ec1FNTWzysa';
        $defaultRole = 'guru';
        $query = "INSERT INTO useradmin(username, nuptk, password, role, guru_id)
        VALUES (:username, :nuptk, :password, :role, :guru_id)";

        $this->db->query($query);
        $this->db->bind('username', $data['username']);
        $this->db->bind('nuptk', $data['nuptk']);
        $this->db->bind('password', $defaultPassword);
        $this->db->bind('role', $defaultRole);
        $this->db->bind('guru_id', $data['guru_id']);

        return $this->db->execute();
    }

    private function getMapelId($mapel_name)
    {
        $query = "SELECT id_mapel FROM mapel WHERE nama_mapel = :nama_mapel";
        $this->db->query($query);
        $this->db->bind('nama_mapel', $mapel_name);
        return $this->db->single()['id_mapel'];
    }

    public function updateGuru($data, $id)
    {



        $kode_guru = $this->generateKodeGuru($data['inp_user']);

        $query = "UPDATE $this->table SET
                kode_guru = :kode_guru,
                nama_guru = :nama_guru,
                nip = :nip,
                alamat = :alamat,
                telp = :telp,
                email = :email
                WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('kode_guru', $kode_guru);
        $this->db->bind('nama_guru', $data['inp_user']);
        $this->db->bind('nip', $data['inp_nip']);
        $this->db->bind('alamat', $data['alamat']);
        $this->db->bind('telp', $data['telp']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('id', $id);

        $this->db->execute();

        $queryAdmin = "UPDATE useradmin SET 
                      username = :username,
                      nuptk = :nuptk
                      WHERE guru_id = :guru_id";

        $this->db->query($queryAdmin);
        $this->db->bind('username', $data['inp_user']);
        $this->db->bind('nuptk', $data['inp_nip']);
        $this->db->bind('guru_id', $id);

        $this->db->execute();


    }



    public function getGuruById($id)
    {
        $query = "SELECT guru.*, mapel.nama_mapel 
              FROM guru 
              LEFT JOIN mapel ON guru.id_mapel = mapel.id_mapel 
              WHERE guru.id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }



    public function changePassword($guru_id, $old_password, $new_password)
    {
        try {
            $query = "SELECT ua.password 
                     FROM useradmin ua 
                     INNER JOIN guru g ON ua.guru_id = g.id 
                     WHERE ua.guru_id = :guru_id";
            $this->db->query($query);
            $this->db->bind('guru_id', $guru_id);
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

            $update_query = "UPDATE useradmin SET password = :password WHERE guru_id = :guru_id";
            $this->db->query($update_query);
            $this->db->bind('password', $hashed_password);
            $this->db->bind('guru_id', $guru_id);

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

    public function deleteGuru($id)
    {




        $queryAdmin = "DELETE FROM useradmin WHERE guru_id = :guru_id";
        $this->db->query($queryAdmin);
        $this->db->bind('guru_id', $id);
        $this->db->execute();



        $queryGuru = "DELETE FROM $this->table WHERE id = :id";
        $this->db->query($queryGuru);
        $this->db->bind('id', $id);
        $this->db->execute();

    }


}