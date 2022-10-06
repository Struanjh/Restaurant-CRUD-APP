<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Search</title>
</head>
<body>
    <?php   include "../routes/search.php"; ?>
    <form method="post">
        <label for="restaurant_name">Restaurant Name</label>
        <input type="text" name="restaurant_name" id="restaurant_name" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST" && isset($submittedData['name'])) echo $submittedData['name']; ?>">
        <fieldset>
            <legend>Location Info</legend>
            <label for="city">City</label>
            <input type="text" id="city" name="city" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST" && isset($submittedData['city'])) echo $submittedData['city']; ?>">
            <label for="district">District</label>
            <input type="text" id="district" name="district" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST" && isset($submittedData['district'])) echo $submittedData['district']; ?>">
            <label for="postcode">Postcode</label>
            <input type="text" id="postcode" name="postcode" <?php if($_SERVER["REQUEST_METHOD"] == "POST" && isset($submittedData['postcode'])) echo $submittedData['postcode']; ?>>
        </fieldset>
        <label for="cuisine">Cuisine</label>
        <select name="cuisine" id="cuisine">
            <?php
                $cuisineArr = ["korean", "japanese", "thai", "vietnamese", "american"];
                for ($i=0; $i<count($cuisineArr); $i++) {
                    if(isset($_POST['submit']) && $submittedData['cuisine'] == $cuisineArr[$i]) {
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
        <fieldset>
            <label for="low_price">Budget</label>
            <input type="radio" name="price" id="low_price" value="low_price">
            <label for="medium_price">Normal</label>
            <input type="radio" name="price" id="medium_price" value="medium_price">
            <label for="high_price">Expensive</label>
            <input type="radio" name="price" id="high_price" value="high_price">
        </fieldset>
        <button type="submit" name="submit" value="submit">Submit</button>
    </form>
    <h4 id="success_message"><?php if(isset($_POST['submit'])) echo $outcomeMsg; ?></h4>
        <?php
        if(isset($_POST['submit']) && $dataFile && count($restaurantNames) > 0 ) {
            for($i=0; $i<count($searchResults); $i++) { 
        ?>
                <div>
                    <h4><?= $searchResults[$i]['name'] ?></h4>
                    <ul>
                        <li><?= $searchResults[$i]['city'] ?></li>
                        <li><?= $searchResults[$i]['district'] ?></li>
                        <li><?= $searchResults[$i]['postcode'] ?></li>
                        <li><?= $searchResults[$i]['cuisine'] ?></li>
                        <li><?= $searchResults[$i]['price'] ?></li>
                    </ul>
                </div>
        <?php 
            } 
        }
        ?> 
</body>
</html>

   
  

