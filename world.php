<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Retrieve the country and lookup parameters from the GET request
$country = $_GET['country'] ?? '';
$lookup = $_GET['lookup'] ?? 'country';

if ($lookup === 'cities') {
    // Query to get cities in the specified country
    $stmt = $conn->prepare("
        SELECT cities.name, cities.district, cities.population 
        FROM cities 
        JOIN countries ON cities.country_code = countries.code 
        WHERE countries.name LIKE :country
    ");
} else {
    // Query to get country information
    $stmt = $conn->prepare("
        SELECT name, continent, independence_year, head_of_state 
        FROM countries 
        WHERE name LIKE :country
    ");
}

$country = "%$country%";
$stmt->bindParam(':country', $country, PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($lookup === 'cities') {
    // Output cities in an HTML table
    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>";
    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['district']) . "</td>
                <td>" . htmlspecialchars($row['population']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    // Output country information in an HTML table
    echo "<table border='1'>
            <tr>
                <th>Country Name</th>
                <th>Continent</th>
                <th>Independence Year</th>
                <th>Head of State</th>
            </tr>";
    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['continent']) . "</td>
                <td>" . htmlspecialchars($row['independence_year']) . "</td>
                <td>" . htmlspecialchars($row['head_of_state']) . "</td>
              </tr>";
    }
    echo "</table>";
}
?>