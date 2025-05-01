<?php

class KelasModel extends BaseModel
{
    protected $table = "kelas";


    public function getKelasById($id)
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        return $this->db->single();
    }
}