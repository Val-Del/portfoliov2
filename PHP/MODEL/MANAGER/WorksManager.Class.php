<?php

class WorksManager
{
    public static function add(Works $obj)
    {
        return DAO::add($obj);
    }

    public static function update(Works $obj)
    {
        return DAO::update($obj);
    }

    public static function delete(Works $obj)
    {
        return DAO::delete($obj);
    }

    public static function findById($id)
    {
        return DAO::select(Works::getAttributes(), "works", ["id" => $id])[0];
    }

    public static function getList(array $nomColonnes = null, array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
    {
        $nomColonnes = ($nomColonnes == null) ? Works::getAttributes() : $nomColonnes;
        return DAO::select($nomColonnes, "works", $conditions, $orderBy, $limit, $api, $debug);
    }
}
