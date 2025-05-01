<?php

class UserModel extends BaseModel
{
    protected $table = 'useradmin';

    public function where($column, $value)
    {
        $query = "SELECT * FROM $this->table WHERE $column = :value";
        $this->db->query($query);
        $this->db->bind('value', $value);
        return $this->db->single();
    }

    public function store($data)
    {
        try {
            $query = "INSERT INTO $this->table (username, password, role) 
                     VALUES (:username, :password, :role)";

            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

            $this->db->query($query);
            $this->db->bind('username', $data['username']);
            $this->db->bind('password', $hashedPassword);
            $this->db->bind('role', $data['role']);

            $this->db->execute();
            return $this->db->lastInsertId();

        } catch (PDOException $e) {
            error_log("Error in UserModel::store: " . $e->getMessage());
            return false;
        }
    }

    public function updatePassword($userId, $newPassword)
    {
        try {
            $query = "UPDATE $this->table 
                     SET password = :password 
                     WHERE id = :id";

            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            $this->db->query($query);
            $this->db->bind('password', $hashedPassword);
            $this->db->bind('id', $userId);

            return $this->db->execute();

        } catch (PDOException $e) {
            error_log("Error in UserModel::updatePassword: " . $e->getMessage());
            return false;
        }
    }

    public function verifyPassword($userId, $password)
    {
        try {
            $query = "SELECT password FROM $this->table WHERE id = :id";
            $this->db->query($query);
            $this->db->bind('id', $userId);
            $result = $this->db->single();

            return $result && password_verify($password, $result['password']);

        } catch (PDOException $e) {
            error_log("Error in UserModel::verifyPassword: " . $e->getMessage());
            return false;
        }
    }
}