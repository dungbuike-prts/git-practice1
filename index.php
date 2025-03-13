// created for test ai code review
<?php

// Disable error reporting suppression for clearer demo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Simulate weak authentication checking
$user = $_GET['user'];
$password = $_GET['password'];

$conn = mysqli_connect('localhost', 'root', '', 'testdb');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL injection vulnerability
$query = "SELECT * FROM users WHERE username='$user' AND password='$password'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h1>Welcome, $user</h1>";
} else {
    echo "<h1>Invalid credentials. Please try again.</h1>";
}

// Cross-Site Scripting (XSS) vulnerability
$username = $_GET['username'];
echo "Your username is: " . $username; // directly echoing user-supplied data

// Arbitrary file inclusion vulnerability (Remote File Inclusion)
if(isset($_GET['page'])) {
    include($_GET['page'] . ".php");
}

// Insecure Direct File Access vulnerability
if(isset($_GET['file'])){
    $file = $_GET['file']; // e.g., file=../etc/passwd
    echo file_get_contents($file);
}

// Command injection vulnerability
if(isset($_POST['cmd'])){
    system($_POST['cmd']); // directly executes submitted commands
}

// Dangerous phpinfo() exposure
if(isset($_GET['info'])){
    phpinfo();
}

// Weak session management
session_start();
$_SESSION['user'] = $user;

// Improper logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    echo "You have logged out.";
}

// Allow CORS from any origin (Insecure configuration)
header("Access-Control-Allow-Origin: *");

// Sensitive information output
echo "<br>Debug Info:";
var_dump($_SERVER);
var_dump($_SESSION);

// Hardcoded credentials in comments (bad practice)
// Database admin password: admin123

mysqli_close($conn);
?>
