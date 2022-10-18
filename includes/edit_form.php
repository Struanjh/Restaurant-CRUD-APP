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
<?php 
    include "../routes/update.php";
    if($dataFile) { 
?>
        <form method="post" class="edit">
            <div class="form-section">
                <div class="form-sub-section">
                    <label for="restaurant_name">Select a restaurant to edit</label>
                    <select name="restaurant_name" id="restaurant_name">
                            <?php                            
                                for ($i=0; $i<count($restaurants); $i++) {
                                    if((isset($_POST['edit']) && $restaurants[$i]['id'] ===  $currSelecData[0]['id']) 
                                        ||
                                       (isset($_POST['submit']) && $restaurants[$i]['id'] === $submittedData['id']) && !$validationPassed) {
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    }
                                    echo '<option value="' . $restaurants[$i]['id'] . '|' . $restaurants[$i]['name'] . '" ' . $selected . '>' . $restaurants[$i]['name'] . '</option>';
                                }         
                            ?>
                    </select>
                </div>
                <div class="form-sub-section">
                    <button type="submit" name="edit" value="edit">Edit Entry</button>
                    <button type="submit" name="delete" value="delete">Delete</button> 
                </div>
            </div>
            <div class="form-section">
                <div class="form-sub-section">
                    <label for="cuisine">Cuisine</label>
                    <select name="cuisine" id="cuisine">
                        <?php
                            $cuisineArr = ["korean", "japanese", "thai", "vietnamese", "american"];
                            for ($i=0; $i<count($cuisineArr); $i++) {
                                if((isset($_POST['edit'], $currSelecData[0]['cuisine']) && $currSelecData[0]['cuisine'] == $cuisineArr[$i])
                                   ||
                                   (isset($_POST['submit'], $submittedData['cuisine']) && $submittedData['cuisine'] == $cuisineArr[$i]) && !$validationPassed) {
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
                    <span class="error"><?php if(isset($_POST['submit']) && count($restaurants) > 0) echo $formValidation['cuisineErr']; ?></span>
                </div>
                <div class="form-sub-section">
                    <fieldset class="price">
                        <legend>Price Range</legend>
                        <div>
                            <label for="low_price">Budget</label>
                            <input type="radio" name="price" id="low_price" value="low_price" 
                            <?php 
                                if(isset($_POST['edit'], $currSelecData[0]['price']) && $currSelecData[0]['price'] == 'low_price') {
                                    echo 'checked';
                                } elseif (isset($_POST['submit'], $submittedData['price']) && !$validationPassed && $submittedData['price'] == 'low_price') {
                                    echo 'checked';
                                }
                            ?>>
                        </div>
                        <div>
                            <label for="medium_price">Normal</label>
                            <input type="radio" name="price" id="medium_price" value="medium_price" 
                            <?php
                                if(isset($_POST['edit'], $currSelecData[0]['price']) && $currSelecData[0]['price'] == 'medium_price') {
                                    echo 'checked';
                                } elseif (isset($_POST['price'], $submittedData['price']) && !$validationPassed && $submittedData['price'] == 'medium_price') {
                                    echo 'checked';
                                }
                            ?>>
                        </div>
                        <div>
                            <label for="high_price">Expensive</label>
                            <input type="radio" name="price" id="high_price" value="high_price"
                            <?php
                                if(isset($_POST['edit'], $currSelecData[0]['price']) && $currSelecData[0]['price'] == 'high_price') {
                                    echo 'checked';
                                } elseif (isset($_POST['submit'], $submittedData['price']) && !$validationPassed && $submittedData['price'] == 'high_price') {
                                    echo 'checked';
                                }
                            ?>>
                        </div>
                    </fieldset>
                    <span class="error"><?php if(isset($_POST['submit']) && count($restaurants) > 0) echo $formValidation['priceErr']; ?></span>
                </div>
            </div>
            <fieldset class="form-section">
                <legend>Location Info</legend>
                <div class="form-sub-section">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" 
                        <?php 
                            if(isset($_POST['edit'], $currSelecData[0]['city'])) {
                                echo 'value=' . $currSelecData[0]['city']; 
                            } elseif (isset($_POST['submit'], $submittedData['city']) && !$validationPassed) {
                                echo 'value=' . $submittedData['city'];
                            }  
                        ?>>
                    <span class="error"><?php if(isset($_POST['submit']) && count($restaurants) > 0) echo $formValidation['cityErr']; ?></span>
                </div>
                <div class="form-sub-section">
                    <label for="district">District</label>
                    <input type="text" id="district" name="district" 
                    <?php 
                        if(isset($_POST['edit'], $currSelecData[0]['district'])) {
                            echo 'value=' . $currSelecData[0]['district']; 
                        } elseif (isset($_POST['submit'], $submittedData['district']) && !$validationPassed) {
                            echo 'value=' . $submittedData['district'];
                        }  
                    ?>>
                    <span class="error"><?php if(isset($_POST['submit']) && count($restaurants) > 0) echo $formValidation['districtErr']; ?></span>
                </div>
                <div class="form-sub-section">
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" name="postcode"
                     <?php 
                        if(isset($_POST['edit'], $currSelecData[0]['postcode'])) {
                            echo 'value=' . $currSelecData[0]['postcode']; 
                        } elseif (isset($_POST['submit'], $submittedData['postcode']) && !$validationPassed) {
                            echo 'value=' . $submittedData['postcode'];
                        }  
                     ?>>
                    <span class="error"><?php if(isset($_POST['submit']) && count($restaurants) > 0) echo $formValidation['postcodeErr']; ?></span>
                </div>
            </fieldset>
            <button type="submit" name="submit" value="submit">Submit</button> 
        </form>
<?php 
    } 
?>
<h4 id="success_message"><?php if(!empty($successMsg))echo $successMsg; ?></h4>  
</body>
</html>
  