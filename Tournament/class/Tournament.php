<?php
require_once __DIR__ . '/../config/db.php';

// class model untuk tabel tournaments
class Tournament {
    private $db;

    // constructor koneksi database
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // ambil semua data turnamen
    public function getTournament() {
        $stmt = $this->db->prepare("SELECT * FROM tournaments");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ambil data turnamen berdasarkan id
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tournaments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // tambah data turnamen baru
    public function addTournament($name, $game_title, $start_date) {
        $stmt = $this->db->prepare("INSERT INTO tournaments VALUES (NULL, ?, ?, ?)");
        return $stmt->execute([$name, $game_title, $start_date]);
    }

    // update data turnamen
    public function updateTournament($id, $name, $game_title, $start_date) {
        $stmt = $this->db->prepare("UPDATE tournaments SET name = ?, game_title = ?, start_date = ? WHERE id = ?");
        return $stmt->execute([$name, $game_title, $start_date, $id]);
    }

    // hapus data turnamen
    public function deleteTournament($id) {
        $stmt = $this->db->prepare("DELETE FROM tournaments WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
