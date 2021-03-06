<?php

/**
 * TestSession
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    trc
 * @subpackage model
 * @author     Julian Dumez <julianx.dumez@intel.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class TestSession extends PluginTestSession
{
	/**
	 * Delete a test session.
	 *
	 * @param $permanently TRUE to delete informations from database, FALSE to hide test session.
	 *
	 * @return TRUE
	 */
	public function delete_session($permanently = false)
	{
		if($permanently == true)
		{
			$qa_generic = sfConfig::get("app_table_qa_generic");

			$query = Doctrine_Manager::getInstance()->getCurrentConnection();
			$sql = "DELETE FROM ".$qa_generic.".test_session WHERE id = ".$this->getId();
			$result = $query->execute($sql);
		}
		else
		{
			$this->setPublished(0);
			$this->save();
		}

		return true;
	}

	public function getEnvironment()
	{
		$configuration = Doctrine_Core::getTable("Configuration")->find($this->getConfigurationId());
		$environment = Doctrine_Core::getTable("TestEnvironment")->find($configuration->getTestEnvironmentId());

		return $environment;
	}

	public function getPreviousTestSessions($projectGroupId, $projectId, $productId, $environmentId, $imageId, $limit = 1)
	{
		$qa_generic = sfConfig::get("app_table_qa_generic");

		$query = Doctrine_Manager::getInstance()->getCurrentConnection();
		$result = $query->execute("
			SELECT ts.id, ts.name, ts.status, ts.test_objective, ts.qa_summary, ts.user_id, ts.created_at, ts.editor_id, ts.updated_at, ts.project_release, ts.project_milestone,
				ts.issue_summary, ts.status, ts.published, ts.configuration_id, ts.campaign_checksum
				FROM ".$qa_generic.".test_session ts
				JOIN ".$qa_generic.".configuration c ON c.id = ts.configuration_id
				JOIN ".$qa_generic.".project_to_product ptp ON ptp.id = c.project_to_product_id
				WHERE ptp.project_group_id = ".$projectGroupId."
				AND ptp.project_id = ".$projectId."
				AND ptp.product_id = ".$productId."
				AND c.test_environment_id = ".$environmentId."
				AND c.image_id = ".$imageId."
				AND ts.created_at <= '".$this->getCreatedAt()."'
				ORDER BY ts.created_at DESC
				LIMIT ".$limit."
		");
		$array = $result->fetchAll();

		$testSessions = array();
		foreach($array as $row)
		{
			$testSession = new TestSession();
			$testSession->fromArray($row);
			array_push($testSessions, $testSession);
		}

		return $testSessions;
	}

	public function getPreviousTestSession($projectGroupId, $projectId, $productId, $environmentId, $imageId)
	{
		$qa_generic = sfConfig::get("app_table_qa_generic");

		$query = Doctrine_Manager::getInstance()->getCurrentConnection();
		$result = $query->execute("
			SELECT ts.id, ts.name, ts.status, ts.test_objective, ts.qa_summary, ts.user_id, ts.created_at, ts.editor_id, ts.updated_at, ts.project_release, ts.project_milestone,
				ts.issue_summary, ts.status, ts.published, ts.configuration_id, ts.campaign_checksum
				FROM ".$qa_generic.".test_session ts
				JOIN ".$qa_generic.".configuration c ON c.id = ts.configuration_id
				JOIN ".$qa_generic.".project_to_product ptp ON ptp.id = c.project_to_product_id
				WHERE ptp.project_group_id = ".$projectGroupId."
				AND ptp.project_id = ".$projectId."
				AND ptp.product_id = ".$productId."
				AND c.test_environment_id = ".$environmentId."
				AND c.image_id = ".$imageId."
				AND ts.created_at < '".$this->getCreatedAt()."'
				ORDER BY ts.created_at DESC
				LIMIT 1
		");

		$array = $result->fetchAll();

		if(count($array) > 0)
		{
			$testSession = new TestSession();
			$testSession->fromArray($array[0]);
			return $testSession;
		}

		return null;
	}

	public function getNextTestSession($projectGroupId, $projectId, $productId, $environmentId, $imageId)
	{
		$qa_generic = sfConfig::get("app_table_qa_generic");

		$query = Doctrine_Manager::getInstance()->getCurrentConnection();
		$result = $query->execute("
			SELECT ts.id, ts.name, ts.status, ts.test_objective, ts.qa_summary, ts.user_id, ts.created_at, ts.editor_id, ts.updated_at, ts.project_release, ts.project_milestone,
				ts.issue_summary, ts.status, ts.published, ts.configuration_id, ts.campaign_checksum
				FROM ".$qa_generic.".test_session ts
				JOIN ".$qa_generic.".configuration c ON c.id = ts.configuration_id
				JOIN ".$qa_generic.".project_to_product ptp ON ptp.id = c.project_to_product_id
				WHERE ptp.project_group_id = ".$projectGroupId."
				AND ptp.project_id = ".$projectId."
				AND ptp.product_id = ".$productId."
				AND c.test_environment_id = ".$environmentId."
				AND c.image_id = ".$imageId."
				AND ts.created_at > '".$this->getCreatedAt()."'
				ORDER BY ts.created_at ASC
				LIMIT 1
		");
		$array = $result->fetchAll();

		if(count($array) > 0)
		{
			$testSession = new TestSession();
			$testSession->fromArray($array[0]);
			return $testSession;
		}

		return null;
	}

	public function countResults()
	{
		$query = Doctrine_Core::getTable("TestResult")
			->createQuery()
			->where("test_session_id = ?", $this-getId());

		return $query->count();
	}

	public function countResultsPassed()
	{
		$query = Doctrine_Core::getTable("TestResult")
			->createQuery()
			->where("test_session_id = ?", $this->getId())
			->andWhere("decision_criteria_id = ?", -1);

		return $query->count();
	}

	public function countResultsFailed()
	{
		$query = Doctrine_Core::getTable("TestResult")
			->createQuery()
			->where("test_session_id = ?", $this->getId())
			->andWhere("decision_criteria_id = ?", -2);

		return $query->count();
	}

	public function countResultsBlocked()
	{
		$query = Doctrine_Core::getTable("TestResult")
			->createQuery()
			->where("test_session_id = ?", $this->getId())
			->andWhere("decision_criteria_id = ?", -3);

		return $query->count();
	}

	public function getResultsCounts()
	{
		$query = Doctrine_Core::getTable("TestResult")
			->createQuery()
			->select("COUNT(*) AS total")
			->addSelect("COUNT(CASE WHEN decision_criteria_id = -1 THEN decision_criteria_id END) AS tests_passed")
			->addSelect("COUNT(CASE WHEN decision_criteria_id = -2 THEN decision_criteria_id END) AS tests_failed")
			->addSelect("COUNT(CASE WHEN decision_criteria_id = -3 THEN decision_criteria_id END) AS tests_blocked")
			->where("test_session_id = ?", $this->getId());

		$result = $query->fetchArray();

		return $result[0];
	}

	public function getFeatures()
	{
		$qa_generic = sfConfig::get("app_table_qa_generic");

		$tableName = Doctrine_Core::getTable("TableName")->findOneByName("test_result");

		$query = Doctrine_Manager::getInstance()->getCurrentConnection();
		$result = $query->execute("
			SELECT *
			FROM ".$qa_generic.".complementary_tool_relation ctr
				JOIN ".$qa_generic.".test_result tr ON tr.id = ctr.table_entry_id
			WHERE ctr.table_name_id = ".$tableName->getId()."
				AND ctr.category = 1
				AND tr.test_session_id = ".$this->getId()."
			GROUP BY ctr.label
			ORDER BY ctr.label ASC
		");
		$array = $result->fetchAll();

		$features = array();
		foreach($array as $row)
		{
			$feature = new ComplementaryToolRelation();
			$feature->fromArray($row);
			array_push($features, $feature);
		}

		return $features;
	}

	public function getFeaturePercentage($complementaryToolRelationLabel)
	{
		$qa_generic = sfConfig::get("app_table_qa_generic");

		$query = Doctrine_Manager::getInstance()->getCurrentConnection();
		$result = $query->execute("
			SELECT COUNT(CASE WHEN tr.decision_criteria_id = -1 THEN tr.decision_criteria_id END)/COUNT(tr.id) * 100 AS percentage
			FROM ".$qa_generic.".test_result tr
				JOIN ".$qa_generic.".complementary_tool_relation ctr ON tr.id = ctr.table_entry_id
			WHERE ctr.label = '".$complementaryToolRelationLabel."'
				AND tr.test_session_id = ".$this->getId()."
		");
		$array = $result->fetchAll();

		return $array[0]["percentage"];
	}
}
