<?php
require_once __DIR__ . '/../config/db.php';

// class model untuk tabel teams
class Team {
    private $db;

    // constructor koneksi database
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // ambil semua data tim
    public function getTeam() {
        $stmt = $this->db->prepare("SELECT * FROM teams");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ambil data tim berdasarkan id
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM teams WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // tambah data tim baru
    public function addTeam($team_name, $captain_name, $contact) {
        $stmt = $this->db->prepare("INSERT INTO teams VALUES (NULL, ?, ?, ?)");
        return $stmt->execute([$team_name, $captain_name, $contact]);
    }

    // update data tim
    public function updateTeam($id, $team_name, $captain_name, $contact) {
        $stmt = $this->db->prepare("UPDATE teams SET team_name = ?, captain_name = ?, contact = ? WHERE id = ?");
        return $stmt->execute([$team_name, $captain_name, $contact, $id]);
    }

    // hapus data tim
    public function deleteTeam($id) {
        $stmt = $this->db->prepare("DELETE FROM teams WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
