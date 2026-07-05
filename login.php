<?php
session_start();

// If already logged in
if (isset($_SESSION['logged_in'])) {
    header("Location: dashboard/dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Demo credentials
    if ($username === "admin" && $password === "admin123") {

        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = "Administrator";

        header("Location: dashboard/dashboard.php");
        exit;

    } else {

        $error = "Invalid username or password.";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MRM Inventory Login</title>

<link rel="stylesheet" href="styles.css">

<style>

body{
    margin:0;
    font-family:Arial,Helvetica,sans-serif;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-box{
    width:380px;
    background:#fff;
    padding:35px;
    border-radius:10px;
    box-shadow:0 5px 20px rgba(0,0,0,.15);
}

h2{
    text-align:center;
    color:#c62828;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:5px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#c62828;
    color:white;
    font-size:16px;
    cursor:pointer;
    border-radius:5px;
}

button:hover{
    background:#9f1d1d;
}

.error{
    color:red;
    text-align:center;
    margin-bottom:10px;
}

.logo{
    text-align:center;
    margin-bottom:20px;
}

</style>

</head>

<body>

<div class="login-box">

<div class="logo">
<h2>MRM Inventory System</h2>
<p>Mabati Rolling Mills</p>
</div>

<?php if($error!=""): ?>
<div class="error"><?php echo $error; ?></div>
<?php endif; ?>

<form method="post">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button type="submit">
Login
</button>

</form>

</div>

</body>
</html>