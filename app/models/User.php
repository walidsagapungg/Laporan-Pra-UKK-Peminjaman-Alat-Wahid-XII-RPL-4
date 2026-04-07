<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $password;
    public $email;
    public $nama_lengkap;
    public $role;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Users
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Get User by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get User by Username
    public function getByUsername($username) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create User
    public function create() {
        $query = "INSERT INTO " . $this->table . "
                  (username, password, email, nama_lengkap, role, status)
                  VALUES (:username, :password, :email, :nama_lengkap, :role, :status)";
        
        $stmt = $this->conn->prepare($query);

        $hashedPassword = hash('sha256', $this->password);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':nama_lengkap', $this->nama_lengkap);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':status', $this->status);

        return $stmt->execute();
    }

    // Update User
    public function update() {
        $query = "UPDATE " . $this->table . "
                  SET username = :username,
                      email = :email,
                      nama_lengkap = :nama_lengkap,
                      role = :role,
                      status = :status";

        if (!empty($this->password)) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        if (!empty($this->password)) {
            $hashedPassword = hash('sha256', $this->password);
            $stmt->bindParam(':password', $hashedPassword);
        }

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':nama_lengkap', $this->nama_lengkap);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':status', $this->status);

        return $stmt->execute();
    }

    // Delete User
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Verify Login
    public function verifyLogin($username, $password) {
        $user = $this->getByUsername($username);
        if ($user && hash('sha256', $password) === $user['password']) {
            return $user;
        }
        return false;
    }

    // Get by Role
    public function getByRole($role) {
        $query = "SELECT * FROM " . $this->table . " WHERE role = :role AND status = 'aktif' ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        return $stmt;
    }
}
?>
