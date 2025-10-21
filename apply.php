<!--
Job application form with HTML5 validation and POST to formtest.php

- Use Flexbox/Grid for form layout, styled inputs/labels/button.
A Requirement given by the industry guest lecturer.
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
        <title>MelonBall - Apply</title>

        <!-- HTML in CSS Example-->
        <style>
          #otherskillslabel {margin-top: 15px;}
          #otherskills {margin-top: 15px;}
        </style>
    </head>
    <body>
        <!-- php Header with navigation menu-->
        <?php include 'header.inc'; ?>
        <main>
          <!-- Main form -->
            <div class="background-red">
                <h1 id="applicationTitle">Application form</h1>
                <!-- POST form to "formtest.php"-->
                <form action="process_eoi.php" method="post">

                  <!-- Job Reference Number (Exactly 5 Alphanumeric Characters) -->
                  <label for="referenceNumber">Job Reference Number: </label>
                  <input type="text" id="referenceNumber" name="referenceNumber" class="align_right" required>

                  <div class="flex-break"></div>

                  <!-- First Name (Max 20 Alphanumeric Characters) -->
                  <label for="firstName">First Name: </label>
                  <input type="text" id="firstName" name="firstName" class="align_right" required>

                  <div class="flex-break"></div>

                  <!-- Last Name (Max 20 Alphanumeric Characters) -->
                  <label for="lastName">Last Name: </label>
                  <input type="text" id="lastName" name="lastName" class="align_right" required>

                  <div class="flex-break"></div>

                  <!-- Gender (Radio Buttons + Fieldset and Legend) -->
                  <fieldset>
                    <legend>Gender</legend>
                    <label for="male"><input type="radio" value="Male" id="male" name="gender">Male</label>
                    <label for="female"><input type="radio" value="Female" id="female" name="gender">Female</label>
                    <label for="other"><input type="radio" value="Other" id="other" name="gender">Other</label>
                  </fieldset>

                  <div class="flex-break"></div>

                  <!-- Street Address (Max 40 Characters)-->
                  <label for="address">Address: </label>
                  <input type="text" id="address" name="address" class="align_right" required>
                  
                  <div class="flex-break"></div>

                  <!-- Suburb/Town (Max 40 Characters)-->
                  <label for="suburb">Suburb: </label>
                  <input type="text" id="suburb" name="suburb" class="align_right" required>

                  <div class="flex-break"></div>

                  <!-- State (DROPDOWN: VIC,NSW,QLD,NT,WA,SA,TAS,ACT) -->
                  <label for="state" id="statelabel">State: </label>
                  <select id="state" name="state" class="align_right">
                    <option value="empty">Please Select a State</option>
                    <option value="VIC">VIC</option>
                    <option value="NSW">NSW</option>
                    <option value="QLD">QLD</option>
                    <option value="NT">NT</option>
                    <option value="WA">WA</option>
                    <option value="SA">SA</option>
                    <option value="TAS">TAS</option>
                    <option value="ACT">ACT</option>
                  </select>

                  <div class="flex-break"></div>

                  <!-- Postcode (Exactly 4 digits)-->
                  <label for="postcode">Postcode: </label>
                  <input type="text" maxlength="4" minlength="4" id="postcode" name="postcode" class="align_right" required>

                  <div class="flex-break"></div>

                  <!-- Email (valid format) -->
                  <label for="email">Email: </label>
                  <input type="email" id="email" name="email" class="align_right" required>

                  <div class="flex-break"></div>

                  <!-- Phone Number (8-12 Digits) -->
                  <label for="number">Phone Number: </label>
                  <input type="text" id="number" name="number" class="align_right" required>

                  <div class="flex-break"></div>

                  <!-- Skill List (Checkbox inputs) + inline CSS Example-->
                  <fieldset>
                  <legend style="margin-top: 15px;">Skill List:</legend>
                  <div class="aligncheckboxright">
                    <label><input type="checkbox" value="teamwork" id="teamwork" name="skills[]">Teamworking Skills</label>
                    <label><input type="checkbox" value="experience" id="experience" name="skills[]">Experience</label>
                  </div>

                  <div class="flex-break"></div>

                  <div class="aligncheckboxright2">
                    <label><input type="checkbox" value="ux" id="ux" name="skills[]">User Expererience</label>
                    <label><input type="checkbox" value="others" id="others" name="skills[]">Other Skills</label>
                  </div>
                  </fieldset>
                  <div class="flex-break"></div>

                  <label for="otherskills" id="otherskillslabel">Other Skills: </label>
                  <textarea id="otherskills" cols="50" rows="4" name="otherskills"></textarea>
                  
                  <div class="flex-break"></div>
                  
                  <button id="submitButton">Submit</button>
                </form>
            </div>
        </main>
        <!-- php Footer with links to Discord, Jira and email-->
        <?php include 'footer.inc'; ?>
    </body>
</html>