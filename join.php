<?php
include "top.php";

//%^%^%^%^%^%^%^%^%^SECTION 1 - VARIABLES^%^%^%^%^%^%^%^%^%//
//Security Variable
$thisURL = $domain . $phpSelf;

//Form Variables
$name = "";
$age = "";
$gender = ""; //RADIO BTN
$email = "";
$phone = "";
$address = "";
$city = "";
$state = ""; //LIST BOX
$zip = "";
$firstPeak = ""; //LIST BOX
$lastPeak = ""; //LIST BOX
$comments = "";
//Error Variables
$nameERROR = false;
$ageERROR = false;
$genderERROR = false;
$emailERROR = false;
$phoneERROR = false;
$addressERROR = false;
$cityERROR = false;
$stateERROR = false;
$zipERROR = false;
$firstPeakERROR = false;
$lastPeakERROR = false;
$commentsERROR = false;

//Misc Variable
$errorMsg = array();
$dataRecord = array();
$mailed = false;

//%^%^%^%^%^%^%^%^%^SECTION 2 - SUBMITTED FORM PROCESS^%^%^%^%^%^%^%^%^%//
if (isset($_POST['btnSubmit'])) {
    //Security Check
    if (!securityCheck($thisURL)) {
        $msg = "<p>Sorry you cannot access this page</p>";
        $msg .= "<p>Security breach detected and reported</p>";
        die($msg);
    }

    //Sanitize Data
    $name = htmlentities($_POST["txtName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $name;

    $age = htmlentities($_POST["txtAge"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $age;

    $gender = htmlentities($_POST["radGender"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $gender;

    $email = filter_var($_POST["txtEmail"], FILTER_SANITIZE_EMAIL);
    $dataRecord[] = $email;

    $phone = htmlentities($_POST["txtPhoneNumber"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $phone;

    $address = htmlentities($_POST["txtAddress"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $address;

    $city = htmlentities($_POST["txtCity"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $city;

    $state = htmlentities($_POST["lstState"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $state;

    $zip = htmlentities($_POST["txtZipCode"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $zip;

    $firstPeak = htmlentities($_POST["txtFirstPeak"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $firstPeak;

    $lastPeak = htmlentities($_POST["txtLastPeak"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $lastPeak;
    $comments = htmlentities($_POST["txtComments"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $comments;
    //Form Validation

    if ($name == "") {
        $errorMsg[] = "Please enter your name";
        $nameERROR = true;
    }
    if ($age == "") {
        $errorMsg[] = "Please enter your age";
        $ageERROR = true;
    }
    if ($gender != "Male" AND $gender != "Female" AND $gender != "Non-binary") {
        $errorMsg[] = "Please select your gender";
        $genderERROR = true;
    }
    if ($email == "") {
        $errorMsg[] = "Please enter your email address";
        $emailERROR = true;
    } elseif (!verifyEmail($email)) {
        $errorMsg[] = "Your email address appears to be incorrect";
        $emailERROR = true;
    }
    if ($phone == "") {
        $errorMsg[] = "Please enter your phone number";
        $phoneERROR = true;
    } elseif (!verifyPhone($phone)) {
        $errorMsg[] = "Your phone number appears to be incorrect";
        $phoneERROR = true;
    }
    if ($address == "") {
        $errorMsg[] = "Please enter your address";
        $addressERROR = true;
    }
    if ($city == "") {
        $errorMsg[] = "Please enter your city";
        $cityERROR = true;
    }
    if ($state == "") {
        $errorMsg[] = "Please choose your state";
        $stateERROR = true;
    }
    if ($zip == "") {
        $errorMsg[] = "Please enter your zip code";
        $zipERROR = true;
    } elseif (!verifyNumeric($zip)) {
        $errorMsg[] = "Please enter a valid zip code";
        $zipERROR = true;
    }
    if ($firstPeak == "") {
        $errorMsg[] = "Please enter the peak you hiked first";
        $firstPeakERROR = true;
    }
    if ($lastPeak == "") {
        $errorMsg[] = "Please enter the peak you hiked last";
        $lastPeakERROR = true;
    }
    if($comments == "") {
        $errorMsg[] = "Please answer the prompt";
        $commentsERROR = true;
    }


    //Process Valid Form
    if (!$errorMsg) {

        //Save Data
        $fileExt = ".csv";
        $myFileName = "data/registration";
        $fileName = $myFileName . $fileExt;
        $file = fopen($fileName, "a");
        fputcsv($file, $dataRecord);
        fclose($file);

        //Create Mail Message
        $message = "<h3>Your Information:</p>";

        foreach ($_POST as $Htmlname => $value) {
            if ($Htmlname != "btnSubmit") {
                $message .= "<p>";

                $camelCase = preg_split("/(?=[A-Z])/", substr($Htmlname, 3));
                foreach ($camelCase as $one) {
                    $message .= $one . " ";
                }
                $message .= " = " . htmlentities($value, ENT_QUOTES, "UTF-8") . "</p>";
            }
        }

        //Send Mail
        $to = $email;
        $cc = "";
        $bcc = "eric.langdon@uvm.edu";
        $from = "<noreply@adk46er.com>";
        $subject = "Thank you for Registering!";

        $mailed = sendMail($to, $cc, $bcc, $from, $subject, $message);
    }//Ends if form is valid
}//Ends if form is submitted
?>
<article id = "join">
<?php
//%^%^%^%^%^%^%^%^%^SECTION 3 - Display Form^%^%^%^%^%^%^%^%^%//
//Form Feedback
if (isset($_POST["btnSubmit"]) AND empty($errorMsg)) {
    print "<div id='feedback'>";
    print ("<h2>Thank you for providing your information.</h2>");
    print ("<h3>A copy has ");
    if (!$mailed) {
        print ("not ");
    }
    print ("been sent to: " . $email . "</h3>");
    print $message;
    print "</div>";
} else {
    //Error Messages
    if ($errorMsg) {
        print ("<div id = 'errors'>" . "\n");
        print ("<h2>Your form has the following errors that need to be fixed.</h2>\n");
        print ("<ol>\n");

        foreach ($errorMsg as $err) {
            print ("<li>" . $err . "</li>\n");
        }

        print ("</ol>\n");
        print ("</div>\n");
    }

    //HTML Form
    ?>
        <form action = "<?php print ($phpSelf); ?>"
              id = "frmRegister"
              method = "post">
            <h1>Join the ADK 46ers!</h1>
            
            <fieldset class = "contact">
                <legend>Contact Information</legend>

                <label class = "required" for = "txtName">Name
                    <input
    <?php if ($nameERROR) print ("class = 'mistake'"); ?>
                        id = "txtName"
                        maxlength= "45"
                        name = "txtName"
                        onfocus= "this.select()"
                        placeholder= ""
                        tabindex= "10"
                        type = "text"
                        value = "<?php print $name; ?>"
                        >
                </label>

                <label class = "required" for = "txtAge">Age
                    <input
    <?php if ($ageERROR) print ("class = 'mistake'"); ?>
                        id = "txtAge"
                        maxlength= "4"
                        name = "txtAge"
                        onfocus= "this.select()"
                        placeholder= ""
                        tabindex= "20"
                        type = "text"
                        value = "<?php print $age; ?>"
                        >
                </label>

                <fieldset class="radio <?php if($genderERROR) print ' mistake'; ?>">
                    <legend>Gender</legend>
                    <label class="radio-field">
                        Male<input type="radio"
                               id="radGenderMale"
                               name="radGender"
                               value="Male"
                               tabindex="25"
                               <?php if ($gender == "Male") echo ' checked="checked" '; ?>>
                    </label>
                    <label class="radio-field">
                        Female<input type="radio"
                               id="radGenderFemale"
                               name="radGender"
                               value="Female"
                               tabindex="25"
                               <?php if ($gender == "Female") echo ' checked="checked" '; ?>>
                    </label>
                    <label class="radio-field">
                        Non-Binary<input type="radio"
                               id="radGenderNon-Binary"
                               name="radGender"
                               value="Non-Binary"
                               tabindex="25"
                               <?php if ($gender == "Non-Binary") echo ' checked="checked" '; ?>>
                    </label>
                </fieldset>

                <label class = "required" for = "txtEmail">Email
                    <input
    <?php if ($emailERROR) print ("class = 'mistake'"); ?>
                        id = "txtEmail"
                        maxlength= "45"
                        name= "txtEmail"
                        onfocus= "this.select()"
                        placeholder= ""
                        tabindex= "40"
                        type= "text"
                        value = "<?php print $email; ?>"
                        >
                </label>

                <label class= "required" for="txtPhoneNumber">Phone Number
                    <input
    <?php if ($phoneERROR) print ("class = 'mistake'"); ?>
                        id = "txtPhoneNumber"
                        maxlength= "45"
                        name = "txtPhoneNumber"
                        onfocus= "this.select()"
                        placeholder= ""
                        tabindex= "50"
                        type = "text"
                        value = "<?php print $phone; ?>"
                        >
                </label>

                <label class= "required" for="txtAddress">Address
                    <input
    <?php if ($addressERROR) print ("class = 'mistake'"); ?>
                        id = "txtAddress"
                        maxlength= "60"
                        name = "txtAddress"
                        onfocus= "this.select()"
                        placeholder= ""
                        tabindex= "60"
                        type = "text"
                        value = "<?php print $address; ?>"
                        >
                </label>

                <label class= "required" for="txtCity">City
                    <input
    <?php if ($cityERROR) print ("class = 'mistake'"); ?>
                        id = "txtCity"
                        maxlength= "30"
                        name = "txtCity"
                        onfocus= "this.select()"
                        placeholder= ""
                        tabindex= "70"
                        type = "text"
                        value = "<?php print $city; ?>"
                        >
                </label>

                <label class= "required" for="lstState">State
                    <select
                        id="lstState"
                        name="lstState"
                        tabindex="80">
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>	
                </label>

                <label class= "required" for="txtZipCode">Zip Code
                    <input
    <?php if ($phoneERROR) print ("class = 'mistake'"); ?>
                        id = "txtZipCode"
                        maxlength= "45"
                        name = "txtZipCode"
                        onfocus= "this.select()"
                        placeholder= ""
                        tabindex= "90"
                        type = "text"
                        value = "<?php print $zip; ?>"
                        >
                </label>

            </fieldset>
            <fieldset class="hiking">
                <legend>Hiking Information</legend>

                <label class= "required" for="txtFirstPeak">First Peak Climbed
                    <input
    <?php if ($firstPeakERROR) print ("class = 'mistake'"); ?>
                        id = "txtFirstPeak"
                        maxlength= "45"
                        name = "txtFirstPeak"
                        onfocus= "this.select()"
                        placeholder= ""
                        tabindex= "100"
                        type = "text"
                        value = "<?php print $firstPeak; ?>"
                        >
                </label>

                <label class= "required" for="txtLastPeak">Last Peak Climbed
                    <input
    <?php if ($lastPeakERROR) print ("class = 'mistake'"); ?>
                        id = "txtLastPeak"
                        maxlength= "45"
                        name = "txtLastPeak"
                        onfocus= "this.select()"
                        placeholder= ""
                        tabindex= "110"
                        type = "text"
                        value = "<?php print $lastPeak; ?>"
                        >
                </label>
                <div class="comments"><label class="required comments" for="txtComments">How did you come to climb the 46? What was your favorite peak and why? Please share any of your favorite/least favorite memories or moments while climbing the 46 high peaks.</label>
                <textarea <?php if ($commentsERROR) print 'class="mistake"'; ?>
                    id="txtComments"
                    name="txtComments"
                    onfocus="this.select()"
                    tabindex="120"><?php print $comments; ?></textarea></div>
            </fieldset>
            <fieldset class = "buttons">
                <input class = "button"
                       id = "btnSubmit"
                       name = "btnSubmit"
                       tabindex = "900"
                       type = "submit"
                       value = "Submit"
                       >
            </fieldset>
        </form>
<?php } ?>
</article>
    <?php include "footer.php"; ?>
