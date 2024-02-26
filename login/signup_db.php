    <?php
    session_start();
    require_once '../config/db.php';

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $urole = 'user';

    if (hasWhitespace($firstname) || hasWhitespace($lastname) || hasWhitespace($email) || hasWhitespace($username) || hasWhitespace($password) || hasWhitespace($c_password)) {
        echo json_encode(array("status" => "error", "msg" => "Please remove spaces from the input fields"));
    } else if (!$firstname) {
        echo json_encode(array("status" => "error", "msg" => "Please enter your firstname"));
    } else if (!$lastname) {
        echo json_encode(array("status" => "error", "msg" => "Please enter your lastname"));
    } else if (!preg_match('/^[a-zA-Z]+$/', $firstname) || !preg_match('/^[a-zA-Z]+$/', $lastname)) {
        echo json_encode(array("status" => "error", "msg" => "Please enter FirstName or LastName with A-Z or a-z only."));
    } else if (!$email) {
        echo json_encode(array("status" => "error", "msg" => "Please enter your E-mail"));
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array("status" => "error", "msg" => "Please enter a valid email address"));
    } else if (!$username) {
        echo json_encode(array("status" => "error", "msg" => "Please enter your username"));
    } else if (!preg_match('/^[a-zA-Z0-9.]+$/', $username)) {
        echo json_encode(array("status" => "error", "msg" => "Please enter Username A-Z, a-z, or 0-9 only."));
    } else if (!$password) {
        echo json_encode(array("status" => "error", "msg" => "Please enter your password"));
    } else if (strlen($_POST['password']) < 8) {
        echo json_encode(array("status" => "error", "msg" => "Please enter a password with more than 8 characters"));
    } else if (!$c_password) {
        echo json_encode(array("status" => "error", "msg" => "Please confirm your password"));
    } else if ($password != $c_password) {
        echo json_encode(array("status" => "error", "msg" => "Passwords don't match"));
    } else {

        $stmt = $conn->prepare('SELECT COUNT(*) FROM table_user WHERE email = ?');
        $stmt->execute([$email]);
        $emailExists = $stmt->fetchColumn();

        $stmt = $conn->prepare('SELECT COUNT(*) FROM table_user WHERE username = ?');
        $stmt->execute([$username]);
        $userExists = $stmt->fetchColumn();

        if ($emailExists) {
            echo json_encode(array("status" => "error", "msg" => "This email is already in use"));
        } elseif ($userExists) {
            echo json_encode(array("status" => "error", "msg" => "This Username is already in use"));
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            try {

                $stmt = $conn->prepare("INSERT INTO table_user(firstname, lastname, email, username, password, role)
                                                    VALUES(?, ?, ?, ?, ?, ?)");
                $stmt->execute([$firstname, $lastname, $email, $username, $passwordHash, $urole]);

                echo json_encode(array("status" => "success", "msg" => "Registration successfully!"));
            } catch (PDOException $e) {
                echo json_encode(array("status" => "error", "msg" => "Something went wrong please try again!"));
            }
        }
    }
    function hasWhiteSpace($input)
    {
        return preg_match('/\s/', $input);
    }

    ?>
