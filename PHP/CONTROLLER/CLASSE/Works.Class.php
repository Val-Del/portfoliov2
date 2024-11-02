<?php
class Works
{
    private $_id;
    private $_name;
    private $_content;
    private $_description;
    private $_thumbnail;
    private $_visible;
    private $_display_order;
    private static $_attributes = ['id', 'name', 'description', 'thumbnail', 'visible', 'display_order', 'content'];

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
    public function getContent()
    {
        return $this->_content;
    }
    public function setContent($content)
    {
        $this->_content = $content;
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

    public function getDescription()
    {
        return $this->_description;
    }
    public function setDescription($description)
    {
        $this->_description = $description;
        return $this;
    }

    public function getThumbnail()
    {
        return $this->_thumbnail;
    }
    public function setThumbnail($thumbnail)
    {
        $this->_thumbnail = $thumbnail;
        return $this;
    }

    public function getVisible()
    {
        return $this->_visible;
    }
    public function setVisible($visible)
    {
        $this->_visible = $visible;
        return $this;
    }

    public function getDisplay_order()
    {
        return $this->_display_order;
    }
    public function setDisplay_order($display_order)
    {
        $this->_display_order = $display_order;
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
    public function displayAsCard() {
        echo '<a href="?page=WorkDetails&id=' . $this->getId() . '" class="card">';
        echo '<img src="IMG/' . $this->getThumbnail() . '" alt="Thumbnail for ' . $this->getName() . '">';
        echo '<div class="overlay">';
        echo '<h4>' . $this->getName() . '</h4>';

        // Fetch and display associated technologies
        $techs = Work_technologiesManager::findTechnologiesByWorkId($this->getId());
        if ($techs) {
            echo '<p class="technologies">';
            $techNames = array_map(fn($techItem) => $techItem['name'], $techs);
            echo implode(', ', $techNames);
            echo '</p>';
        }
        echo '</div>';
        echo '</a>';
    }
 }
