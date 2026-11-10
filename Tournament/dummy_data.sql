-- database turnamen esports
CREATE DATABASE IF NOT EXISTS db_tournament;
USE db_tournament;

-- 1. tabel tournaments
CREATE TABLE IF NOT EXISTS tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    game_title VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL
);

-- 2. tabel teams
CREATE TABLE IF NOT EXISTS teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    captain_name VARCHAR(255) NOT NULL,
    contact VARCHAR(255) NOT NULL
);

-- 3. tabel matches
CREATE TABLE IF NOT EXISTS matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tournament_id INT NOT NULL,
    home_team_id INT NOT NULL,
    away_team_id INT NOT NULL,
    home_score INT DEFAULT 0,
    away_score INT DEFAULT 0,
    match_date DATETIME NOT NULL,
    status ENUM('Scheduled','Finished') DEFAULT 'Scheduled',
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE,
    FOREIGN KEY (home_team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (away_team_id) REFERENCES teams(id) ON DELETE CASCADE
);

-- data dummy turnamen
INSERT INTO tournaments (id, name, game_title, start_date) VALUES
(1, 'MPL Indonesia Season 14', 'Mobile Legends: Bang Bang', '2026-11-10'),
(2, 'VCT Masters Tokyo', 'Valorant', '2026-11-15'),
(3, 'The International 2026', 'Dota 2', '2026-12-01'),
(4, 'PUBG Mobile Global Championship', 'PUBG Mobile', '2026-12-05'),
(5, 'ESL Pro League Season 20', 'Counter-Strike 2', '2026-12-12')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- data dummy tim
INSERT INTO teams (id, team_name, captain_name, contact) VALUES
(1, 'Fnatic ONIC', 'Kairi', 'management@onic-esports.com'),
(2, 'RRQ Hoshi', 'Skylar', 'contact@teamrrq.com'),
(3, 'EVOS Glory', 'Branz', 'team@evos.gg'),
(4, 'Paper Rex', 'f0rsakeN', 'prx@teampprx.gg'),
(5, 'Sentinels', 'TenZ', 'info@sentinels.gg'),
(6, 'Team Spirit', 'Yatoro', 'contact@teamspirit.ru'),
(7, 'Team Liquid', 'Nisha', 'hq@teamliquid.com'),
(8, 'Bigetron RA', 'Ryzen', 'corp@bigetron.gg')
ON DUPLICATE KEY UPDATE team_name=VALUES(team_name);

-- data dummy match
INSERT INTO matches (id, tournament_id, home_team_id, away_team_id, home_score, away_score, match_date, status) VALUES
(1, 1, 1, 2, 2, 1, '2026-11-10 18:30:00', 'Finished'),
(2, 1, 3, 1, 0, 2, '2026-11-12 19:00:00', 'Finished'),
(3, 2, 4, 5, 1, 2, '2026-11-15 17:00:00', 'Finished'),
(4, 3, 6, 7, 0, 0, '2026-12-01 20:00:00', 'Scheduled'),
(5, 1, 2, 3, 0, 0, '2026-12-03 19:30:00', 'Scheduled'),
(6, 2, 5, 4, 0, 0, '2026-12-08 16:00:00', 'Scheduled')
ON DUPLICATE KEY UPDATE status=VALUES(status);
