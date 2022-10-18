<?php
    //-----------------------------FUNCTION DEFINITIONS-------------------------------//

    function dbg($msg, $data) {
        if(gettype($data) === 'array' || gettype($data) === 'object') {
            echo '<br>' . $msg . '<br>';
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
        else {
            echo '<br>' . $msg . '<br>' . $data . '<br>'; 
        }
    }


    //Creates data.json if it doesn't already exist & returns boolean showing if file was created
    function create_file($file_path) {
        if (file_exists($file_path)) {
            return false;
        } else {
            //create the file
            fopen($file_path, 'a+');
            return true;
        }
    }

    //Takes input from the user submitted data, sanitizes the data and returns it
    function cleanse_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    //Returns an array containing any error messages, an array containing sanitized user data
    //+ a boolean showing if validation passed..
    function handleFormSubmission($operation, $newFile) {
        $errorMessages = [];
        $submittedData = [];
        $validationPassed = true;
        if($operation === "SEARCH") {
            foreach($_POST as $key => $val) {
                if(isset($key) && $val!== "" && $key !== "submit") {
                    $submittedData[$key] = cleanse_data($val);
                }
            }
            dbg("FORM SUBMISSION PROCESSED DATA", $submittedData);
            return [null, $submittedData, $validationPassed];
        }
        if (empty($_POST["restaurant_name"]) && $operation !== "SEARCH") {
            $nameErr = "Name is required";
            $errorMessages["nameErr"] = $nameErr;
            $submittedData["name"] = "";
            $validationPassed = false;
        } elseif (!$newFile && in_array($_POST["restaurant_name"], $GLOBALS['restaurants']) && $operation === "ADD") {
            $nameErr = "This name already exists!";
            $errorMessages["nameErr"] = $nameErr;
            $submittedData["name"] = "";
            $validationPassed = false;
        } elseif ($operation === "EDIT") {
            $errorMessages["nameErr"] = "";
            $nameID = splitValues($_POST["restaurant_name"], "|");
            $submittedData["id"] = cleanse_data($nameID[0]);
            $submittedData["name"] = cleanse_data($nameID[1]);
         } else {
            $errorMessages["nameErr"] = "";
            $submittedData["name"] = cleanse_data($_POST["restaurant_name"]);
        }
        if (empty($_POST["city"]) && $operation !== "SEARCH") {
            $cityErr = "City is required";
            $errorMessages["cityErr"] = $cityErr;
            $submittedData["city"] = "";
            $validationPassed = false;
        } else {
            $errorMessages["cityErr"] = "";
            $submittedData["city"] = cleanse_data($_POST["city"]);
        }
        if (empty($_POST["district"]) && $operation !== "SEARCH") {
            $districtErr = "District is required";
            $errorMessages["districtErr"] = $districtErr;
            $submittedData["district"] = "";
            $validationPassed = false;
        } else {
            $errorMessages["districtErr"] = "";
            $submittedData["district"] = cleanse_data($_POST["district"]);
        }
        if (empty($_POST["postcode"]) && $operation !== "SEARCH") {
            $postcodeErr = "Postcode is required";
            $errorMessages["postcodeErr"] = $postcodeErr;
            $submittedData["postcode"] = "";
            $validationPassed = false;
        } else {
            $errorMessages["postcodeErr"] = "";
            $submittedData["postcode"] = cleanse_data($_POST["postcode"]);
        }
        if (!isset($_POST["cuisine"]) && $operation !== "SEARCH") {
            $cuisineErr = "Cuisine is required";
            $errorMessages["cuisineErr"] = $cuisineErr;
            $submittedData["cuisine"] = "";
            $validationPassed = false;
        } else {
            $errorMessages["cuisineErr"] = "";
            $submittedData["cuisine"] = cleanse_data($_POST["cuisine"]);
        }
        if (!isset($_POST["price"]) && $operation !== "SEARCH") {
            $priceErr = "Price is required";
            $errorMessages["priceErr"] = $priceErr;
            $submittedData["price"] = "";
            $validationPassed = false;
        } else {
            $errorMessages["priceErr"] = "";
            $submittedData["price"] = cleanse_data($_POST["price"]);
        }
        return [$errorMessages, $submittedData, $validationPassed];
    }

    //Creates data.json file if it doesn't exist, reads it's contents, and converts to PHP Obj...
    function readData() {
        $json = file_get_contents(FILEPATH);
        $json_data = json_decode($json,true);
        return $json_data;
    }

    //Pushes new data to the existing data obj and returns the complete data obj
    function appendNewData($existingData, $dataToAppend) {
        array_push($existingData, $dataToAppend);
        return $existingData;
    }

    //Writes the new complete data obj to the data.json file (replacing what was there before..)
    function writeData($data) {
        $data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(FILEPATH , $data);
    }

    //Function loops through data file and
    //returns a nested array of restaurants only ID and Restaurant Names to populate the dropdown list
    function listRestaurants($data) {
        $restaurants = [];
        for($i=0; $i<count($data); $i++) {
            $restaurant = [];
            foreach ($data[$i] as $key => $value) {
                if ($key == "id" || $key == "name") {
                    $restaurant[$key] = $value;
                }
            }
            array_push($restaurants, $restaurant);
        }
        return $restaurants;
    }


    //This function accepts an Assoc Arr to be filtered, and an Assoc Arr of values to filter the object by....
    //It returns an object containing matching results..
    function filterData($objToFilter, $criteria) {
        $results = [];
        //Loop the database - each place object.....
        foreach($objToFilter as $entry) {
            dbg("ENTRY", $entry);
            $matchFound = true;
            foreach($criteria as $key => $val) {
                if($entry[$key] !== $val) {
                    //There's no match, move on to the next object.....
                    $matchFound = false;
                    break;
                }
            }
            if($matchFound) array_push($results, $entry);
        }
        return $results;
    }

    //Take the PHP data object and a restaurant name represneting an entry to be deleted.
    //Returns the PHP Object with the target entry deleted...
    function deleteAnEntry($data, $entryToDelete) {
        $newData = [];
        for($i=0; $i<count($data); $i++) {
            $delete = false;
            foreach($data[$i] as $key => $val) {
                if($key === 'id' && $val === $entryToDelete) {
                    $delete = true;
                    break;
                }
            }
            if(!$delete) {
                array_push($newData, $data[$i]);
            } 
        }
        return $newData;
    }
       

    function updateData($objToUpdate, $data) {
        for($i=0; $i<count($objToUpdate); $i++) {
            if($objToUpdate[$i]['name'] == $data['name']) {
                foreach($data as $key => $val) {
                    $objToUpdate[$i][$key] = $data[$key];
                }
                return $objToUpdate;
            }
        }
    }

    function countSearchResults($count) {
        if($count === 0) {
            $msg = "No results found!";
        } elseif ($count === 1) {
            $msg = "1 result found!";
        } elseif ($count > 1) {
            $msg = $count . ' results found!';
        }
        return $msg;   
    }

    function makeRequest($url, $endPoint) {
        $ch = curl_init();
        //Connect to URL
        curl_setopt($ch, CURLOPT_URL, $url . $endPoint);
        //Receive response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $binary_server_response = curl_exec($ch);
        curl_close($ch);
        $convertedServerResponse = "data:image/gif;base64," . base64_encode($binary_server_response);
        return $convertedServerResponse;
    }

    function splitValues($value, $delimiter) {
        $value = explode($delimiter, $value);
        return $value;
    }


