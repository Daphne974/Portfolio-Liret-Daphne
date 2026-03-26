<?php
include 'connexionBDD.php';

$sql = "SELECT * FROM Film";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>DebugCiné</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            text-align: center;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }
        .film-card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            position: relative;
        }
        .film-card button {
            background: #3498db;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
            text-align: left;
        }
        .film-card button:hover {
            background: #2980b9;
        }
        .details {
            display: none;
            margin-top: 15px;
            line-height: 1.6;
        }
        .details.active {
            display: block;
        }
    </style>
    <script>
        function toggleDetails(id) {
            // Masquer tous les blocs de détails
            const allDetails = document.querySelectorAll('.details');
            allDetails.forEach(detail => {
                if (detail.id !== id) {
                    detail.classList.remove('active');
                }
            });

            // Afficher ou masquer celui cliqué
            const clickedDetail = document.getElementById(id);
            clickedDetail.classList.toggle('active');
        }
    </script>
</head>
<body>
    <header>
        <h1>🎬 DebugCiné</h1>
        <p>Explorez vos films préférés</p>
    </header>

    <div class="container">
        <?php foreach ($result as $film): ?>
            <div class="film-card">
                <button onclick="toggleDetails('film_<?php echo $film['idFilm']; ?>')">
                    <?php echo htmlspecialchars($film['titre']); ?>
                </button>

                <div id="film_<?php echo $film['idFilm']; ?>" class="details">
                    <p><strong>Genre :</strong> <?php echo htmlspecialchars($film['genre']); ?></p>
                    <p><strong>Année :</strong> <?php echo htmlspecialchars($film['annee']); ?></p>
                    <p><strong>Pays :</strong> <?php echo htmlspecialchars($film['codePays']); ?></p>
                    <p><strong>Résumé :</strong> <?php echo htmlspecialchars($film['resume']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
