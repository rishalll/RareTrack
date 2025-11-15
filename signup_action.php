<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include 'connection.php';

    $errors = [];

    // Trim input
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate required fields
    if ($name === '' || !preg_match("/^[A-Za-z\s]{3,50}$/", $name)) {
        echo "<script>alert('Invalid or missing name.');window.location='signup.php'</script>";
        exit;
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email address.');window.location='signup.php'</script>";
        exit;
    }
    if ($phone === '' || !preg_match("/^[6-9][0-9]{9}$/", $phone)) {
        echo "<script>alert('Invalid phone number.');window.location='signup.php'</script>";
        exit;
    }
    if ($address === '') {
        echo "<script>alert('Address is required.');window.location='signup.php'</script>";
        exit;
    }
    if ($username === '' || !preg_match("/^[A-Za-z0-9_]{5,15}$/", $username)) {
        echo "<script>alert('Invalid username.');window.location='signup.php'</script>";
        exit;
    }
    if ($password === '' || !preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,20}$/", $password)) {
        echo "<script>alert('Invalid password.');window.location='signup.php'</script>";
        exit;
    }

    if (!empty($errors)) {
        // Show all validation errors and stop
        foreach ($errors as $e) {
            echo "<p style='color:red;'>$e</p>";
        }
        exit;
    }

    // ✅ Check if username already exists
    $str = "SELECT * FROM login WHERE username='$username'";
    $result = mysqli_query($con, $str);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username already exists');window.location='signup.php'</script>";
        exit;
    }

    // ✅ Insert into login (password should be hashed!)
    $query = "INSERT INTO login(username, password, user_type, user_status)
              VALUES('$username', '$password', 'contributor', 'pending')";
    mysqli_query($con, $query);

    $log = mysqli_insert_id($con);

    // ✅ Insert into signup table
    $sql = "INSERT INTO signup(name, email, phone, address, login_id)
            VALUES('$name','$email','$phone','$address','$log')";
    mysqli_query($con, $sql);

    echo "<script>alert('Registration successful');window.location='login.php'</script>";
}
?>
