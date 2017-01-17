<?php

class JsonMovieFinder implements MovieFinder {
	
    public function getMovies()
    {
        return json_decode(file_get_contents(__DIR__ . "/../data/movies.json"));
    }
}