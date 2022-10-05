
<?php 
    if(isset($_POST["submit"])) include "../routes/create.php"; 
?>

<form method="post">
    <label for="restaurant_name">Restaurant Name</label>
    <input type="text" name="restaurant_name" id="restaurant_name" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST" && !$validationPassed) echo $submittedData['name']; ?>">
    <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['nameErr']; ?></span>
    <fieldset>
        <legend>Location Info</legend>
        <label for="city">City</label>
        <input type="text" id="city" name="city" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST" && !$validationPassed) echo $submittedData['city']; ?>">
        <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['cityErr']; ?></span>
        <label for="district">District</label>
        <input type="text" id="district" name="district" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST" && !$validationPassed) echo $submittedData['district']; ?>">
        <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['districtErr']; ?></span>
        <label for="postcode">Postcode</label>
        <input type="text" id="postcode" name="postcode" <?php if($_SERVER["REQUEST_METHOD"] == "POST"&& !$validationPassed) echo $submittedData['postcode']; ?>>
        <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['postcodeErr']; ?></span>
    </fieldset>
    <label for="cuisine">Cuisine</label>
    <select name="cuisine" id="cuisine">
        <?php
            $cuisineArr = ["korean", "japanese", "thai", "vietnamese", "american"];
            for ($i=0; $i<count($cuisineArr); $i++) {
                if(isset($_POST['submit']) && !$validationPassed && $submittedData['cuisine'] == $cuisineArr[$i]) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
        ?>
            <option value=<?=$cuisineArr[$i]?> <?=$selected?>> <?=$cuisineArr[$i]?> </option>
        <?php 
            } 
        ?> 
    </select>
    <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['cuisineErr']; ?></span>
    <fieldset>
        <label for="low_price">Budget</label>
        <input type="radio" name="price" id="low_price" value="low_price">
        <label for="medium_price">Normal</label>
        <input type="radio" name="price" id="medium_price" value="medium_price">
        <label for="high_price">Expensive</label>
        <input type="radio" name="price" id="high_price" value="high_price">
        <span class="error"><?php if($_SERVER["REQUEST_METHOD"] == "POST") echo $formValidation['priceErr']; ?></span>
    </fieldset>
    <button type="submit" name="submit" value="submit">Submit</button>
</form>
<h4 id="success_message"><?php if(isset($_POST['submit'])) echo $successMsg; ?></h4>