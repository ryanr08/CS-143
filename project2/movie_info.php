<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Movie Info</title>
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
  <h2>Movie Information Page: </h2>
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

$statement1 = $db->prepare("SELECT M.title, M.year, M.rating, M.company FROM Movie M WHERE M.id= ?");

$statement1->bind_param('i', $id);
$statement1->execute();

if (!$statement1) {
	    $errmsg = $db->error; 
	        print "Query failed: $errmsg <br>"; 
	        exit(1); 
}

$statement1->bind_result($returned_title, $returned_year, $returned_rating, $returned_company);
$statement1->store_result();

$statement2 = $db->prepare("SELECT genre FROM MovieGenre WHERE mid = ?");

$statement2->bind_param('i', $id);
$statement2->execute();

if (!$statement2) {
	            $errmsg = $db->error;
		                    print "Query failed: $errmsg <br>";
		                    exit(1);
}

$statement2->bind_result($returned_genre);
$statement2->store_result();

$statement3 = $db->prepare("SELECT D.first, D.last, D.dob FROM Director D, MovieDirector MD WHERE (MD.did = D.id) AND (MD.mid= ?)");

$statement3->bind_param('i', $id);
$statement3->execute();

if (!$statement3) {
	            $errmsg = $db->error;
		                    print "Query failed: $errmsg <br>";
		                    exit(1);
}

$statement3->bind_result($returned_first, $returned_last, $returned_dob);
$statement3->store_result();


$query = "SELECT A.id, first, last, role FROM MovieActor MA, Actor A WHERE (MA.mid = $id) AND (MA.aid = A.id)";
$query .= " ORDER BY last, first";
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
<h3>Movie Information:</h3>
<div class="table-responsive">
<table class="table table-bordered table condensed table-hover">
	<thead>
		<tr>
			<td>Title</td>
			<td>Rating</td>
			<td>Producer</td>
			<td>Director</td>
			<td>Genre</td>
		</tr>
	</thead>
	<tbody>
	  <?php 
		if ($input_recieved){	
		while ($statement1->fetch()) {
			if ($returned_first == NULL)
			{
				$returned_first = " ";
				$returned_last = " ";
				$returned_dob = " ";
			}
			echo "<tr>";
			echo "<td>" . $returned_title . '(' . $returned_year . ')' . "</td>";
			echo "<td>" . $returned_rating . "</td>";
			echo "<td>" . $returned_company . "</td>";
			echo "<td>";
		       	while ($statement3->fetch()){	
				echo $returned_first . ' ' . $returned_last . '(' . $returned_dob  . ')';
			}       	
			echo "</td>";
			echo "<td>";
			while($statement2->fetch())
			{
				echo $returned_genre . ' '; 
			}
			echo "</td>";
			echo "</tr>";
		      }
		}
	  ?>
	</tbody>
</table>
</div>

<h3>Actors in this movie:</h3>
<div class="table-responsive">
<table class="table table-bordered table condensed table-hover">
        <thead>
                <tr>
                        <td>Name</td>
			<td>Role</td>
                </tr>
        </thead>
        <tbody>
          <?php
                while ($row = $rs->fetch_assoc()) {
			$first = $row['first'];
			$last = $row['last'];
			$role = $row['role'];
			$ident = $row['id'];
			echo "<tr>";
                        echo "<td>" . "<a href='actor_info.php?identifier=" . $ident . "'>" . $first . ' ' . $last . "</a>" . "</td>";
                        echo "<td>" . $role . "</td>";
                        echo "</tr>";
                }
          ?>
        </tbody>
</table>
</div>
<?php
		$query = "SELECT name, time, rating, comment FROM Review WHERE mid = $id";
		$rs = $db->query($query);
		if (!$rs) {
			    $errmsg = $db->error; 
			     print "Query failed: $errmsg <br>"; 
		             exit(1); 
		}
		#$rs->store_result();
		
		$query2 = "SELECT AVG(rating), COUNT(rating) FROM Review WHERE mid = $id";
		$rs2 = $db->query($query2);
                if (!$rs2) {
			$errmsg = $db->error;
			print "Query failed: $errmsg <br>";
			exit(1);
		}
?>
<hr>
<h4> <b>User Reviews:</b></h4>
<?php
		while ($row2 = $rs2->fetch_assoc()){
			$avrg = $row2['AVG(rating)'];
			$count = $row2['COUNT(rating)'];
			echo "<h5>Average score for this movie is " . $avrg . "/5 based on " . $count . " people's reviews.</h5>";
		}
?>
<br>
<?php
		echo "<h5><a href='reviews.php?MovieID=" . $id  . "'>Leave your own review</a></h5>";
?>
<br>
<hr>
<h4>Comment Details Below:</h4>
<?php
		while ($row = $rs->fetch_assoc()) {
			$nm = $row['name'];
			$tm = $row['time'];
			$rtng = $row['rating'];
			$cmnt = $row['comment'];
			echo "<p><font color='red'><b>" . $nm . "</b></font> rates this movie with score <font color='blue'><b>" . $rtng . "</b></font>";
			echo " and left a review at " . $tm . "<br>comment:<br>" . $cmnt . "<br>";
		}
?>
</div>
<?php
if ($search != NULL){
	$statement1->free_result();
	$statement2->free_result();
	$statement3->free_result();
	$rs->free();
	$db->close();
}
?>
</body>
</html>
