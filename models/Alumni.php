<?php
class Alumni {
    private $conn;
    private $table_name = "alumni";

    public $id_alumni;
    public $id_user;
    public $npm;
    public $angkatan;
    public $program_studi;
    public $foto;
    public $alamat;
    public $no_hp;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET id_user=:id_user, npm=:npm, angkatan=:angkatan, program_studi=:program_studi, alamat=:alamat, no_hp=:no_hp, foto=:foto";
        $stmt = $this->conn->prepare($query);

        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $this->npm = htmlspecialchars(strip_tags($this->npm));
        $this->angkatan = htmlspecialchars(strip_tags($this->angkatan));
        $this->program_studi = htmlspecialchars(strip_tags($this->program_studi));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->no_hp = htmlspecialchars(strip_tags($this->no_hp));
        // Foto is path, assume sanitized before setting

        $stmt->bindParam(":id_user", $this->id_user);
        $stmt->bindParam(":npm", $this->npm);
        $stmt->bindParam(":angkatan", $this->angkatan);
        $stmt->bindParam(":program_studi", $this->program_studi);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":no_hp", $this->no_hp);
        $stmt->bindParam(":foto", $this->foto);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getByUserId($id_user) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_user = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_user);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $query = "SELECT a.*, u.nama, u.email FROM " . $this->table_name . " a JOIN users u ON a.id_user = u.id_user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_alumni = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET npm=:npm, angkatan=:angkatan, program_studi=:program_studi, alamat=:alamat, no_hp=:no_hp, foto=:foto WHERE id_user=:id_user";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":npm", $this->npm);
        $stmt->bindParam(":angkatan", $this->angkatan);
        $stmt->bindParam(":program_studi", $this->program_studi);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":no_hp", $this->no_hp);
        $stmt->bindParam(":foto", $this->foto);
        $stmt->bindParam(":id_user", $this->id_user);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>