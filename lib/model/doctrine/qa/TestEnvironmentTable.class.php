<?php

/**
 * TestEnvironmentTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TestEnvironmentTable extends PluginTestEnvironmentTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object TestEnvironmentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('TestEnvironment');
    }

    /**
     * Check if given slug does not already exist in the database.
     *
     * @param string $slug The slug.
     * @param int $id The identifier of the object if it already exists in the database.
     *
     * @return boolean TRUE if the slug exists, FALSE otherwise.
     */
    public function checkSlug($slug, $id=null)
    {
		$qa_generic = sfConfig::get("app_table_qa_generic");

		$query = "SELECT te.id FROM ".$qa_generic.".test_environment te WHERE te.name_slug = '".$slug."'";
        if(!is_null($id))
            $query .= " AND te.id != '".$id."'";
		$result = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->rowCount();

		if($result > 0)
			return true;

		return false;
    }

    /**
     * Check if an environment exist.
     *
     * @param array $array The values of the environment to search.
     *
     * @return array An associative array with values of the environment if it exist, NULL otherwise.
     */
    public function findByArray($array)
    {
		$qa_generic = sfConfig::get("app_table_qa_generic");

		$query = "SELECT te.id, te.name, te.description, te.cpu, te.board, te.gpu, te.other_hardware, te.name_slug
			FROM ".$qa_generic.".test_environment te
			WHERE te.name = '".addslashes($array["name"])."'
				AND (te.description = '".addslashes($array["description"])."' OR te.description IS NULL)
				AND (te.cpu = '".addslashes($array["cpu"])."' OR te.cpu IS NULL)
				AND (te.board = '".addslashes($array["board"])."' OR te.board IS NULL)
				AND (te.other_hardware = '".addslashes($array["other_hardware"])."' OR te.other_hardware IS NULL)";
		$result = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch(PDO::FETCH_ASSOC);

		if(!empty($result))
			return $result;

		return null;
    }

    /**
     * Get the three last used environments by default.
     *
     * @param number $limit The number of environments to retrieve.
	 *
     * @return array An associative array with values of retrieved environments, or NULL.
     */
    public function getLastEnvironments($limit = 3)
    {
		$qa_generic = sfConfig::get("app_table_qa_generic");

		$query = "SELECT DISTINCT te.id, te.name, te.description, te.cpu, te.board, te.gpu, te.other_hardware, te.name_slug
			FROM ".$qa_generic.".test_environment te
				JOIN ".$qa_generic.".configuration c ON c.test_environment_id = te.id
				JOIN ".$qa_generic.".test_session ts ON ts.configuration_id = c.id
			WHERE ts.created_at <= '".date("Y-m-d H:i:s")."'
			GROUP BY te.id
			ORDER BY ts.created_at DESC
			LIMIT ".$limit;
    	$result = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll(PDO::FETCH_ASSOC);

		return $result;
    }

	/**
	 * Get environment identified by given slug.
	 *
	 * @param string $slug The slug.
	 *
     * @return array An associative array with values of the environment, or NULL.
	 */
    public function getEnvironmentBySlug($slug)
    {
		$qa_generic = sfConfig::get("app_table_qa_generic");

    	$query = "SELECT te.id, te.name, te.description, te.cpu, te.board, te.gpu, te.other_hardware, te.name_slug
			FROM ".$qa_generic.".test_environment te
			WHERE te.name_slug = '".$slug."'";
    	$result = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch(PDO::FETCH_ASSOC);

		if(!empty($result))
			return $result;

		return null;
    }










    /**
     * @deprecated
     * Get an environment by its slug name.
     *
     * @param slug The slugified name.
     *
     * @return The first item of the collection.
     */
    public function getTestEnvironmentBySlug($slug)
    {
    	$query = Doctrine_Core::getTable("TestEnvironment")
	    	->createQuery("te")
	    	->where("LOWER(REPLACE(REPLACE(REPLACE(te.name, '.', '-'), ' ' , '-'), '_' , '-')) = ?", $slug);

    	return $query->fetchOne();
    }
}