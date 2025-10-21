<!--
    - At least 2 position descriptions using semantic HTML.
    - Must include: reference number (5 alphanumeric), title, short description, 
      salary, reporting line, key responsibilities, essential & preferable 
      requirements.
    - Use headings of at least 2 levels, multiple <section>, one <aside>, 
      one ordered list, one unordered list.
    - Content should be concise, realistic, and tailored to the chosen industry.

    - <aside> styled at 25% width, floated right, with border, margin, padding.
-->

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">

        <!-- Responsive Web Design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- HTML Page Description for SEO -->
        <meta name="description" content="">

        <!-- Keywords for SEO -->
        <meta name="keywords" content="">

        <!-- Author Information -->
        <meta name="author" content="Jonah, James, Kia and Duc">

        <!-- Link to external CSS File -->
        <link rel="stylesheet" href="styles/stylessheet.css">

        <!-- Title of Web Page-->
        <title>MELONBALL | Jobs Availability</title>

        <style>
          .job_desc {color: rgb(56, 56, 56);}  
          aside {color: white;}
        </style>
    </head>
    <body>
        <!-- php Header with navigation menu-->
        <?php include 'header.inc'; ?>
        <main>
          <!-- main site area -->
          <section class="jobs_container">
            
            <?php 
              error_reporting(E_ALL); //For debug
              ini_set('display_error', 1); //For debug
             
              // require_once("setting.php")
              require_once('settings.php');
              // Create connection  
              
              $conn = mysqli_connect($host, $user, $pwd, $sql_db);
              if (!$conn) {
                  die("Connection failed: " . mysqli_connect_error());
                }

            ?>

          <!-- Aside -->
            <aside> <!-- Ai generated aside details -->
              <h2>Gaming for Everyone</h2>
              <p>At MelonBall, we believe gaming is for everyone. 
                It's a place to connect, create, and find joy, no matter who you are or where you come from. 
                We&apos;re committed to building a community and creating games where every player feels seen, heard, and valued.
              </p>
              <p>Our goal is simple: to make a home for every kind of gamer. 
                We actively listen to our community, celebrate diversity, and work to ensure our games are approachable and welcoming to everyone. 
                We want you to feel included from the moment you join us.
              </p>
            </aside> <!--  All titles and descriptions are AI generated -->
          <!-- Aside -->

            <section class="jobs_selection"> <!-- this area contains the job description and listing -->
              
              <?php 
                
                // Define the SQL Query
                $sql_query = 
                  "SELECT 
                    title, 
                    reference_code, 
                    location,
                    time_commitment, 
                    salary_range, 
                    short_description, 
                    about_the_role, 
                    requirements, 
                    responsibilities,
                    reporting_line
                  FROM job_listings";

                // Execute the query
                $result = mysqli_query($conn, $sql_query);
                
                // I still don't fully understand this part but this is what Atie and every tutorial I saw on the internet do when they want to run a while loop
                if ($result && mysqli_num_rows($result) > 0) {
                    // Start the Loop: Iterate over every row returned from the database
                    while ($job = mysqli_fetch_assoc($result)) {
                        // Decode mySQL TEXT list into PHP arrays <- For this to work the entry field need to be written as ["a","b","c","etc.."]
                        $requirements = json_decode($job['requirements'], true);
                        $responsibilities = json_decode($job['responsibilities'], true);
                        
                        ?> <!-- stop php and start html -->
                        <a class="apply_link" href="apply.php">
                            <section class="jobs">

                                <h1 class="job_title" style="color: rgb(201, 38, 74)">
                                  <strong><?php echo htmlspecialchars($job['title']); ?></strong>
                                </h1>
                                
                                <div class="job_meta">
                                  <p>Reference: <?php echo htmlspecialchars($job['reference_code']); ?></p>
                                  <p>Location: <?php echo htmlspecialchars($job['location']); ?></p>
                                  <p>Time: <?php echo htmlspecialchars($job['time_commitment']); ?></p>
                                  <p>Salary: <?php echo htmlspecialchars($job['salary_range']); ?></p>
                                </div>

                                <div class="job_desc">
                                  <p><?php echo htmlspecialchars($job['short_description']); ?></p>
                                </div>

                                <section class="job_info">
                                  
                                    <p>About the role: <br> <?php echo nl2br(htmlspecialchars($job['about_the_role'])); ?></p> <!-- nl2br means new line to break or same as <br> in html -->
                                    
                                    <p><strong>Preferable Requirements:</strong></p>
                                    <ol>
                                      <?php 
                                      // Loop through all the array within the TEXT type mySQL automagically
                                      if (is_array($requirements)){ // this part check if the TEXT type of mySQL is an array or not, not needed but good practice to avoid errors
                                          foreach ($requirements as $req){ // this basically reads for each requirment in requirments execute below
                                            ?>
                                                <li><?php echo htmlspecialchars($req); ?></li>
                                            <?php 
                                                } 
                                              } 
                                            ?>
                                    </ol>

                                    <p><strong>Key Responsibilities:</strong></p>
                                    <ol>
                                      <?php 
                                      // Same as above but for the responsibility sections
                                      if (is_array($responsibilities)){ 
                                          foreach ($responsibilities as $resp){ 
                                            ?>
                                                <li><?php echo htmlspecialchars($resp); ?></li>
                                            <?php 
                                                } 
                                              } 
                                            ?>
                                    </ol>

                                    <p><strong>Reporting Line:</strong></p>
                                    <p><?php echo nl2br(htmlspecialchars($job['reporting_line'])); ?></p>

                                </section>
                            </section>
                        </a>
                        <?php //start the php again
                    } // End of the while loop
                } else {
                    // Message if no jobs are found <- this is a fail safe just incase the entry is empty
                    echo "<p>No job listings are currently available.</p>";
                }
                // Close the database connection <- idk too but ChatGPT said this is a good practice to do if other pages won't use this database
                mysqli_close($conn); 

              ?>

            </section>

          </section>
          <!-- End of main site area -->
        </main>
        <!-- php Footer with links to Discord, Jira and email-->
        <?php include 'footer.inc'; ?>
    </body>
</html>