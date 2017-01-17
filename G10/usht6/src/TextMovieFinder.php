<?php

class TextMovieFinder implements MovieFinder {
    
    public function getMovies()
    {
        return file(__DIR__ . "/../data/movies.txt");
    }

    
}