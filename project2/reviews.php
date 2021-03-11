<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add a Review!</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<style>
.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;

}

.center {
  margin: auto;
  width: 60%;
  padding: 10px;
}

</style>
</head>
<body>

<nav class="topnav navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header navbar-defalt">
          <a class="navbar-brand" href="index.php">Home</a>
        </div>
      </div>
</nav>

<h1>	<br><br></h1>

<?php
$db = new mysqli('localhost', 'cs143', '', 'cs143');
if ($db->connect_errno > 0) {
	            die('Unable to connect to database [' . $db->connect_error . ']');
}

$ID = $_GET["MovieID"];
if ($ID != NULL)
{
	$query = "SELECT title FROM Movie WHERE id = $ID";
	$rs = $db->query($query);
	
	if (!$rs) {
	            $errmsg = $db->error;
  		    print "Query failed: $errmsg <br>";
		    exit(1);
	          }
}

?>

<div class="center">
<div class="container">
	<form method="GET" id="userform">
		<h3>Add Reviews Here:</h3>
		<div class="form-group">
			<label for="ID">Movie Title:</label>
			<select name="MovieID">
			<option value= <?php echo $ID;?>><?php while ($row = $rs->fetch_assoc()) {echo $row['title'];}?></option> 
			</select>
		</div>
		<div class="form-group">
			<label for="title">Your Name:</label>
			<input type="text" name="viewer" class="form-control" value="Anonymous" id="title">
		</div>
		<div class="form-group">
                    <label for="rating">Rating</label>
                    <select class="form-control" name="score" id="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
		</div>
		<div class="form-froup">
                  <textarea class="form-control" name="comment" rows="5" placeholder="no more than 500 characters"></textarea><br> 
		</div>
		<button type="submit" class="btn btn-default">Submit!</button>
	</form>
</div>

<?php
$input_recieved = false;
$name = $_GET["viewer"];
$rating = $_GET["score"];
$comment = $_GET["comment"];
$time = date("Y-m-d H:i:s");

if ($rating != NULL)
{
	$query = "INSERT INTO Review VALUES ('$name', '$time', $ID, $rating, '$comment')";
	$rs = $db->query($query);
	if (!$rs) {
		    $errmsg = $db->error; 
		     print "Query failed: $errmsg <br>"; 
		     exit(1); 
	}
	else
	{
		echo "Succesfully added movie review!";
	}
}

$db->close();
?>

</div>
</body>
</html>
