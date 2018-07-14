<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="materialize.css">
</head>

<body>
<div class="container">

    <form class="form" action="#" method="post">

        <h1>Sign Up</h1>

        <div class="input-field">
            <label for="user_name" class="label">Your name</label>
            <input type="text" name="user_name" id="user_name" class="input-field">
        </div>

        <!-- <div class="input-field">
            <label for="last_name" class="label">Last name</label>
            <input type="text" name="last_name" id="last_name" class="input-field">
        </div> -->

        <div class="input-field">
            <label for="user_email" class="label">Email address</label>
            <input type="text" name="user_email" id="user_email" class="input-field" required>
        </div>

        <div class="input-field">
            <label for="user_password" class="label">Password</label>
            <input type="text" name="user_password" id="user_password" class="input-field" required>
        </div>

        <div>
            <button class="btn waves-effect waves-light" type="submit" name="submit_signup">Signup</button>
        </div>

    </form>
	</div>

</body>

</html>
<?php
// session_start();

if (isset($_POST['submit_signup'])) //match the button name
{
	echo "start";
    include_once 'conn.php';
    //get data from the form
    // $user_first = mysqli_real_escape_string($conn, $_POST['user_first']); //matches signup form
    // $user_last = mysqli_real_escape_string($conn, $_POST['user_last']); //matches signup form
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']); //matches signup form
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']); //matches signup form
    $user_password = mysqli_real_escape_string($conn, $_POST['user_password']); //matches signup form

	echo $user_name.'<br>';
	echo $user_email.'<br>';
	echo $user_password.'<br>';
    //Error handlers
    //check for empty fields
    // if (empty($user_first) || empty($user_last) || empty($user_email) || empty($user_uid)) {
    if (empty($user_name) || empty($user_email) || empty($user_password)) {

        header("Location: ../signup.php?signup=empty"); //add error message
        exit();
    } else {
		echo "not empty";
        //Check if input characters are valid
        //if(!preg_match("/^[a-zA-Z]*$/", $user_first) ||!preg_match("/^[a-zA-Z]*$/", $user_last) ){//php function that checks for chars in string
        if (0) {
            header("Location: ../signup.php?signup=invalid");
            exit();
		} else { //check if email is valid
			//TODO: check for already existed email
			//TODO: replace header and exist methods to avoid error
			echo "input is valid";
            if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../signup.php?signup=email");
                exit();
            } else {
              	echo "email is valid";
                $sql = "SELECT * FROM Users WHERE name='$user_name'"; //create query
                $result = mysqli_query($conn, $sql); //make query
                $resultCheck = mysqli_num_rows($result); //check if we got any rows in result

                if ($resultCheck > 0) {
                    header("Location: ../signup.php?signup=usertaken");
                    exit();
                } else {
					echo "no same user name";
					$get_valid_id = false;
					$user_id = '';
					while (!$get_valid_id) {
						$user_id = uniqid('user_'); //generate a random post id
						echo $user_id;
				
						$sql_check_post_id = "SELECT * FROM users WHERE id = '$user_id'";
						$same_id = mysqli_query($conn, $sql_check_user_id);
						$num_same_id = mysqli_num_rows($same_id);
						if ($num_same_id == 0) {
							$get_valid_id = true;
						}
					}
					echo '<br/>';
					echo "this user id is:";
					echo $user_id;
				
                    //hashing the password from youtube
                    // $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    //creating activiation hash from website:
                    // $hash = md5(rand(0, 1000)); //activation hash
                    // $password = rand(100000, 999999); //temp password
                    //Insert the user into the database
                    $sql = "INSERT INTO Users (id, name, email, password/*, password, hash*/) VALUES ('$user_id', '$user_name', '$user_email', '$user_password'/*, '$password', '$hash'*/);";

                    mysqli_query($conn, $sql); //insert user data into the database
                    //advenced

                    header("Location: index.php");

                    exit();
                }
            }
        }
    }
} else {
    // header("Location: ../signup.php");//default if ppl change the url
    exit(); //closes the script from running
}
