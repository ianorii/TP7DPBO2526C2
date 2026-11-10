<?php
require_once __DIR__ . '/../config/db.php';

// class model untuk tabel matches
class MatchModel {
    private $db;

    // constructor koneksi database
    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // ambil semua data match dengan join nama turnamen dan nama tim
    public function getMatch() {
        $stmt = $this->db->prepare("SELECT m.*, 
                    t.name AS tournament_name, 
                    th.team_name AS home_team_name, 
                    ta.team_name AS away_team_name 
             FROM matches m
             LEFT JOIN tournaments t ON m.tournament_id = t.id
             LEFT JOIN teams th ON m.home_team_id = th.id
             LEFT JOIN teams ta ON m.away_team_id = ta.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ambil data match berdasarkan id
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM matches WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // tambah data match baru
    public function addMatch($tournament_id, $home_team_id, $away_team_id, $home_score, $away_score, $match_date, $status) {
        $stmt = $this->db->prepare("INSERT INTO matches VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$tournament_id, $home_team_id, $away_team_id, $home_score, $away_score, $match_date, $status]);
    }

    // update data match
    public function updateMatch($id, $tournament_id, $home_team_id, $away_team_id, $home_score, $away_score, $match_date, $status) {
        $stmt = $this->db->prepare("UPDATE matches SET tournament_id = ?, home_team_id = ?, away_team_id = ?, home_score = ?, away_score = ?, match_date = ?, status = ? WHERE id = ?");
        return $stmt->execute([$tournament_id, $home_team_id, $away_team_id, $home_score, $away_score, $match_date, $status, $id]);
    }

    // hapus data match
    public function deleteMatch($id) {
        $stmt = $this->db->prepare("DELETE FROM matches WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
