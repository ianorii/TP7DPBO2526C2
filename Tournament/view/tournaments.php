<?php
// tangkap aksi dari parameter URL, default 'read' untuk menampilkan tabel
$action = $_GET['action'] ?? 'read';
?>

<div class="content-box">
    <?php
    switch($action) {
        // form tambah data turnamen
        case 'create':
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $name = $_POST['name'];
                $game_title = $_POST['game_title'];
                $start_date = $_POST['start_date'];

                // simpan turnamen baru
                $tournament->addTournament($name, $game_title, $start_date);
                header('Location: index.php?option=tournaments');
                exit;
            }
            ?>
            <div class="form-card">
                <h2>Tambah Turnamen</h2>
                <form method="POST" action="index.php?option=tournaments&action=create">
                    <div class="form-group">
                        <label>Nama Turnamen:</label>
                        <input type="text" name="name" required placeholder="Contoh: MPL Indonesia Season 14">
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Game:</label>
                        <input type="text" name="game_title" required placeholder="Contoh: Mobile Legends: Bang Bang">
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Mulai:</label>
                        <input type="date" name="start_date" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="index.php?option=tournaments" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
            <?php
            break;

        // form edit data turnamen
        case 'update':
            $id = $_GET['id'] ?? 0;
            $data = $tournament->getById($id);

            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $name = $_POST['name'];
                $game_title = $_POST['game_title'];
                $start_date = $_POST['start_date'];

                // update data turnamen
                $tournament->updateTournament($id, $name, $game_title, $start_date);
                header('Location: index.php?option=tournaments');
                exit;
            }
            ?>
            <div class="form-card">
                <h2>Edit Turnamen</h2>
                <form method="POST" action="index.php?option=tournaments&action=update&id=<?= $id ?>">
                    <div class="form-group">
                        <label>Nama Turnamen:</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($data['name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Game:</label>
                        <input type="text" name="game_title" value="<?= htmlspecialchars($data['game_title'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Mulai:</label>
                        <input type="date" name="start_date" value="<?= $data['start_date'] ?? '' ?>" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="index.php?option=tournaments" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
            <?php
            break;

        // proses hapus data turnamen
        case 'delete':
            $id = $_GET['id'] ?? 0;
            if ($id) {
                $tournament->deleteTournament($id);
            }
            header('Location: index.php?option=tournaments');
            exit;

        // tampilan tabel data turnamen
        default:
            $list = $tournament->getTournament();
            ?>
            <div class="page-header">
                <h2>Data Turnamen</h2>
                <a href="index.php?option=tournaments&action=create" class="btn btn-primary">+ Tambah Turnamen</a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Turnamen</th>
                            <th>Nama Game</th>
                            <th>Tanggal Mulai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($list)): ?>
                            <tr>
                                <td colspan="5" class="empty-cell">Belum ada data turnamen.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($list as $t): ?>
                                <tr>
                                    <td><?= $t['id'] ?></td>
                                    <td><strong><?= htmlspecialchars($t['name']) ?></strong></td>
                                    <td><span class="badge"><?= htmlspecialchars($t['game_title']) ?></span></td>
                                    <td><?= date('d M Y', strtotime($t['start_date'])) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="index.php?option=tournaments&action=update&id=<?= $t['id'] ?>" class="btn-action btn-edit">Edit</a>
                                            <a href="index.php?option=tournaments&action=delete&id=<?= $t['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Hapus Turnamen?')">Hapus</a>
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
