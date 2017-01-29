<?php

final class Stack implements \Countable
{
    private $subjects = array();

    public function push($subject)
    {
        $this->subjects[] = $subject;
    }

    public function pop()
    {
    	$index = count($this->subjects) - 1;
    	unset($this->subjects[$index]);
    }
    public function top()
    {
    	$index = count($this->subjects) - 1;
    	return $this->subjects[$index];
    }
    public function count()
    {
        return count($this->subjects);
    }
}