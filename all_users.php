<!DOCTYPE html>
<hmtl lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Activité 2</title>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
    </style>
    </head>

    <body>
        <!-- Connexion à la BD -->
        <?php
        // Connexion à la BD
            $host = 'localhost';
            $db   = 'my_activities';
            $user = 'root';
            $pass = 'root';
            $charset = 'utf8';
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            try {
                 $pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                 throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        ?>

        <!-- Formulaire -->
        <form method="post" action="all_users - 2.php" ID="formRecherche">
            Première lettre du prénom : <input type="text" name="lettre"><br>
            Status du compte :
            <select name="status">
                <option value="active">Active account</option>
                <option value="waiting">Waiting for account validation</option>
            </select>
            <br/><input type="submit" value="Effectuer la recherche">
        </form>

        <?php
            if (isset($_POST['status']) && isset($_POST['lettre'])) {
                // Vérifier qu'une seule lettre à été saisie
                if (strlen($_POST['lettre']) == 1) {
                    $lettre = $_POST['lettre'];
                } else {
                    echo "ERREUR";
                    $lettre = "";
                }
                // Chercher l'ID du status
                if (strcmp($_POST['status'], "active") == 0) {
                    $status = 2;
                } else {
                    $status = 1;
                }
                // Préparation requête
                $stmt = $pdo->query("SELECT users.id AS user_id, username, email, s.name AS status FROM users JOIN status s ON users.status_id = s.id WHERE s.id = $status AND username LIKE '$lettre%' ORDER BY username");
            } else {
                $stmt = $pdo->query("SELECT users.id AS user_id, username, email, s.name AS status FROM users JOIN status s ON users.status_id = s.id ORDER BY username");
            }
                // Entête tableau
                echo"<h1>All users</h1>";
                echo "<table border=\"1px\">";
                echo "<tr>";
                echo "<th>Id</th>";
                echo "<th>Username</th>";
                echo "<th>Email</th>";
                echo "<th>Status</th>";
                echo "</tr>";
                // Récupération des données
                while($row = $stmt->fetch()){
                    // Récupération des données et affichage
                    echo "<tr>";
                    echo "<td>".$row['user_id']."</td>";
                    echo "<td>".$row['username']."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".$row['status']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
        ?>
        </table>
    </body>
</hmtl>