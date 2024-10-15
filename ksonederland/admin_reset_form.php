<!-- admin_dashboard.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
        <style>
        /* Base styles for the body */
        body {
            font-family: Arial, sans-serif;
            background-color:  #F7ECD8;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Heading styles */
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form styles */
        form {
            text-align: center;
            margin-top: 20px;
        }

        form label {
            font-weight: bold;
        }

        form select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        form button {
            background-color: #3C6E71;
            color: #fff;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        form button:hover {
            background-color: #284B63;
        }
        p a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3C6E71;
    text-decoration: none;
    color: #fff;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Form to select user -->
    <form action="reset_form.php" method="GET">
        <label>Kies Gebruiker:</label>
        <select name="gebruiker_id">
            <?php
        require_once 'connectie.php';
        session_start();

            // Fetch users from database
            $stmt_users = $pdo->query("SELECT Gebruiker_id, Bedrijfsnaam, Voornaam FROM gebruiker");
            while ($user = $stmt_users->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value=\"" . $user['Gebruiker_id'] . "\">" . $user['Bedrijfsnaam'] . "</option>";
            }
            ?>
        </select>
        <button type="submit">Anpassen</button>
    </form>
    <p><a href="welcome_admin.php">Terug</a></p>

</body>
</html>
