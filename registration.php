<?php

$con = mysqli_connect('localhost','root','','tk20');
function e($val)
{
    global $con;
    return mysqli_real_escape_string($con, trim($val));
}

function getID() {
    global $con;
    $sql = "SELECT (id+1) as fid FROM eve_reg ORDER BY id DESC LIMIT 1;";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $fid = $row["fid"];
    return (string)$fid.".";
}

if (isset($_POST['submit'])) {

    $files = $_FILES['r_screenshot'];

    $r_salutation = $_POST['r_salutation'];

    $r_name = $_POST['r_name'];
    $r_name = e($r_name);

    $r_email = $_POST['r_email'];
    $r_email = e($r_email);

    $r_phone = $_POST['r_phone'];
    $r_phone = e($r_phone);

    $r_college = $_POST['r_college'];
    $r_college = e($r_college);
    $r_college = strtoupper($r_college);

    $r_year = $_POST['r_year'];
    $r_year = (int) $r_year;

    $r_city = $_POST['r_city'];
    $r_city = e($r_city);

    $r_state = $_POST['r_state'];
    $r_state = e($r_state);

    $r_event = $_POST['r_event'];
    $r_event = (int) $r_event;

    $files = $_FILES['r_screenshot'];

    $r_trn_id = $_POST['r_trn_id'];
    $r_trn_id = e($r_trn_id);

    //SQL Query : 

    $filename = $files['name'];

    $fileerror = $files['error'];
    $filetmp = $files['tmp_name'];

    $fileext = explode('.', $filename);
    $filecheck = strtolower(end($fileext));

    $fileextstored = array('png', 'jpg', 'jpeg');

    if (in_array($filecheck, $fileextstored)) {

        //$destinationfile = 'upload/' . $filename;

        $destinationfile = 'upload/'.$r_email.'_e_'.(string)($r_event). $filecheck;
        move_uploaded_file($filetmp, $destinationfile);
        $insertQuery = "INSERT INTO eve_reg (r_salutation,r_name,r_email,r_phone,r_college,r_year,r_city,r_state,r_event,r_screenshot,r_trn_id) VALUES ('$r_salutation','$r_name','$r_email','$r_phone','$r_college','$r_year','$r_city','$r_state','$r_event','$destinationfile','$r_trn_id')";
        $query = mysqli_query($con, $insertQuery);
        if ($query) {
            echo "<script>alert('Form has been submitted!'); window.location.href = 'nav.html';</script>";
        }
    } else {
        echo "<script>alert('Select an Image File!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="css/registration.css">

</head>

<body>
    <!-- partial:index.partial.html -->
    <!-- multistep form -->
    <h1 class="logo">Technosummit</h1>
    <h1 class="logo">Registration</h1>

    <div class="account">
        <h2 class="fs-title">Account Details for Payment</h2>
        <table style="border: black 1px solid;">
            <tr style="border: black 1px solid; padding:5px;">
                <th style="border-right: black 1px solid;  padding:5px;">Name</th>
                <td style="padding:5px;">DEAN STUDENT - SATHYABAMA</td>
            </tr>
            <tr style="border: black 1px solid; padding:5px;">
                <th style="border-right: black 1px solid;  padding:5px;">Account Number</th>
                <td style="padding:5px;">6624554163</td>
            </tr>
            <tr style="border: black 1px solid; padding:5px;">
                <th style="border-right: black 1px solid;  padding:5px;"> IFSC Code </th>
                <td style="padding:5px;"> IDIB000S201 </td>
            </tr>
            <tr style="border: black 1px solid; padding:5px;">
                <th style="border-right: black 1px solid;  padding:5px;"> Branch </th>
                <td style="padding:5px;"> Sathyabama University </td>
            </tr>
            <tr style="border: black 1px solid; padding:5px;">
                <th style="border-right: black 1px solid;  padding:5px;"> Branch Code </th>
                <td style="padding:5px;"> 02189 </td>
            </tr>
        </table>
    </div>

    <br><br>
    <center><a href="about.html" class="home">Events</a></center>

    <form id="msform" method="post" enctype="multipart/form-data" action="registration.php">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="active">Contact Info</li>
            <li>College Details</li>
            <li>Location Details</li>
            <li>Payment Details</li>
        </ul>

        <!-- fieldsets -->
        <fieldset>
            <h2 class="fs-title">Contact Info</h2>
            <h3 class="fs-subtitle">This is to send certifcates. All the fields are required.</h3>
            <select name="r_salutation" required>
                <option>Select Title </option>
                <option value="1"> Mr. </option>
                <option value="2">Ms. </option>
            </select>
            <input type="text" name="r_name" placeholder="Name" required onkeypress="return allowOnlyAlphabets(event)" />
            <input type="email" name="r_email" placeholder="Email Address" required />
            <input type="text" name="r_phone" placeholder="Phone Number" minlength="10" maxlength="10" required onkeypress="return restrictAlphabets(event)" />
            <input type="button" name="next" class="next action-button" value="Next" />

        </fieldset>

        <fieldset>
            <h2 class="fs-title">College Details</h2><br>
            <input type="text" name="r_college" placeholder="College" required onkeypress="return allowAlphabets(event)" />
            <select name="r_year" required>
                <option>Select Year </option>
                <option value="1">First Year </option>
                <option value="2">Second Year</option>
                <option value="3">Third Year</option>
                <option value="4">Fourth Year</option>
            </select>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>

        <fieldset>
            <h2 class="fs-title">Location Details</h2><br>
            <input type="text" name="r_city" placeholder="City" required onkeypress="return allowOnlyAlphabets(event)" />
            <input type="text" name="r_state" placeholder="State" required onkeypress="return allowOnlyAlphabets(event)"/>
            <select name="r_event" required>
                <option>Select Event</option>
                <option value="1">ROBOKART</option>
                <option value="2">BLIND CODING</option>
                <option value="3">Math-Mania</option>
                <option value="4">Eco-Topia</option>
                <option value="5">CIRCUITRONICS</option>
                <option value="6">SCIENTIA</option>
                <option value="7">Code-Vita</option>
                <option value="8">CONCEPT</option>
                <option value="9">SEED YOUR STARTUP</option>
                <option value="10">COVID-A-THON</option>
                <option value="11">D & D</option>
                <option value="12">SKETCH</option>
                <option value="13">WEB WORLD</option>
                <option value="14">COMIC CRUSADERS</option>
                <option value="15">TECHIE DEB</option>
                <option value="16">EX-QUIZ ME</option>
                <option value="17">5 MT</option>
                <option value="18">FILMINA</option>
                <option value="19">AERO ZONE</option>
                <option value="20">AI WORKSHOP</option>
                <option value="21">DA VINCI CODE</option>
            </select>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>

        <fieldset>
            <h2 class="fs-title">Payment Details</h2>
            <h3 class="fs-subtitle">Attach the Screenshot of the Payment and Enter the Transaction ID</h3>
            <input type="file" name="r_screenshot" placeholder="Attach payment Screenshot" required />
            <input type="text" id="r_trn_id" name="r_trn_id" placeholder="Transaction ID" required oninput="checkAvailability()"/><br>
            <span id="check-availability-status" style="font-size:12px;"></span><br>
            <input type="button" name="previous" class="previous action-button" value="Previous" />
            <input type="submit" id="submit" name="submit" class="submit action-button" value="Submit" />
        </fieldset>

    </form>

    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
    <script src="js/registration.js"></script>

</body>

</html>