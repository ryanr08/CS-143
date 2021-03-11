<!DOCTYPE html>
<html lang="en">
<head>
<title>Internet Movie Database</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
*   box-sizing: border-box;
*   }
*
*   body {
*     margin: 0;
*     }
*
*/* Style the header */
.header {
  background-color: pink;
  padding: 20px;
  text-align: center;
}

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: black;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: lightblue;
  color: black;
}

/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 30%;
  padding: 25px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
@media screen and (max-width:600px) {
  .column {
    width: 100%;
  }
}
</style>
</head>
<body>

<div class="header">
  <h1>Welcome to Ryan's Internet Movie Database</h1>
  <p>This website is for CS143 project 2<br></p>
  <p>In this website you can obtain information about movies, actors, etc..</p>
  <p>You can also write and read reviews about movies</p>
</div>

<div class="topnav">
  <a href="search.php">Search Actor/Movie</a>
  <a href="actor_info.php?identifier=25722">Show Actor "Tom Hanks"</a>
  <a href="movie_info.php?identifier=327">Show Movie "Batman Forever"</a>
  <a href="reviews.php?MovieID=327">Add Review to "Batman Forever"</a>
</div>

<div class="row">
  <div class="column">
    <h2>Search Interface</h2>
    <p>The search interface can be accessed by clicking on "Search Actor/Movie". 
	This interface takes in a keyword and returns all items that contain that keyword. 
	This interface also supports multi word search.</p>
  </div>
  
  <div class="column">
    <h2>Browsing Content</h2>
    <p>To browse content, click on 'Show Actor "Tom Hanks"' or 'Show Movie "Batman Begins"'. 
	These pages will show actor information (name, age, dob, movie appearances). 
	You can also see all user comments about the movie "Batman Forever".</p>
  </div>
  
  <div class="column">
    <h2>Add New Content</h2>
    <p>In order to add a comment about a movie, simply click on 'Add Review to "Batman Forever"'. 
	This will bring you to a page where you can write a comment about this movie and all 
	other users will be able to see your comment!</p>
  </div>
</div>

</body>
</html>
