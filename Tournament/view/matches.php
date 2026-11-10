<?php
// tangkap aksi dari parameter URL, default 'read' untuk menampilkan tabel
$action = $_GET['action'] ?? 'read';
?>

<div class="content-box">
    <?php
    switch($action) {
        // form tambah jadwal match
        case 'create':
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $tournament_id = $_POST['tournament_id'];
                $home_team_id = $_POST['home_team_id'];
                $away_team_id = $_POST['away_team_id'];
                $home_score = $_POST['home_score'];
                $away_score = $_POST['away_score'];
                $match_date = $_POST['match_date'];
                $status = $_POST['status'];

                // simpan match baru
                $match->addMatch($tournament_id, $home_team_id, $away_team_id, $home_score, $away_score, $match_date, $status);
                header('Location: index.php?option=matches');
                exit;
            }
            $tournament_list = $tournament->getTournament();
            $team_list = $team->getTeam();
            ?>
            <div class="form-card">
                <h2>Tambah Match</h2>
                <form method="POST" action="index.php?option=matches&action=create">
                    <div class="form-group">
                        <label>Turnamen:</label>
                        <select name="tournament_id" required>
                            <option value="">-- Pilih Turnamen --</option>
                            <?php foreach ($tournament_list as $t): ?>
                                <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?> (<?= htmlspecialchars($t['game_title']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tim 1 (Home):</label>
                        <select name="home_team_id" required>
                            <option value="">-- Pilih Tim 1 --</option>
                            <?php foreach ($team_list as $tm): ?>
                                <option value="<?= $tm['id'] ?>"><?= htmlspecialchars($tm['team_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tim 2 (Away):</label>
                        <select name="away_team_id" required>
                            <option value="">-- Pilih Tim 2 --</option>
                            <?php foreach ($team_list as $tm): ?>
                                <option value="<?= $tm['id'] ?>"><?= htmlspecialchars($tm['team_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Skor Tim 1:</label>
                            <input type="number" name="home_score" min="0" value="0" required>
                        </div>
                        <div class="form-group">
                            <label>Skor Tim 2:</label>
                            <input type="number" name="away_score" min="0" value="0" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tanggal & Waktu:</label>
                        <input type="datetime-local" name="match_date" required>
                    </div>

                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="Scheduled">Scheduled</option>
                            <option value="Finished">Finished</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="index.php?option=matches" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
            <?php
            break;

        // form edit data match
        case 'update':
            $id = $_GET['id'] ?? 0;
            $data = $match->getById($id);

            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $tournament_id = $_POST['tournament_id'];
                $home_team_id = $_POST['home_team_id'];
                $away_team_id = $_POST['away_team_id'];
                $home_score = $_POST['home_score'];
                $away_score = $_POST['away_score'];
                $match_date = $_POST['match_date'];
                $status = $_POST['status'];

                // update data match
                $match->updateMatch($id, $tournament_id, $home_team_id, $away_team_id, $home_score, $away_score, $match_date, $status);
                header('Location: index.php?option=matches');
                exit;
            }
            $tournament_list = $tournament->getTournament();
            $team_list = $team->getTeam();
            ?>
            <div class="form-card">
                <h2>Edit Match</h2>
                <form method="POST" action="index.php?option=matches&action=update&id=<?= $id ?>">
                    <div class="form-group">
                        <label>Turnamen:</label>
                        <select name="tournament_id" required>
                            <option value="">-- Pilih Turnamen --</option>
                            <?php foreach ($tournament_list as $t): ?>
                                <option value="<?= $t['id'] ?>" <?= ($data['tournament_id'] == $t['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t['name']) ?> (<?= htmlspecialchars($t['game_title']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tim 1 (Home):</label>
                        <select name="home_team_id" required>
                            <option value="">-- Pilih Tim 1 --</option>
                            <?php foreach ($team_list as $tm): ?>
                                <option value="<?= $tm['id'] ?>" <?= ($data['home_team_id'] == $tm['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($tm['team_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tim 2 (Away):</label>
                        <select name="away_team_id" required>
                            <option value="">-- Pilih Tim 2 --</option>
                            <?php foreach ($team_list as $tm): ?>
                                <option value="<?= $tm['id'] ?>" <?= ($data['away_team_id'] == $tm['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($tm['team_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Skor Tim 1:</label>
                            <input type="number" name="home_score" min="0" value="<?= $data['home_score'] ?? 0 ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Skor Tim 2:</label>
                            <input type="number" name="away_score" min="0" value="<?= $data['away_score'] ?? 0 ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tanggal & Waktu:</label>
                        <input type="datetime-local" name="match_date" value="<?= isset($data['match_date']) ? date('Y-m-d\TH:i', strtotime($data['match_date'])) : '' ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="Scheduled" <?= (($data['status'] ?? '') === 'Scheduled') ? 'selected' : '' ?>>Scheduled</option>
                            <option value="Finished" <?= (($data['status'] ?? '') === 'Finished') ? 'selected' : '' ?>>Finished</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="index.php?option=matches" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
            <?php
            break;

        // proses hapus data match
        case 'delete':
            $id = $_GET['id'] ?? 0;
            if ($id) {
                $match->deleteMatch($id);
            }
            header('Location: index.php?option=matches');
            exit;

        // tampilan tabel data match
        default:
            $matches = $match->getMatch();
            ?>
            <div class="page-header">
                <h2>Data Match</h2>
                <a href="index.php?option=matches&action=create" class="btn btn-primary">+ Tambah Match</a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Turnamen</th>
                            <th>Tim 1</th>
                            <th>Tim 2</th>
                            <th>Score 1</th>
                            <th>Score 2</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($matches)): ?>
                            <tr>
                                <td colspan="9" class="empty-cell">Belum ada data match.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($matches as $m): ?>
                                <tr>
                                    <td><?= $m['id'] ?></td>
                                    <td><?= htmlspecialchars($m['tournament_name'] ?? $m['tournament_id']) ?></td>
                                    <td><strong><?= htmlspecialchars($m['home_team_name'] ?? $m['home_team_id']) ?></strong></td>
                                    <td><strong><?= htmlspecialchars($m['away_team_name'] ?? $m['away_team_id']) ?></strong></td>
                                    <td><span class="score"><?= $m['home_score'] ?></span></td>
                                    <td><span class="score"><?= $m['away_score'] ?></span></td>
                                    <td><?= date('d M Y, H:i', strtotime($m['match_date'])) ?></td>
                                    <td>
                                        <span class="badge <?= $m['status'] === 'Finished' ? 'badge-finished' : 'badge-scheduled' ?>">
                                            <?= $m['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="index.php?option=matches&action=update&id=<?= $m['id'] ?>" class="btn-action btn-edit">Edit</a>
                                            <a href="index.php?option=matches&action=delete&id=<?= $m['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Hapus Match?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php
            break;
    }
    ?>
</div>
