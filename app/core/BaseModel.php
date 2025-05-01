<?php
class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM {$this->table}");
        return $this->db->multiple();
    }

    public function find($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function where($column, $value)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE $column = :value");
        $this->db->bind(':value', $value);
        return $this->db->multiple();
    }

    public function destroy($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function store($data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ":" . implode(', :', array_keys($data));
        $query = "INSERT INTO {$this->table} ($columns) VALUES ($values)";

        $this->db->query($query);
        foreach ($data as $key => $value) {
            $this->db->bind(":$key", $value);
        }
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function update($id, $data)
    {
        $setQuery = [];
        foreach ($data as $key => $value) {
            $setQuery[] = "$key = :$key";
        }
        $setQuery = implode(', ', $setQuery);
        $query = "UPDATE {$this->table} SET $setQuery WHERE id = :id";

        $this->db->query($query);
        foreach ($data as $key => $value) {
            $this->db->bind(":$key", $value);
        }
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
