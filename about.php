<!--Team profile page with:
 - Group name, class day/time (nested list)
 - Member contributions + quotes (definition list; first/favourite language + translation)
 - Group photo (<300KB) with <figure> + caption
 - Fun facts table with caption (eg., dream job, coding snack, hometown)

 - Student IDs styled on right side, group photo in <figure> 
   with border, table with bold headers, colours in hex, hover effects.
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
        <title> About </title>
    </head>
    <body>

    <main>
      <!-- php Header with navigation menu-->
      <?php include 'header.inc'; ?> 

      <h1> About </h1>
        <section class = "about-section">
          <h2>Group Information</h2>
          <ul>
            <li>Group Name:  MelonBall
              <ul>
                <li>Class Day: Thursday</li>
                <li>Class Time: 12:30 PM – 2:30 PM</li>
              </ul>
            </li>
          </ul>
        </section>

      <figure class = "photo-box">
          <img class="group-photo" src="images/group_photo.jpeg" width="220"alt="Group Photo">
          <figcaption> Our Group Photo </figcaption>
      </figure>

      <section class = "about-section">
      <?php 
        
        require_once('settings.php');

        // Create connection
        $conn = mysqli_connect($host, $user, $pwd, $sql_db);

        // Check connection
        if (!$conn) {
          echo "<p>Database connection failed: " . mysqli_connect_error() . "</p>";
        }
        else 
        {
          // Query to get friend data
          $sql = "SELECT * FROM about";
          $result = mysqli_query($conn, $sql);
 
          // If there are results, display them
          if ($result && mysqli_num_rows($result) > 0) 
          {

            $lang_html = array("km", "ja", "vi", "it");
            $index = 0;

            while ($row = mysqli_fetch_assoc($result)) {
              $first_name = htmlspecialchars($row['first_name']);
              $last_name = htmlspecialchars($row['last_name']);
              $lang = htmlspecialchars($row['lang']);
              $quote_lang = htmlspecialchars($row['quote_lang']);
              $quote_eng = htmlspecialchars($row['quote_eng']);
              $member_cont_one = htmlspecialchars($row['part_one_cont']);
              $member_cont_two = htmlspecialchars($row['part_two_cont']);

              echo "<h2> $first_name $last_name </h2>";
              echo "<dl>
                      <dt>Member Contributions 1:</dt>
                      <dd>$member_cont_one</dd>
                      <dt>Member Contributions 2:</dt>
                      <dd>$member_cont_two</dd>
                      <dt> Quote </dt>
                      <dd>$lang <span lang='{$lang_html[$index]}'>$quote_lang</span></dd>
                      <dd>English: $quote_eng</dd>
                    </dl>";
              $index += 1;
            }

            echo "<section class = 'about-section'>
                  <table>
                  <thead>
                   <tr>
                     <th> Name </th>
                     <th> Student ID </th>
                     <th> Dream Job </th>
                     <th> Coding Snack </th>
                     <th> Hometown </th>
                   </tr>
                 <tbody>";
            // Used ChatGPT to help me reset the row array
            mysqli_data_seek($result, 0); // Reset result pointer to the beginning

            while ($row = mysqli_fetch_assoc($result)) {
              $id = htmlspecialchars($row['id']);
              $first_name = htmlspecialchars($row['first_name']);
              $last_name = htmlspecialchars($row['last_name']);
              $dream_job = htmlspecialchars($row['dream_job']);
              $snack = htmlspecialchars($row['snack']);
              $hometown = htmlspecialchars($row['hometown']);

              echo "<tr>
                      <td> $first_name $last_name </td>
                      <td class='align_right'> $id </td>
                      <td> $dream_job </td>
                      <td> $snack </td>
                      <td> $hometown </td>
                    </tr>";
            }
            echo "</tbody></table></section>";
          }
          else {
            echo "<p>No member data found.</p>";
          }
        }
      ?>
      </section>
    </main>
    <!-- php Footer with links to Discord, Jira and email-->
    <?php include 'footer.inc'; ?>
    </body>
</html>
