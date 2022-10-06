<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php   include "../routes/update.php"; ?>

<!-- //Restaurant Names with spaces to display to the user
       CurrSelectData has no spaces...... read directly from db... -->
<?php 
    if($dataFile) { 
?>
        <form method="post">
            <label for="restaurant_name">Select the restaurant you want to edit...</label>
            <select name="restaurant_name" id="restaurant_name">
                    <?php   for($i=0; $i<count($restaurantNames); $i++){ 
                                if(isset($_POST['edit']) && $restaurantNames[$i] == $currSelecData[0]['name']) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                echo '<option value="' . $restaurantNames[$i] . '"' . $selected . '>' . $restaurantNames[$i] . '</option>';
                            }
                    ?>
            </select>
            <button type="submit" name="edit" value="edit">Edit Entry</button>
            <button type="submit" name="delete" value="delete">Delete</button> 
            <fieldset>
                <legend>Location Info</legend>
                <label for="city">City</label>
                <input type="text" id="city" name="city" <?php if(isset($_POST['edit'], $currSelecData[0]['city'])) echo 'value=' . $currSelecData[0]['city']; ?>>
                <span class="error"><?php if(isset($_POST['submit']) && count($restaurantNames) > 0) echo $formValidation['cityErr']; ?></span>
                <label for="district">District</label>
                <input type="text" id="district" name="district" <?php if(isset($_POST['edit'], $currSelecData[0]['district'])) echo 'value=' . $currSelecData[0]['district']; ?>>
                <span class="error"><?php if(isset($_POST['submit']) && count($restaurantNames) > 0) echo $formValidation['districtErr']; ?></span>
                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" name="postcode" <?php if(isset($_POST['edit'], $currSelecData[0]['postcode'])) echo 'value=' . $currSelecData[0]['postcode']; ?>>
                <span class="error"><?php if(isset($_POST['submit']) && count($restaurantNames) > 0) echo $formValidation['postcodeErr']; ?></span>
            </fieldset>
            <label for="cuisine">Cuisine</label>
            <select name="cuisine" id="cuisine">
                <?php
                    $cuisineArr = ["korean", "japanese", "thai", "vietnamese", "american"];
                    for ($i=0; $i<count($cuisineArr); $i++) {
                        if(isset($_POST['edit'], $currSelecData[0]['cuisine']) && $currSelecData[0]['cuisine'] == $cuisineArr[$i]) {
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
            <span class="error"><?php if(isset($_POST['submit']) && count($restaurantNames) > 0) echo $formValidation['cuisineErr']; ?></span>
            <fieldset>
                <legend>Price Range</legend>
                <label for="low_price">Budget</label>
                <input type="radio" name="price" id="low_price" value="low_price" <?php if(isset($_POST['edit'], $currSelecData[0]['price']) && $currSelecData[0]['price'] == 'low_price') echo 'checked';?>>
                <label for="medium_price">Normal</label>
                <input type="radio" name="price" id="medium_price" value="medium_price" <?php if(isset($_POST['edit'], $currSelecData[0]['price']) && $currSelecData[0]['price'] == 'medium_price') echo 'checked';?>>
                <label for="high_price">Expensive</label>
                <input type="radio" name="price" id="high_price" value="high_price" <?php if(isset($_POST['edit'], $currSelecData[0]['price']) && $currSelecData[0]['price'] == 'high_price') echo 'checked';?>>
                <span class="error"><?php if(isset($_POST['submit']) && count($restaurantNames) > 0) echo $formValidation['priceErr']; ?></span>
            </fieldset>
            <button type="submit" name="submit" value="submit">Submit</button> 
        </form>
<?php 
    } 
?>
<h4 id="success_message"><?php if(!empty($successMsg))echo $successMsg; ?></h4>  
</body>
</html>
  