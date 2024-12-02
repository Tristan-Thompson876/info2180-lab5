<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Retrieve the country parameter from the GET request
$country = $_GET['country'] ?? '';

// Prepare the SQL query to filter by the specified country
$stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name = :country");
$stmt->bindParam(':country', $country, PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
  <tr>
    <th>Country Name</th>
    <th>Continent</th>
    <th>Independence Year</th>
    <th>Head of State</th>
  </tr>
  <?php foreach ($results as $row): ?>
    <tr>
      <td><?= htmlspecialchars($row['name']); ?></td>
      <td><?= htmlspecialchars($row['continent']); ?></td>
      <td><?= htmlspecialchars($row['independence_year']); ?></td>
      <td><?= htmlspecialchars($row['head_of_state']); ?></td>
    </tr>
  <?php endforeach; ?>
</table>