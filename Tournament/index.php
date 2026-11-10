<?php
// panggil class model yang dibutuhkan
require_once __DIR__ . '/class/Tournament.php';
require_once __DIR__ . '/class/Team.php';
require_once __DIR__ . '/class/Match.php';

// inisialisasi objek model
$tournament = new Tournament();
$team = new Team();
$match = new MatchModel();

// tangkap opsi halaman dari URL, default ke turnamen
$option = $_GET['option'] ?? 'tournaments';
if (isset($_GET['option'])) {
    $option = $_GET['option'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esports Arena - Tournament Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- navbar navigasi atas -->
    <header class="navbar">
        <div class="nav-container">
            <a href="index.php?option=tournaments" class="brand">
                <span>Esports</span> Arena
            </a>
            <nav class="nav-links">
                <a href="index.php?option=tournaments" class="<?= $option === 'tournaments' ? 'active' : '' ?>">Turnamen</a>
                <a href="index.php?option=teams" class="<?= $option === 'teams' ? 'active' : '' ?>">Tim</a>
                <a href="index.php?option=matches" class="<?= $option === 'matches' ? 'active' : '' ?>">Match</a>
            </nav>
        </div>
    </header>

    <!-- konten utama sesuai menu yang dipilih -->
    <main class="main-container">
        <?php
        switch ($option) {
            case 'tournaments':
                include __DIR__ . '/view/tournaments.php';
                break;
            case 'teams':
                include __DIR__ . '/view/teams.php';
                break;
            case 'matches':
                include __DIR__ . '/view/matches.php';
                break;
            default:
                include __DIR__ . '/view/tournaments.php';
                break;
        }
        ?>
    </main>

    <!-- footer halaman -->
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Esports Arena. Tournament Management System.</p>
    </footer>
</body>
</html>
