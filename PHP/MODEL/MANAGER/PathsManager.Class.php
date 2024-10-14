<?php

class PathsManager 
{
    public static function add(Paths $obj)
    {
        return DAO::add($obj);
    }

    public static function update(Paths $obj)
    {
        return DAO::update($obj);
    }

    public static function delete(Paths $obj)
    {
        return DAO::delete($obj);
    }

    public static function findById($id)
    {
        return DAO::select(Paths::getAttributes(), "paths", ["id" => $id])[0];
    }

    public static function getList(array $nomColonnes = null, array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
    {
        $nomColonnes = ($nomColonnes == null) ? Paths::getAttributes() : $nomColonnes;
        return DAO::select($nomColonnes, "paths", $conditions, $orderBy, $limit, $api, $debug);
    }
}
