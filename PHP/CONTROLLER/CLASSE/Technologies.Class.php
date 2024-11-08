<?php
class Technologies
{
    private $_id;
    private $_name;
    private static $_attributes = ['id', 'name'];

    /** Accessors **/
    public function getId()
    {
        return $this->_id;
    }
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public static function getAttributes()
    {
        return self::$_attributes;
    }

    /** Constructor **/
    public function __construct(array $options = [])
    {
        if (!empty($options)) {
            $this->hydrate($options);
        }
    }
    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (is_callable([$this, $method])) {
                $this->$method($value === "" ? null : $value);
            }
        }
    }
 }
