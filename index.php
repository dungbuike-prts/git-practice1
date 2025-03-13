// created for test ai code review
<?php

// Only show errors in development environment
if (getenv('ENVIRONMENT') === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Simulate weak authentication checking
$user = $_GET['user'];
$password = $_GET['password'];

$conn = mysqli_connect('localhost', 'root', '', 'testdb');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL injection vulnerability
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=? AND password=?");
mysqli_stmt_bind_param($stmt, "ss", $user, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h1>Welcome, $user</h1>";
} else {
    echo "<h1>Invalid credentials. Please try again.</h1>";
}

// Cross-Site Scripting (XSS) vulnerability
$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
echo "Your username is: " . htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
// Arbitrary file inclusion vulnerability (Remote File Inclusion)
if(isset($_GET['page'])) {
    include($_GET['page'] . ".php");
}

// Insecure Direct File Access vulnerability
if(isset($_GET['file'])){
    $file = $_GET['file']; // e.g., file=../etc/passwd
    echo file_get_contents($file);
}

// Remove this feature or sanitize very carefully (e.g., whitelist).

// Dangerous phpinfo() exposure
// Remove or wrap in strict access checks for authorized admins only

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
header("Access-Control-Allow-Origin: https://your-trusted-domain.com");
// Sensitive information output
// Remove or wrap in debug flags restricted to development
// Hardcoded credentials in comments (bad practice)
// Database admin password: admin123

mysqli_close($conn);
?>
