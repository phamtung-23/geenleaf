<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve information from the form
    $fullname = strtoupper($_POST['full_name']); 
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['re_pass'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $idtele = $_POST['idtele'];
    $province = $_POST['province'];

    // Check password confirmation
    if ($password === $confirm_password) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Read the users.json file
        $file = 'database/users.json';
        if (file_exists($file)) {
            $users = json_decode(file_get_contents($file), true);
        } else {
            $users = [];
        }

        // Check if the email already exists
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                echo "<script>
                    alert('Email already exists!');
                    window.location.href = 'index.php';
                </script>";
                exit();
            }
        }

        // Add the new user to the array
        $newUser = [
            'fullname' => $fullname,
            'email' => $email,
            'password' => $hashed_password,
            'phone' => $phone,
            'idtele' => $idtele,
            'role' => $role
        ];
        $users[] = $newUser;

        // Write back to the JSON file with support for Unicode characters
        file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo "<script>
            alert('Account created successfully!');
            window.location.href = 'index.php';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Password confirmation does not match!');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
}
?>
