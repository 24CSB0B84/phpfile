<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visa Application System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
        }
        .banner {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        select, input, button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        #instantResult, #phpResult {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            display: none;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <?php
    $phpResult = "";
    $resultClass = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = isset($_POST["username"]) ? $_POST["username"] : "";
        $passport = isset($_POST["passport"]) ? $_POST["passport"] : "";
        $country = isset($_POST["country"]) ? $_POST["country"] : "";

        if (empty($username) || empty($passport) || empty($country)) {
            $phpResult = "All fields are required!";
            $resultClass = "error";
        } elseif (strlen($passport) < 8 || strlen($passport) > 10) {
            $phpResult = "Invalid passport number!";
            $resultClass = "error";
        } else {
            switch($country) {
                case "USA":
                    $phpResult = "Visa required for most applicants.";
                    break;
                case "Canada":
                    $phpResult = "Visa required unless you have an eTA.";
                    break;
                case "India":
                    $phpResult = "Visa required before travel.";
                    break;
                case "UK":
                    $phpResult = "Visa depends on the duration of stay.";
                    break;
                case "Australia":
                    $phpResult = "eVisa available for eligible travelers.";
                    break;
                default:
                    $phpResult = "Invalid country selection.";
                    $resultClass = "error";
            }
            if (!$resultClass) {
                $phpResult = "Visa application submitted successfully! " . $phpResult;
                $resultClass = "success";
            }
        }
    }
    ?>

    <!-- Banner Added Here -->
    <div class="banner">
        <h1>Visa Application Portal</h1>
        <p>Welcome! Apply for your visa or check requirements instantly.</p>
    </div>

    <h2>Visa Application System</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" placeholder="Enter your name">
        </div>
        
        <div class="form-group">
            <label>Passport Number:</label>
            <input type="text" name="passport" value="<?php echo isset($_POST['passport']) ? $_POST['passport'] : ''; ?>" placeholder="Passport number (8-10 characters)">
        </div>
        
        <div class="form-group">
            <label>Country:</label>
            <select id="countrySelect" name="country" onchange="checkVisa()">
                <option value="">Select a country</option>
                <option value="USA" <?php echo (isset($_POST['country']) && $_POST['country'] == 'USA') ? 'selected' : ''; ?>>USA</option>
                <option value="Canada" <?php echo (isset($_POST['country']) && $_POST['country'] == 'Canada') ? 'selected' : ''; ?>>Canada</option>
                <option value="India" <?php echo (isset($_POST['country']) && $_POST['country'] == 'India') ? 'selected' : ''; ?>>India</option>
                <option value="UK" <?php echo (isset($_POST['country']) && $_POST['country'] == 'UK') ? 'selected' : ''; ?>>UK</option>
                <option value="Australia" <?php echo (isset($_POST['country']) && $_POST['country'] == 'Australia') ? 'selected' : ''; ?>>Australia</option>
            </select>
        </div>
        
        <button type="button" onclick="checkVisa()">Check Visa</button>
        <button type="submit">Apply for Visa</button>
    </form>

    <div id="instantResult"></div>
    
    <?php if ($phpResult): ?>
    <div id="phpResult" class="<?php echo $resultClass; ?>" style="display: block;">
        <?php echo $phpResult; ?>
    </div>
    <?php endif; ?>

    <script>
        function checkVisa() {
            const country = document.getElementById("countrySelect").value;
            const resultDiv = document.getElementById("instantResult");
            let message = "";

            switch(country) {
                case "USA":
                    message = "Visa required for most applicants.";
                    break;
                case "Canada":
                    message = "Visa required unless you have an eTA.";
                    break;
                case "India":
                    message = "Visa required before travel.";
                    break;
                case "UK":
                    message = "Visa depends on the duration of stay.";
                    break;
                case "Australia":
                    message = "eVisa available for eligible travelers.";
                    break;
                default:
                    message = "Please select a country.";
            }

            resultDiv.textContent = message;
            resultDiv.style.display = "block";
            resultDiv.className = country ? "success" : "error";
        }
    </script>
</body>
</html>