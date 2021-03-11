DROP TABLE NobelPrizes;
DROP TABLE Laureates;


CREATE TABLE Laureates(id int PRIMARY KEY, givenName VARCHAR(40), familyName VARCHAR(40), gender VARCHAR(10), orgName VARCHAR(75), dob DATE, city VARCHAR(50), country VARCHAR(50));

CREATE TABLE NobelPrizes(id int, awardYear int, category VARCHAR(30), 
sortOrder int, portion CHAR(3), dateAwarded DATE, prizeStatus VARCHAR(25), 
motivation TEXT, prizeAmount int, afflName VARCHAR(130), afflCity VARCHAR(50), 
afflCountry VARCHAR(50), FOREIGN KEY(id) REFERENCES Laureates(id));

LOAD DATA LOCAL INFILE './Laureates.del' INTO TABLE Laureates
FIELDS TERMINATED BY ';' ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE './NobelPrizes.del' INTO TABLE NobelPrizes
FIELDS TERMINATED BY ';' ENCLOSED BY '"' LINES TERMINATED BY '\n';