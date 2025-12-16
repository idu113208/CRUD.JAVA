<?php
class Tracer {
    private $conn;
    private $table_name = "tracer_study";

    public $id_tracer;
    public $id_alumni;
    public $status_kerja;
    public $instansi;
    public $jabatan;
    public $latitude;
    public $longitude;
    public $tahun_mulai_kerja;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function saveOrUpdate() {
        // Check if exists
        $checkQuery = "SELECT id_tracer FROM " . $this->table_name . " WHERE id_alumni = ?";
        $stmtCheck = $this->conn->prepare($checkQuery);
        $stmtCheck->bindParam(1, $this->id_alumni);
        $stmtCheck->execute();

        if($stmtCheck->rowCount() > 0) {
            // Update
            $query = "UPDATE " . $this->table_name . " SET status_kerja=:status_kerja, instansi=:instansi, jabatan=:jabatan, latitude=:latitude, longitude=:longitude, tahun_mulai_kerja=:tahun_mulai_kerja WHERE id_alumni=:id_alumni";
        } else {
            // Insert
            $query = "INSERT INTO " . $this->table_name . " SET id_alumni=:id_alumni, status_kerja=:status_kerja, instansi=:instansi, jabatan=:jabatan, latitude=:latitude, longitude=:longitude, tahun_mulai_kerja=:tahun_mulai_kerja";
        }

        $stmt = $this->conn->prepare($query);

        $this->id_alumni = htmlspecialchars(strip_tags($this->id_alumni));
        $this->status_kerja = htmlspecialchars(strip_tags($this->status_kerja));
        $this->instansi = htmlspecialchars(strip_tags($this->instansi));
        $this->jabatan = htmlspecialchars(strip_tags($this->jabatan));
        // Lat/Long don't need strip_tags if handled correctly, but validation is key.
        // Assuming they come from map click which is number.

        $stmt->bindParam(":id_alumni", $this->id_alumni);
        $stmt->bindParam(":status_kerja", $this->status_kerja);
        $stmt->bindParam(":instansi", $this->instansi);
        $stmt->bindParam(":jabatan", $this->jabatan);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":tahun_mulai_kerja", $this->tahun_mulai_kerja);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAllForMap() {
        // Join with alumni and user to get names
        $query = "SELECT t.*, a.angkatan, a.program_studi, u.nama, a.foto
                  FROM " . $this->table_name . " t
                  JOIN " . $this->table_name_alumni() . " a ON t.id_alumni = a.id_alumni
                  JOIN " . $this->table_name_users() . " u ON a.id_user = u.id_user";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    private function table_name_alumni() { return "alumni"; }
    private function table_name_users() { return "users"; }

    public function getByAlumniId($id_alumni) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_alumni = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id_alumni);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>