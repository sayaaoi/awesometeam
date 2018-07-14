<!DOCTYPE html>
<html>

<head>
  <title></title>
    <link rel="stylesheet" href="materialize.css"/>
</head>

<body>
    <form class="form" action="#" method="post">
        <button class="btn waves-effect waves-light" type="submit" name="submit_logout">OK</button>
    </form>
</body>
</html>
<?php
session_start();

if (isset($_POST['submit_logout'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
