<?php

class MovieLister {
    
    private $movieFinder;
    private $displayer;
    
    public function __construct(MovieFinder $movieFinder, Displayer $displayer)
    {
        $this->movieFinder = $movieFinder;
        $this->displayer = $displayer;
    }
    
    public function test()
    {
        $this->displayer->display($this->movieFinder->getMovies());
    }
}