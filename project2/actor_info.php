<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Actor Info</title>
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
  <h2>Actor Information Page: </h2>
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

$id = $_GET["identifier"];
if ($id != NULL)
{
$input_recieved = true;	

$statement1 = $db->prepare("SELECT first, last, sex, dob, dod FROM Actor WHERE id= ?");
$statement1->bind_param('i', $id);

$statement1->execute();

if (!$statement1) {
	    $errmsg = $db->error; 
	        print "Query failed: $errmsg <br>"; 
	        exit(1); 
}

$statement1->bind_result($returned_first, $returned_last, $returned_sex, $returned_dob, $returned_dod);
$statement1->store_result();

$query = "SELECT M.id, MA.role, M.title FROM MovieActor MA, Movie M WHERE (MA.mid = M.id) AND (MA.aid = $id)";
$query .= " ORDER BY title, year";
#$sanitized_id = $db->real_escape_string($id);
#$query_to_issue = sprintf($query, $sanitized_id); 
$rs = $db->query($query);

if (!$rs) {
	    $errmsg = $db->error; 
	        print "Query failed: $errmsg <br>"; 
	        exit(1); 
}

}

?>
<div class="center">
<h3>Actor Information:</h3>
<div class="table-responsive">
<table class="table table-bordered table condensed table-hover">
	<thead>
		<tr>
			<td>Name</td>
			<td>Sex</td>
			<td>Date of Birth</td>
			<td>Date of Death</td>
		</tr>
	</thead>
	<tbody>
	  <?php 
		if ($input_recieved){
		if ($returned_dod == NULL){
			while ($statement1->fetch()) {
				echo "<tr>";
				echo "<td>" . $returned_first . ' ' . $returned_last . "</td>";
				echo "<td>" . $returned_sex . "</td>";
				echo "<td>" . $returned_dob . "</td>";
				echo "<td>" . "Still Alive" . "</td>";
				echo "</tr>";
			}
		}
		else
		{
			while ($statement1->fetch()) {
				echo "<tr>";
				echo "<td>" . $returned_first . ' ' . $returned_last . "</td>";
				echo "<td>" . $returned_sex . "</td>";
				echo "<td>" . $returned_dob . "</td>";
				echo "<td>" . $returned_dod . "</td>";
				echo "</tr>";
																                        }
		}
		}
	  ?>
	</tbody>
</table>
</div>

<h3>Actor's Movies and Roles:</h3>
<div class="table-responsive">
<table class="table table-bordered table condensed table-hover">
        <thead>
                <tr>
                        <td>Role</td>
			<td>Movie Title</td>
                </tr>
        </thead>
        <tbody>
          <?php
                while ($row = $rs->fetch_assoc()) {
			$role = $row['role'];
			$title = $row['title'];
			$ident = $row['id'];
			echo "<tr>";
                        echo "<td>" . $role . "</td>";
                        echo "<td>" . "<a href='movie_info.php?identifier=". $ident . "'>" . $title . "</a>" . "</td>";
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
