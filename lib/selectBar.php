<?php
//similar concept like view
//takes some start values to initialize a selectBar
//gives possibilities for further extensions (like many other things in this project)
class selectBar{

    private $properties = array();

    private $name;

    public function __construct($name, $itemsAmount, $startValue){
        $this->name = $name;
        $this->properties['name'] = $name;
        $this->properties['itemsAmount'] = $itemsAmount;
        $this->properties['startValue'] = $startValue;
    }

    public function __set($key, $value)
    {      
        if (!isset($this->$key)) {
            $this->properties[$key] = $value;
        }
    }

    public function __get($key)
    {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
    }

    public function display()
    {
        extract($this->properties);
        
        require 'selectBarHTML.php';
    }
}
?>