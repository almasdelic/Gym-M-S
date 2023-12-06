<?php

include 'config.php'; // konekcija na bazu

if ($_SERVER ['REQUEST_METHOD'] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT admin_id, password FROM admins WHERE username = ? "; // sql querry

    $run = $conn->prepare($sql); // pripremimo sql querry za izvršenje

    $run-> bind_param("s", $username); //jedno s je string i odnosi se na username u sql querry-u, i $username mijenja ? u sql querry

    $run->execute();  // izvršimo 

    $results = $run->get_result();  // onda uzmemo dobijene rezultate


    if ($results->num_rows == 1) {  // ako je vratio 1 red iz tabele (jer je jedan admin sa username 'admin')
        
        $admin = $results->fetch_assoc(); // iz rezultata dobijamo asocijativni niz - key i value

        if (password_verify($password, $admin['password'])) { // da li je zasticeni password iz baze jednak onom koji je user unio
            $_SESSION['admin_id'] = $admin['admin_id'];

            $conn->close(); // zatvaramo konekciju sa bazom

            header('location: admin_dashboard.php');
        } else {
            $_SESSION['error'] = "Netacan password";

            $conn->close(); // zatvaramo konekciju sa bazom

            header('location: index.php');
            exit;
        }

    } else {
        $_SESSION['error'] = "Netacan username";

        $conn->close(); // zatvaramo konekciju sa bazom

        header('location: index.php');
        exit;
    }


}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        form input {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
<?php

if(isset($_SESSION['error'])) {
    echo $_SESSION['error'] . "<br>";
    unset($_SESSION['error']);
}

?>

<form action="" method="post">
    <h1>Gym Management System</h1>
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
