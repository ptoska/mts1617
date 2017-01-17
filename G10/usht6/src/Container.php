<?php

class Container {
    
    private $dependencies;
    
    public function __construct()
    {
        $this->dependencies = [];
    }
    
    public function addImpl($interfaceArray)
    {
        foreach ($interfaceArray as $key => $value) {
            $this->dependencies[$value['interface']]=$value['class'];
        }
    }
    
    public function getInstance($class,$n)
    {
        
        $c = new ReflectionClass($class);
        
        $dep = [];
        $inst = new SaveInstance();

        foreach ($c->getConstructor()->getParameters() as $p)
        {
            $interfaceName = $p->getClass()->name;
            
            
            if (!isset($this->dependencies[$interfaceName]))
            {
                throw new Exception("The implementation for interface {$interfaceName} has not been defined.");
            }else{
                for ($i=0; $i < count($this->dependencies[$interfaceName]); $i++) { 
                    if (!class_exists($this->dependencies[$interfaceName][$i]))
                    {
                        throw new Exception("Class {$this->dependencies[$interfaceName][$i]} does not exist.");
                    }
                    else 
                    {

                        $instStatus = $inst->getInstancesStatus();
                        $hasInstanceActive = false;
                        if($instStatus->{$interfaceName}->{$this->dependencies[$interfaceName][$i]} < $n){
                            $hasInstanceActive=true;
                            $dep[$interfaceName] = new $this->dependencies[$interfaceName][$i]();
                            $instStatus->{$interfaceName}->{$this->dependencies[$interfaceName][$i]} ++;
                            $inst->saveStatus($instStatus);
                            break;
                        }
                    }
                }
            }

            if(!$hasInstanceActive){
               throw new Exception("All instances are busy to implement interface ".$interfaceName);
               return;
            }
        }

        $instance = $c->newInstanceArgs($dep);
    
        return $instance;
    }
    
}