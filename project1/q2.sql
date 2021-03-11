SELECT first, last 
FROM Actor, MovieActor, Movie 
WHERE ((Actor.id = MovieActor.aid) AND (MovieActor.mid = Movie.id) AND Movie.title = 'Die Another Day');
