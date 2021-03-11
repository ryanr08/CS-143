CREATE TABLE Movie(id int PRIMARY KEY, title VARCHAR(100), year int, rating VARCHAR(10), company VARCHAR(50));

CREATE TABLE Actor(id int PRIMARY KEY, last VARCHAR(20), first VARCHAR(20), sex VARCHAR(6), dob DATE, dod DATE);

CREATE TABLE Director(id int PRIMARY KEY, last VARCHAR(20), first VARCHAR(20), dob DATE, dod DATE);

CREATE TABLE MovieGenre(mid int, genre VARCHAR(20));

CREATE TABLE MovieDirector(mid int, did int);

CREATE TABLE MovieActor(mid int, aid int, role VARCHAR(50));

CREATE TABLE Review(name VARCHAR(20), time DATETIME, mid int, rating int, comment TEXT);
