<?php
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];

    if (!empty($firstname) || !empty($lastname) || !empty($email) || !empty($gender)) {
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "form";

        //connection
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if(mysqli_connect_error()){
            die ('Connect Error('.mysqli_connect_errno().')'. mysqli_connect_error());
        } else {
            $SELECT = "SELECT email From registration Where email = ? Limit 1";
            $INSERT = "INSERT INTO registration(firstname, lastname, email, gender) values(?, ?, ?, ?)";

            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;
            
            if ($rnum==0) {
                $stmt->close();

                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ssss", $firstname, $lastname, $email, $gender);
                $stmt->execute();
                echo "New Record inserted successfully";
            } else {
                echo "Some one Already register using this email";
            }
            $stmt->close();
            $conn->close()
        }
    } else {
        echo "All field are required";
        die();
    }
?>