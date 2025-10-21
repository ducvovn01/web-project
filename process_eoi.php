
<!DOCTYPE html>
<html lang="en">
    <body>
        <?php 
            require_once('settings.php');


            function leaveprocess(){
                header("Location: apply.php");
                exit();
            }

            if (!isset($_POST['referenceNumber'])) {
                leaveprocess();
            } 
            function validate($value, $type, $arg, $regex) {
                // validate("Jonah", "VARCHAR", 40, "[a-zA-Z]{1,20}")
                // VALIDATION
                $value = trim($value);
                $value = stripslashes($value);
                $value = htmlspecialchars($value);
                // TYPE (int, varchar, phonenum)

                if ($type == "VARCHAR" || $type == "INT" && $arg != 0){
                    $length = strlen($value);

                    if ($length > $arg) { 
                        echo $value . "Is larger than needed";
                        return -1; 
                        //leaveprocess(); 
                    }
                } else if ($type == "PHONENUM") {
                    $length = strlen($value);
                    if ($length > 12 && $length < 8) { 
                        echo $value . "Is too long";
                        return -1; 
                        //leaveprocess(); 
                    }
                } // else { $correctValues = true; } // TEXT

                // REGEX
                if (preg_match($regex, $value) == false && $regex != "") { 
                    echo "<p>" . $value . "does not have regex for" . $regex . "</p>";
                    return -1; 
                    //leaveprocess(); 
                }

                // NULL CHECK
                if ($value == "" && $type != "TEXT") { 
                    echo "Null Value";
                    return -1; 
                    //leaveprocess();
                }
                
                return $value;
            }

            function sqlquery($host, $user, $pwd, $sql_db, $query) {

                $conn = mysqli_connect($host, $user, $pwd, $sql_db);

                if (!$conn){
                    echo "<p> Could not connect to the database</p>";
                }
                $result = mysqli_query($conn, $query);

                if ($result) {
                    echo "<p>Something went right</p>";
                } else {
                    echo "<p>Something went wrong</p>";
                }

                mysqli_close($conn);
            }

            $query = "CREATE TABLE IF NOT EXISTS `eoi` (`eoi_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, `job_reference_number` varchar(5) NOT NULL, `first_name` varchar(20) NOT NULL, `last_name` varchar(20) NOT NULL, `dob` date NOT NULL, `gender` varchar(6) NOT NULL COMMENT 'MALE / FEMALE', `address` varchar(40) NOT NULL, `suburb` varchar(40) NOT NULL, `state` varchar(3) NOT NULL, `postcode` int(4) NOT NULL, `email` text NOT NULL, `phone_number` varchar(12) NOT NULL COMMENT 'Min 8, Max 12', `skill_list` text NOT NULL COMMENT 'checkbox inputs', `other_skills` text NOT NULL, `status` varchar(7) NOT NULL COMMENT 'new / current / final') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
            sqlquery($host, $user, $pwd, $sql_db, $query);

            $job_ref_num = $_POST['referenceNumber'];
            $first_name = $_POST['firstName'];
            $last_name = $_POST['lastName'];
            $gender = $_POST['gender'];
            $address = $_POST['address'];
            $suburb = $_POST['suburb'];
            $state = $_POST['state'];
            $postcode = $_POST['postcode'];
            $email = $_POST['email'];
            $phone_num = $_POST['number'];
            $skills = $_POST['skills'];

            $jsonData = json_encode($skills);

            $other_skill = $_POST['otherskills'];

            $job_ref_num = validate($job_ref_num, "VARCHAR", 5, "/[A-Za-z0-9]{5}/");
            $first_name = validate($first_name, "VARCHAR", 20, "/[A-Za-z]{1,20}/");
            $last_name = validate($last_name, "VARCHAR", 20, "/[A-Za-z]{1,20}/");
            $address = validate($address, "VARCHAR", 40, "/.{1,40}/");
            $suburb = validate($suburb, "VARCHAR", 40, "/.{1,40}/");
            $postcode = validate($postcode, "INT", 4, "/[0-9]{4}/");
            $email = validate($email, "TEXT", -1, "");
            $phone_num = validate($phone_num, "PHONENUM", -1, "/[0-9]{8,12}/");
            $other_skill = validate($other_skill, "TEXT", -1, "");

            $query = "INSERT INTO eoi (job_reference_number, first_name, last_name, dob, gender, address, suburb, state, postcode, email, phone_number, skill_list, other_skills, status) VALUES ('" . $job_ref_num . "', '". $first_name . "', '". $last_name . "', '1970-1-1', '". $gender . "', '". $address . "', '". $suburb . "', '". $state . "', '". $postcode . "', '". $email . "', '". $phone_num . "', '". $jsonData . "', '". $other_skill . "', 'New');";
            sqlquery($host, $user, $pwd, $sql_db, $query);
        ?>
    </body>
</html>