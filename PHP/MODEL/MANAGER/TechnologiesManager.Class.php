<?php

class TechnologiesManager
{
    public static function add(Technologies $obj)
    {
        return DAO::add($obj);
    }

    public static function update(Technologies $obj)
    {
        return DAO::update($obj);
    }

    public static function delete(Technologies $obj)
    {
        return DAO::delete($obj);
    }

    public static function findById($id)
    {
        return DAO::select(Technologies::getAttributes(), "technologies", ["id" => $id])[0];
    }

    public static function getList(array $nomColonnes = null, array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
    {
        $nomColonnes = ($nomColonnes == null) ? Technologies::getAttributes() : $nomColonnes;
        return DAO::select($nomColonnes, "technologies", $conditions, $orderBy, $limit, $api, $debug);
    }
}
