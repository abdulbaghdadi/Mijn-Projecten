<?php
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$birthdate = $_POST['birthdate'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];
$email = $_POST['email'];

$servername = "rdbms.strato.de";
$username = "dbu5573129";
$password = "Aa4454607!";
$dbname = "dbs11158012";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO bestellen (name, lastname, birthdate, mobile, address, email) VALUES ('$name', '$lastname', '$birthdate', '$mobile', '$address', '$email')";

if ($conn->query($sql) === true) {
    echo "Data inserted successfully.";

    $selectQuery = "SELECT * FROM bestellen";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        echo '<table style="border-collapse: collapse; width: 100%;">';
        echo '<tr style="background-color: #f2f2f2;"><th style="padding: 10px; text-align: left;">Name</th><th style="padding: 10px; text-align: left;">Last Name</th><th style="padding: 10px; text-align: left;">Birthdate</th><th style="padding: 10px; text-align: left;">Mobile</th><th style="padding: 10px; text-align: left;">Address</th><th style="padding: 10px; text-align: left;">Email</th></tr>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr style="border-bottom: 1px solid #ddd;">';
            echo '<td style="padding: 10px;">' . $row["name"] . '</td>';
            echo '<td style="padding: 10px;">' . $row["lastname"] . '</td>';
            echo '<td style="padding: 10px;">' . $row["birthdate"] . '</td>';
            echo '<td style="padding: 10px;">' . $row["mobile"] . '</td>';
            echo '<td style="padding: 10px;">' . $row["address"] . '</td>';
            echo '<td style="padding: 10px;">' . $row["email"] . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo "No records found.";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
