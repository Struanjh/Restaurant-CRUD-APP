<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Add</title>
</head>
<body>
    <?php include "../routes/create.php"; ?>
    <form method="post">
        <div class="form-section">
            <div class="form-sub-section">
                <label for="restaurant_name">Restaurant Name</label>
                <input type="text" name="restaurant_name" id="restaurant_name" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST" && !$validationPassed) echo $submittedData['name']; ?>">
                <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['nameErr']; ?></span>
            </div>
            <div class="form-sub-section">
                <label for="cuisine">Cuisine</label>
                <select name="cuisine" id="cuisine">
                    <?php
                        for ($i=-1; $i<count($cuisineArr); $i++) {
                            if(isset($_POST['submit']) && !$validationPassed && $submittedData['cuisine'] == $cuisineArr[$i]['name']) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            if($i === -1) {
                    ?>
                                <option disabled selected> -- select an option -- </option>
                    <?php   
                            } else {  
                    ?>
                                <option value=<?=$cuisineArr[$i]['name']?> <?=$selected?>> <?=$cuisineArr[$i]['name']?> </option>
                   <?php 
                            }
                   ?>       
                    <?php 
                        } 
                    ?> 
                </select>
                <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['cuisineErr']; ?></span>
            </div>
            <div class="form-sub-section">
                <fieldset class="price">
                    <legend>Price</legend>
                    <div>
                        <label for="low_price">Budget</label>
                        <input type="radio" name="price" id="low_price" value="low_price" <?php if($_SERVER["REQUEST_METHOD"] == "POST" && !$validationPassed && $submittedData['price'] === 'low_price') echo 'checked'; ?>>
                    </div>
                    <div>
                        <label for="medium_price">Normal</label>
                        <input type="radio" name="price" id="medium_price" value="medium_price" <?php if($_SERVER["REQUEST_METHOD"] == "POST" && !$validationPassed && $submittedData['price'] === 'medium_price') echo 'checked';?>>
                    </div>
                    <div>
                        <label for="high_price">Expensive</label>
                        <input type="radio" name="price" id="high_price" value="high_price" <?php if($_SERVER["REQUEST_METHOD"] == "POST" && !$validationPassed && $submittedData['price'] === 'high_price') echo 'checked';?>>
                    </div>
                </fieldset>
                <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['priceErr']; ?></span>
            </div>
        </div>
        <fieldset class="form-section">
            <legend>Location Info</legend>
            <div class="form-sub-section">
                <label for="city">City</label>
                <input type="text" id="city" name="city" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST" && !$validationPassed) echo $submittedData['city']; ?>">
                <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['cityErr']; ?></span>
            </div>
            <div class="form-sub-section">
                <label for="district">District</label>
                <input type="text" id="district" name="district" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST" && !$validationPassed) echo $submittedData['district']; ?>">
                <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['districtErr']; ?></span>
            </div>
            <div class="form-sub-section">
                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" name="postcode" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"&& !$validationPassed) echo $submittedData['postcode']; ?>">
                <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['postcodeErr']; ?></span>
            </div>
        </fieldset>
        <button type="submit" name="submit" value="submit">Submit</button>
    </form>
    <h4 id="success_message"><?php if(!empty($successMsg))echo $successMsg ?></h4>
</body>
</html>
