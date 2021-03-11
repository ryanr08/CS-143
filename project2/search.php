<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Search Portal</title>
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

<div class="container">
  <h2>Searching Page: </h2>
  <form action="<?php echo htmlspecialchars("search.php");?>" method="GET">
    <div class="form-group">
      <label for="search_input">Search:</label>
      <input type="text" class="form-control" id="search" placeholder="Enter keyword" name="search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>


<?php
$db = new mysqli('localhost', 'cs143', '', 'cs143');
if ($db->connect_errno > 0) { 
	    die('Unable to connect to database [' . $db->connect_error . ']'); 
}

$input_recieved = false;

$search = $_GET["search"];
if ($search != NULL)
{
$input_recieved = true;	
$search = explode(" ", $search);	
$name1 = $search[0];
$name2 = $search[1];
$name1 = '%' . $name1 . '%';
$name2 = '%' . $name2 . '%';

if (empty($name2)){
	$statement1 = $db->prepare("SELECT id, first, last, dob FROM Actor WHERE (first LIKE ?) OR (last LIKE ?) ORDER BY last, first, dob");
	$statement1->bind_param('ss', $name1, $name1);
}
else
{
	$statement1 = $db->prepare("SELECT id, first, last, dob FROM Actor WHERE ((first LIKE ?) AND (last LIKE ?)) OR ((first LIKE ?) AND (last LIKE ?)) ORDER BY last, first, dob");
	$statement1->bind_param('ssss', $name1, $name2, $name2, $name1);
}

$statement1->execute();

if (!$statement1) {
	    $errmsg = $db->error; 
	        print "Query failed: $errmsg <br>"; 
	        exit(1); 
}

$statement1->bind_result($returned_id, $returned_first, $returned_last, $returned_dob);
$statement1->store_result();

$query = "SELECT id, title, year FROM Movie WHERE (title LIKE ";
for ($i = 0; $i < count($search); $i++)
{
	if ($i < (count ($search) - 1))
	{
		$query .= "'%" . $search[$i] . "%') AND (title LIKE ";
	}
	else
	{
		$query .= "'%" . $search[$i] . "%')";
	}
}
$query .= " ORDER BY title, year";
#$sanitized_name = $db->real_escape_string($search);
#$query_to_issue = sprintf($query, $sanitized_name); 
$rs = $db->query($query);

if (!$rs) {
	    $errmsg = $db->error; 
	        print "Query failed: $errmsg <br>"; 
	        exit(1); 
}

}

?>
<div class="center">
<h3>matching Actors are:</h3>
<div class="table-responsive">
<table class="table table-bordered table condensed table-hover">
	<thead>
		<tr>
			<td>Name</td>
			<td>Date of Birth</td>
		</tr>
	</thead>
	<tbody>
	  <?php 
		if ($input_recieved){ 
		while ($statement1->fetch()) {
			echo "<tr>";
			echo "<td>" . "<a href='actor_info.php?identifier=" . $returned_id . "'>" . $returned_first . ' ' . $returned_last . "</a>" . "</td>";
			echo "<td>" . $returned_dob . "</td>";
			echo "</tr>";
		}}
	  ?>
	</tbody>
</table>
</div>

<h3>matching Movies are:</h3>
<div class="table-responsive">
<table class="table table-bordered table condensed table-hover">
        <thead>
                <tr>
                        <td>Title</td>
                        <td>Year</td>
                </tr>
        </thead>
        <tbody>
          <?php
		while ($row = $rs->fetch_assoc()) {
			$id = $row['id'];
			$title = $row['title'];
			$year = $row['year'];
			echo "<tr>";
                        echo "<td>" . "<a href='movie_info.php?identifier=" . $id . "'>" . $title . "</a>" . "</td>";
                        echo "<td>" . $year . "</td>";
                        echo "</tr>";
                }
          ?>
        </tbody>
</table>
</div>

</div>
<?php
if ($search != NULL){
	$statement1->free_result();
	$rs->free();
	$db->close();
}
?>
</body>
</html>
