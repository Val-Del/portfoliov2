<?php

class SiteInfoManager 
{
    public static function add(SiteInfo $obj)
    {
        return DAO::add($obj);
    }

    public static function update(SiteInfo $obj)
    {
        return DAO::update($obj);
    }

    public static function delete(SiteInfo $obj)
    {
        return DAO::delete($obj);
    }

    public static function findById($id)
    {
        return DAO::select(SiteInfo::getAttributes(), "siteinfo", ["id" => $id])[0];
    }

    public static function getList(array $nomColonnes = null, array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
    {
        $nomColonnes = ($nomColonnes == null) ? SiteInfo::getAttributes() : $nomColonnes;
        return DAO::select($nomColonnes, "siteinfo", $conditions, $orderBy, $limit, $api, $debug);
    }
}
