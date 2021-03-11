<?php
# get the id parameter from the request
$id = intval($_GET['id']);

# set the Content-Type header to JSON, so that the client knows that we are returning a JSON data
header('Content-Type: application/json');

$db = new mysqli('localhost', 'cs143', '', 'cs143');
if ($db->connect_errno > 0) { 
	    die('Unable to connect to database [' . $db->connect_error . ']'); 
}

if ($id != NULL)
{
$query = "SELECT * FROM Laureates WHERE id = $id";
$rs = $db->query($query);

if (!$rs) {
    $errmsg = $db->error; 
        print "Query failed: $errmsg <br>"; 
        exit(1); 
}

$query2 = "SELECT * FROM NobelPrizes WHERE id = $id";
$rs2 = $db->query($query2);

if (!$rs2) {
    $errmsg = $db->error; 
        print "Query failed: $errmsg <br>"; 
        exit(1); 
}

$first = NULL;
$last = NULL;
$gender = NULL;
$dob = NULL;
$city = NULL;
$country = NULL;
$orgName = NULL;

while ($row = $rs->fetch_assoc()) {
    $first = $row['givenName'];
    $last = $row['familyName'];
    $gender = $row['gender'];
    $dob = $row['dob'];
    $city = $row['city'];
    $country = $row['country'];
    $orgName = $row['orgName'];
    }

if ($first != NULL or $last != NULL)
{
    echo '{
        "id":"' . $id . '", 
        "givenName":{ "en":"' . $first . '" }, 
        "familyName":{ "en":"' . $last . '" }, 
        "gender":"' . $gender . '", 
        "birth":{
            "date": "' . $dob . '", 
            "place":{
                "city":{"en": "'. $city . '"}, 
                "country":{"en":"' . $country . '"}
            }
        },
        ';
}
else
{
    echo '{
        "id":"' . $id . '", "orgName":{ "en":"' . $orgName . '" }, 
        "founded":{"date": "' . $dob . '", "place":{"city":{"en": "'. $city . '"}, "country":{"en":"' . $country . '"}}},
        ';
}
echo '"nobelPrizes":[';
while ($row2 = $rs2->fetch_assoc()) {
    $awardYear = $row2['awardYear'];
    $category = $row2['category'];
    $sortOrder = $row2['sortOrder'];
    $portion = $row2['portion'];
    $prizeStatus = $row2['prizeStatus'];
    $dateAwarded = $row2['dateAwarded'];
    $motivation = $row2['motivation'];
    $prizeAmount = $row2['prizeAmount'];
    $afflName = $row2['afflName'];
    $afflCity = $row2['afflCity'];
    $afflCountry = $row2['afflCountry'];
    echo '{
        "awardYear":"' . $awardYear . '", 
        "category":{"en":"' . $category . '"}, 
        "sortOrder":"' . $sortOrder . '", 
        "portion":"' .$portion . '", 
        "dateAwarded":"' . $dateAwarded . '", 
        "prizeStatus":"' . $prizeStatus . '",
        "motivation":{"en": "' . $motivation . '"}, 
        "prizeAmount":' . $prizeAmount . ', 
        "affiliations":[{
            "name":{"en":"' . $afflName . '"},
            "city":{"en":"' . $afflCity . '"},
            "country":{"en":"' . $afflCountry . '"}
        }] 
    }';
    }
echo ']
}';
}
else{
    echo "No ID given";
}
?>