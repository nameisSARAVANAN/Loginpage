<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['name']) && isset($_POST['phone']) &&
        isset($_POST['dob']) && isset($_POST['username']) &&
        isset($_POST['password'])) {
        
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "test";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(name, phone, dob, username, password) values(?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssii",$name, $phone, $dob, $username, $password);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>