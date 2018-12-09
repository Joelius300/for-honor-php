<link href="/css/select.css" rel="stylesheet" type="text/css">
<script src="/js/select.js"></script> 

<?php
class select{

    private $properties = array();

    public function __construct($name, $itemsAmount, $startValue){
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
        
        require 'selectHTML.php';
    }
}
?>