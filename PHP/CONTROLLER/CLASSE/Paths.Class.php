<?php
class Paths
{
	private $_id;
	private $_id_work;
	private $_name;
	private $_path;
	private $_type;
	private $_created_at;
	private $_updated_at;
	private static $_attributes = ['id','name','path','type','created_at','updated_at', 'id_work'];
    /**Accesseurs**/
	public function getId()
	{
		return $this->_id;
	}
	public function setId($id)
	{
		$this->_id = $id;
		return $this;
	}
	public function getId_work()
	{
		return $this->_id_work;
	}
	public function setId_work($id)
	{
		$this->_id_work = $id;
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
	public function getPath()
	{
		return $this->_path;
	}
	public function setPath($path)
	{
		$this->_path = $path;
		return $this;
	}
	public function getType()
	{
		return $this->_type;
	}
	public function setType($type)
	{
		$this->_type = $type;
		return $this;
	}
	public function getCreated_at()
	{
		return $this->_created_at;
	}
	public function setCreated_at($created_at)
	{
		$this->_created_at = $created_at;
		return $this;
	}
	public function getUpdated_at()
	{
		return $this->_updated_at;
	}
	public function setUpdated_at($updated_at)
	{
		$this->_updated_at = $updated_at;
		return $this;
	}
	public static function getAttributes()
    {
        return self::$_attributes;
    }
	/**Constructeur**/
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
            if (is_callable([$this, $method])) 
            {
                $this->$method($value === "" ? null : $value);
            }
        }
    }
	/**Autres méthodes**/

    /**
     * return true if object parameter bigger than the calling one
     *
     * @param [type] $obj
     * @return bool
     */
    public function equals_to($obj)
    {
        return true;
    }

	/**
		* Transform object in string
		*
		* @return String
    */
    public function toString()
    {
        return $this->getSite_name();
    }

    /**
     * Compare 2 objets
     * Renvoi 1 si le 1er est >
     * 0 si ils sont égaux
     * -1 si le 1er est <
     *
     * @param [type] $obj1
     * @param [type] $obj2
     * @return int
     */
    public static function compare_to($obj1, $obj2)
    {
        return 0;
    }
		

}