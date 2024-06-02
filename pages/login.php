<?php 

session_start();
if(isset($_SESSION['loggedIn'])&&  $_SESSION['loggedIn']===true){
    header('Location: dashboard.php');
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/notes-app' . '/database/dbConnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/notes-app/css/main.css">
</head>
<body>
<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/notes-app' . '/includes/_header.php'; 
?>
<form action="/notes-app/pages/login.php" method="POST" class="form flex">
    <h1>
        Login
    </h1>
    <div class="formField flex">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="formField flex">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <input type="submit" class="button submitButton" value="Login" name="login">
</form>
</body>
</html>

<?php

if(isset($_POST['login'])){

    $email =  $_POST['email'];
    $password =  $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        
        $passwordCheck = password_verify($password,$row['password']);

        if($passwordCheck){
            echo "login success";
            session_start();
            $_SESSION['loggedIn'] = true;
            $_SESSION['name'] = $row['name'];
            header("Location: dashboard.php");
        }
        else{
            echo 'incorrect password!';
        }
    }
    else{
        echo "no user";
    }
    
}

?>