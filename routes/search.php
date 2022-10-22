<?php
    include "../_functions.php";
    include "../includes/_constants.php";

    $dataFile = file_exists(FILEPATH);
   
    if(!$dataFile) {
        $outcomeMsg = "No restaurants available to search!";
    } else {
        if(isset($_POST['submit']) && $dataFile) {
            $json_data = readData();
            if($json_data === null) {
                //The file is totally empty
                $restaurants = null;
                $outcomeMsg = "No restaurants available to search!";
            }
            elseif(is_array($json_data) && count($json_data) === 0) {
                //The file contains an empty array
                $outcomeMsg = "No restaurants available to search!";
            } else {
                //There is data to be searched.. perform the search.........
                $restaurants = listRestaurants($json_data);
                //Indexed Arr
                $formSubmission = handleFormSubmission("SEARCH", false);
                // //Assoc Arr
                $submittedData = $formSubmission[1];
                $searchResults = filterData($json_data, $submittedData);
                if(count($submittedData) === 0 ) {
                    $outcomeMsg = "Returned all " . count($searchResults) . " available restaurants";
                } else {
                    $outcomeMsg = countSearchResults(count($searchResults));
                } 
            }
        }
    }