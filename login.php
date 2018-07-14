<!DOCTYPE html>
<html>

<head>
    <title>User Log In</title>
    <link rel="stylesheet" href="materialize.css"/>
</head>

<body>
    <div class="container">

    <form class="form" action="#" method="post">
        <h1>Log In</h1>

        <div class="input-field">
            <label for="user_name" class="label">Your name</label>
            <input type="text" name="user_name" id="user_name" class="input-field">
        </div>

        <div class="input-field">
            <label for="user_password" class="label">Password</label>
            <input type="text" name="user_password" id="user_password" class="input-field" required>
        </div>

        <div>
            <button class="btn waves-effect waves-light" type="submit" name="submit_login">Log In</button>
        </div>

    </form>

</body>

</html>
<?php
session_start();

if (isset($_POST['submit_login'])) //match the button name
{
    include_once 'conn.php';
    //get data from the form
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']); //matches signup form
    $user_password = mysqli_real_escape_string($conn, $_POST['user_password']); //matches signup form

    if (empty($user_name) || empty($user_password)) {
        header("Location: ../login.php?login=empty");
        exit();
    } else {
        $sql = "SELECT * FROM Users WHERE (name='$user_name' OR email='$user_name') AND password = '$user_password'"; //create query
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: ../login.php?login=error1");
            exit();
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['u_id'] = $row['id'];
                $_SESSION['u_name'] = $row['name'];
                $_SESSION['u_email'] = $row['email'];
                header("Location: index.php");
                exit();
            }
        }
    }
} 

?>
