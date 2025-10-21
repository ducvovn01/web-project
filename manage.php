<?php


if (session_status() === PHP_SESSION_NONE) { if (session_status() === PHP_SESSION_NONE) { session_start(); } }
ob_start();

// Optional logout via query: manage.php?action=logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

// If already logged in, continue; else show login form.
if (!empty($_SESSION['username'])) {
    // --- One-request login: force re-login on refresh ---
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');
    header('Expires: 0');
    register_shutdown_function(function () {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            if (ini_get('session.use_cookies')) {
                $p = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
            }
            session_destroy();
        }
    });
} else {
    // Handle login POST
    $login_error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $login_error = 'Please enter both username and password.';
        } else {
            require_once __DIR__ . '/settings.php'; // expects $host, $user, $pwd, $sql_db
            $dbconn = @mysqli_connect($host ?? null, $user ?? null, $pwd ?? null, $sql_db ?? null);
            if (!$dbconn) {
                $login_error = 'Database connection failed: ' . htmlspecialchars(mysqli_connect_error());
            } else {
                $sql = 'SELECT username, password FROM users WHERE username = ? LIMIT 1';
                if ($stmt = mysqli_prepare($dbconn, $sql)) {
                    mysqli_stmt_bind_param($stmt, 's', $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $user = mysqli_fetch_assoc($result);
                    mysqli_free_result($result);
                    mysqli_stmt_close($stmt);

                    $ok = false;
                    if ($user) {
                        $stored = $user['password'];
                        $info = password_get_info($stored);
                        if (!empty($info['algo'])) {
                            $ok = password_verify($password, $stored);
                        } else {
                            $ok = hash_equals($stored, $password);
                        }
                    }

                    if ($ok) {
                        session_regenerate_id(true);
                        $_SESSION['username'] = $username;
                        header('Location: ' . $_SERVER['REQUEST_URI']); // PRG pattern
                        exit;
                    } else {
                        $login_error = 'Invalid username or password.';
                    }
                } else {
                    $login_error = 'Query error: could not prepare statement.';
                }
            }
        }
    }

    // Render login page and exit
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body { font-family: "Segoe UI", "Roboto",
                    "Helvetica Neue", "Arial", "sans-serif",
                    "Apple Color Emoji", "Segoe UI Emoji",
                    "Segoe UI Symbol";
                   margin: 0; 
                   background: white; 
                   color: #333; 
                }
            main { max-width: 480px; margin: 64px auto; padding: 24px; background: crimson; border-radius: 12px; }
            h1 { margin-top: 0; }
            form { display: grid; gap: 12px; }
            label { font-size: 14px; color: #bbb; }
            input[type="text"], input[type="password"] {
                width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #333; background: #111; color: #eee;
            }
            input[type="submit"] {
                padding: 10px 14px; border: 0; border-radius: 8px; cursor: pointer;
            }
            .btn { background: #2e7d32; color: white; }
            .error { background: #4a1c1c; color: #ffb3b3; padding: 10px; border-radius: 8px; margin-bottom: 12px; }
            .hint { font-size: 12px; color: #999; }
            a { color: #9ad; text-decoration: none; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
    <?php include_once 'header.inc'; ?>
    <main>
        <h1>Sign in</h1>
        <?php if (!empty($login_error)): ?>
            <div class="error"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" autofocus>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" class="btn" value="Login">
        </form>

        <p class="hint">
            To test quickly, ensure your <code>users</code> table includes admin/admin (plaintext) or a hashed password.
        </p>
    </main>
    <?php include 'footer.inc'; ?>
    </body>
    </html>
    <?php
    exit;
}
// === End Auth guard ===
?>
<html lang="en">
    <head>

        <meta charset="UTF-8">

        <!-- Responsive Web Design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- HTML Page Description for SEO -->
        <meta name="description" content="Main landing page for MelonBall, a game development company specializing in tropical, relaxing, immersive games.">

        <!-- Keywords for SEO -->
        <meta name="keywords" content="Melonball, tropical, relaxing, immersive, games">

        <!-- Author Information -->
        <meta name="author" content="Jonah, James, Kia and Duc">

        <!-- Link to external CSS File -->
        <link rel="stylesheet" href="styles/stylessheet.css">

        <!-- Title of Web Page-->
        <title>MelonBall - Play Easy. Drift Far.</title>
        <!-- Embedded CSS for right panel text styling -->
        <style>
          .index_rightpanel h2 {
            color: #ffffff;
          }

          .index_rightpanel p {
            color: #ffffff;
            font-weight: lighter;
          }

          .index_rightpanel a {
            color: #ffffff;
            text-decoration: none;
          }

          .index_rightpanel a:hover {
            text-decoration: underline;
            text-decoration-color: rgb(103, 147, 161);
          }
        </style>
    </head>
    <body>
        <!-- php Header with navigation menu-->
        <?php include_once 'header.inc'; ?>

        <main>
            <?php
            if (session_status() === PHP_SESSION_NONE) { session_start(); }
            require_once 'settings.php';

            $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);

            // Check for connection failure
            if (!$dbconn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            
            

            // Handle different actions based on GET/POST parameters
            $action = $_GET['action'] ?? '';
            $job_reference = $_POST['job_reference'] ?? '';
            $first_name = $_POST['first_name'] ?? '';
            $last_name = $_POST['last_name'] ?? '';
            $eoi_status = $_POST['eoi_status'] ?? '';
            $sort_by = $_POST['sort_by'] ?? 'job_reference'; // Default sorting field

            // Function to list all EOIs
            function listAllEOIs($dbconn, $sort_by) {
                $query = "SELECT * FROM EOIs ORDER BY $sort_by";
                return mysqli_query($dbconn, $query);
            }

            // Function to list EOIs by job reference
            function listByJobReference($dbconn, $job_reference) {
                $query = "SELECT * FROM EOIs WHERE job_reference_number LIKE ?";
                $stmt = mysqli_prepare($dbconn, $query);
                mysqli_stmt_bind_param($stmt, 's', $job_reference_number);
                mysqli_stmt_execute($stmt);
                return mysqli_stmt_get_result($stmt);
            }

            // Function to list EOIs by applicant name
            function listByApplicantName($dbconn, $first_name, $last_name) {
                $query = "SELECT * FROM EOIs WHERE applicant_first_name LIKE ? AND applicant_last_name LIKE ?";
                $stmt = mysqli_prepare($dbconn, $query);
                mysqli_stmt_bind_param($stmt, 'ss', $first_name, $last_name);
                mysqli_stmt_execute($stmt);
                return mysqli_stmt_get_result($stmt);
            }

            // Function to delete all EOIs by job reference
            function deleteEOIsByJobReference($dbconn, $job_reference) {
                $query = "DELETE FROM EOIs WHERE job_reference = ?";
                $stmt = mysqli_prepare($dbconn, $query);
                mysqli_stmt_bind_param($stmt, 's', $job_reference);
                return mysqli_stmt_execute($stmt);
            }

            // Function to change EOI status
            function changeEOIStatus($dbconn, $id, $eoi_status) {
                $query = "UPDATE EOIs SET eoi_status = ? WHERE id = ?";
                $stmt = mysqli_prepare($dbconn, $query);
                mysqli_stmt_bind_param($stmt, 'si', $eoi_status, $id);
                return mysqli_stmt_execute($stmt);
            }

            // Handle specific actions
            if ($action == 'list_all') {
                $result = listAllEOIs($dbconn, $sort_by);
            } elseif ($action == 'list_by_job_reference') {
                $result = listByJobReference($dbconn, $job_reference);
            } elseif ($action == 'list_by_name') {
                $result = listByApplicantName($dbconn, $first_name, $last_name);
            } elseif ($action == 'delete_by_job_reference') {
                $delete_success = deleteEOIsByJobReference($dbconn, $job_reference);
            } elseif ($action == 'change_status') {
                $id = $_POST['id'];
                $status = $_POST['status'];
                $status_changed = changeEOIStatus($dbconn, $id, $status);
            }

            // Include header
            include_once 'header.inc';
            ?>

            <main>
                <h2>Manage EOIs</h2>

                <!-- Form to list EOIs by job reference -->
                <form method="POST" action="?action=list_by_job_reference">
                    <label for="job_reference">Job Reference:</label>
                    <input type="text" name="job_reference" required>
                    <input type="submit" value="List EOIs by Job Reference">
                </form>

                <!-- Form to list EOIs by applicant name -->
                <form method="POST" action="?action=list_by_name">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name">
                    <input type="submit" value="List EOIs by Applicant Name">
                </form>

                <!-- Form to delete all EOIs by job reference -->
                <form method="POST" action="?action=delete_by_job_reference">
                    <label for="job_reference">Job Reference:</label>
                    <input type="text" name="job_reference" required>
                    <input type="submit" value="Delete EOIs by Job Reference">
                </form>

                <!-- Form to change the status of an EOI -->
                <form method="POST" action="?action=change_status">
                    <label for="id">EOI ID:</label>
                    <input type="text" name="id" required>
                    <label for="status">Status:</label>
                    <input type="text" name="status" required>
                    <input type="submit" value="Change EOI Status">
                </form>

                <!-- Sort EOIs -->
                <form method="POST" action="?action=list_all">
                    <label for="sort_by">Sort by:</label>
                    <select name="sort_by">
                        <option value="job_reference_number">Job Reference</option>
                        <option value="applicant_first_name">First Name</option>
                        <option value="applicant_last_name">Last Name</option>
                    </select>
                    <input type="submit" value="Sort Results">
                </form>

                <!-- Display EOIs -->
                <table border="1">
                    <tr>
                        <th>ID</th>
                        <th>Job Reference</th>
                        <th>Applicant First Name</th>
                        <th>Applicant Last Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    $sql = "
                    SELECT
                        eoi_id AS id,
                        job_reference_number AS job_reference,
                        first_name AS applicant_first_name,
                        last_name AS applicant_last_name,
                        status AS eoi_status
                    FROM eoi
                    WHERE job_reference_number = ?
                    ORDER BY eoi_id
                    ";
                    $stmt = mysqli_prepare($dbconn, $sql);
                    mysqli_stmt_bind_param($stmt, 's', $jobRef);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt); // requires mysqlnd

                    if ($result === false) {
                        echo "<p style='color:#a00'>Query failed: "
                        . htmlspecialchars(mysqli_error($dbconn))
                        . "</p>";
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['job_reference_number'] . "</td>";
                            echo "<td>" . $row['applicant_first_name'] . "</td>";
                            echo "<td>" . $row['applicant_last_name'] . "</td>";
                            echo "<td>" . $row['eoi_status'] . "</td>";
                            echo "<td><a href='?action=change_status&id=" . $row['id'] . "'>Change Status</a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </main>

            <?php
            // Include footer
            include 'footer.inc';
            ?>

        </main>
    </body>
</html>