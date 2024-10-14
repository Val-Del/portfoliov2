<?php

class SiteInfo 
{

    /***************** Attributs ***************** */

    private $_id;
    private $_site_name;
    private $_site_description;
    private $_meta_title;
    private $_meta_description;
    private $_favicon;
    private $_logo;
    private $_social_links;
    private $_contact_email;
    private static $_attributes = [
        "id", 
        "site_name", 
        "site_description", 
        "meta_title", 
        "meta_description", 
        "favicon", 
        "logo", 
        "social_links", 
        "contact_email"
    ];

    /***************** Accesseurs ***************** */

    public function getId()
    {
        return $this->_id;
    }

    public function setId(?int $id)
    {
        $this->_id = $id;
    }

    public function getSite_name()
    {
        return $this->_site_name;
    }

    public function setSite_name(?string $site_name)
    {
        $this->_site_name = $site_name;
    }

    public function getSite_description()
    {
        return $this->_site_description;
    }

    public function setSite_description(?string $site_description)
    {
        $this->_site_description = $site_description;
    }

    public function getMeta_title()
    {
        return $this->_meta_title;
    }

    public function setMeta_title(?string $meta_title)
    {
        $this->_meta_title = $meta_title;
    }

    public function getMeta_description()
    {
        return $this->_meta_description;
    }

    public function setMeta_description(?string $meta_description)
    {
        $this->_meta_description = $meta_description;
    }

    public function getFavicon()
    {
        return $this->_favicon;
    }

    public function setFavicon(?string $favicon)
    {
        $this->_favicon = $favicon;
    }

    public function getLogo()
    {
        return $this->_logo;
    }

    public function setLogo(?string $logo)
    {
        $this->_logo = $logo;
    }

    public function getSocial_links()
    {
        return $this->_social_links;
    }

    public function setSocial_links(?string $social_links)
    {
        $this->_social_links = $social_links;
    }

    public function getContact_email()
    {
        return $this->_contact_email;
    }

    public function setContact_email(?string $contact_email)
    {
        $this->_contact_email = $contact_email;
    }

    public static function getAttributes()
    {
        return self::$_attributes;
    }

    /***************** Constructeur ***************** */

    public function __construct(array $options = [])
    {
        if (!empty($options)) 
        {
            $this->hydrate($options);
        }
    }

    public function hydrate($data)
    {
        foreach ($data as $key => $value)
        {
            $method = "set" . ucfirst($key); 
            if (is_callable([$this, $method])) 
            {
                $this->$method($value === "" ? null : $value);
            }
        }
    }

    /***************** Autres Méthodes ***************** */

    /**
    * Transforme l'objet en chaine de caractères
    *
    * @return String
    */
    public function toString()
    {
        return $this->getSite_name();
    }

}
