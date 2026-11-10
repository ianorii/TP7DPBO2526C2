<?php
// tangkap aksi dari parameter URL, default 'read' untuk menampilkan tabel
$action = $_GET['action'] ?? 'read';
?>

<div class="content-box">
    <?php
    switch($action) {
        // form tambah data tim
        case 'create':
            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $team_name = $_POST['team_name'];
                $captain_name = $_POST['captain_name'];
                $contact = $_POST['contact'];

                // simpan tim baru
                $team->addTeam($team_name, $captain_name, $contact);
                header('Location: index.php?option=teams');
                exit;
            }
            ?>
            <div class="form-card">
                <h2>Tambah Tim</h2>
                <form method="POST" action="index.php?option=teams&action=create">
                    <div class="form-group">
                        <label>Nama Tim:</label>
                        <input type="text" name="team_name" required placeholder="Contoh: Fnatic ONIC">
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Kapten:</label>
                        <input type="text" name="captain_name" required placeholder="Contoh: Kairi">
                    </div>
                    
                    <div class="form-group">
                        <label>Kontak / Email:</label>
                        <input type="text" name="contact" required placeholder="Contoh: team@esports.com">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="index.php?option=teams" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
            <?php
            break;

        // form edit data tim
        case 'update':
            $id = $_GET['id'] ?? 0;
            $data = $team->getById($id);

            if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
                $team_name = $_POST['team_name'];
                $captain_name = $_POST['captain_name'];
                $contact = $_POST['contact'];

                // update data tim
                $team->updateTeam($id, $team_name, $captain_name, $contact);
                header('Location: index.php?option=teams');
                exit;
            }
            ?>
            <div class="form-card">
                <h2>Edit Tim</h2>
                <form method="POST" action="index.php?option=teams&action=update&id=<?= $id ?>">
                    <div class="form-group">
                        <label>Nama Tim:</label>
                        <input type="text" name="team_name" value="<?= htmlspecialchars($data['team_name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Kapten:</label>
                        <input type="text" name="captain_name" value="<?= htmlspecialchars($data['captain_name'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Kontak / Email:</label>
                        <input type="text" name="contact" value="<?= htmlspecialchars($data['contact'] ?? '') ?>" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="index.php?option=teams" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
            <?php
            break;

        // proses hapus data tim
        case 'delete':
            $id = $_GET['id'] ?? 0;
            if ($id) {
                $team->deleteTeam($id);
            }
            header('Location: index.php?option=teams');
            exit;

        // tampilan tabel data tim
        default:
            $teams = $team->getTeam();
            ?>
            <div class="page-header">
                <h2>Data Tim</h2>
                <a href="index.php?option=teams&action=create" class="btn btn-primary">+ Tambah Tim</a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Tim</th>
                            <th>Kapten Tim</th>
                            <th>Kontak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($teams)): ?>
                            <tr>
                                <td colspan="5" class="empty-cell">Belum ada data tim.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($teams as $t): ?>
                                <tr>
                                    <td><?= $t['id'] ?></td>
                                    <td><strong><?= htmlspecialchars($t['team_name']) ?></strong></td>
                                    <td><?= htmlspecialchars($t['captain_name']) ?></td>
                                    <td><?= htmlspecialchars($t['contact']) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="index.php?option=teams&action=update&id=<?= $t['id'] ?>" class="btn-action btn-edit">Edit</a>
                                            <a href="index.php?option=teams&action=delete&id=<?= $t['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Hapus Tim?')">Hapus</a>
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
