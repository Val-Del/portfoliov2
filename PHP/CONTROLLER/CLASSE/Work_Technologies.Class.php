<?php
class Work_technologies
{
    private $_work_id;
    private $_technology_id;
    private static $_attributes = ['work_id', 'technology_id'];

    /** Accessors **/
    public function getWork_id()
    {
        return $this->_work_id;
    }
    public function setWork_id($work_id)
    {
        $this->_work_id = $work_id;
        return $this;
    }

    public function getTechnology_id()
    {
        return $this->_technology_id;
    }
    public function setTechnology_id($technology_id)
    {
        $this->_technology_id = $technology_id;
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
