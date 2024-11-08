<?php

class Work_technologiesManager
{
    public static function add(Work_technologies $obj)
    {
        return DAO::add($obj);
    }

    public static function update(Work_technologies $obj)
    {
        return DAO::update($obj);
    }

    public static function delete(Work_technologies $obj)
    {
        return DAO::delete($obj);
    }

    public static function findById($id)
    {
        return DAO::select(Work_technologies::getAttributes(), "work_technologies", ["technology_id" => $id])[0];
    }


  public static function findTechnologiesByWorkId($workId) {
    // Columns we want to select (from the technologies table)
    $columns = ['technologies.id', 'technologies.name'];
    
    // Define the JOIN between work_technologies and technologies
    $joins = [
        'technologies' => 'technologies.id = work_technologies.technology_id'
    ];
    
    // Conditions for the query
    $conditions = [
        'work_technologies.work_id' => $workId
    ];
    
    // Use the secure selectWithJoin method to execute the query
    return DAO::selectWithJoin($columns, 'work_technologies', $joins, $conditions);
    }

    
    

    public static function getList(array $nomColonnes = null, array $conditions = null, string $orderBy = null, string $limit = null, bool $api = false, bool $debug = false)
    {
        $nomColonnes = ($nomColonnes == null) ? Work_technologies::getAttributes() : $nomColonnes;
        return DAO::select($nomColonnes, "work_technologies", $conditions, $orderBy, $limit, $api, $debug);
    }
}
