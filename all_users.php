<!doctype html>
<html>
<meta charset="UTF-8"/>
<body>
<table>
	<tr>
		<td>Id</td>
		<td>Username</td>
		<td>Email</td>
		<td>Status</td>
	</tr>
<?php 
$host = 'localhost';
$db   = 'my-activities';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';
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

$stmt = $pdo->query('SELECT * FROM users AS user JOIN status AS s ON status_id=s.id WHERE status="Active account" AND user.username LIKE "e%" ORDER BY username');
while ($row = $stmt->fetch())
{
	
    echo "<tr>";
	echo "<td>".$row['id']."</td>";
	echo "<td>".$row['username']."</td>";
	echo "<td>".$row['email']."</td>";
	echo "</tr>";
}


?>
</table>
</body>
</html>