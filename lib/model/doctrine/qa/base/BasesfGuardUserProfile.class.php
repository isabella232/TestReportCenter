<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('sfGuardUserProfile', 'qa_core');

/**
 * BasesfGuardUserProfile
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property integer $security_level
 * @property sfGuardUser $User
 * 
 * @method integer            getId()             Returns the current record's "id" value
 * @method integer            getUserId()         Returns the current record's "user_id" value
 * @method string             getToken()          Returns the current record's "token" value
 * @method integer            getSecurityLevel()  Returns the current record's "security_level" value
 * @method sfGuardUser        getUser()           Returns the current record's "User" value
 * @method sfGuardUserProfile setId()             Sets the current record's "id" value
 * @method sfGuardUserProfile setUserId()         Sets the current record's "user_id" value
 * @method sfGuardUserProfile setToken()          Sets the current record's "token" value
 * @method sfGuardUserProfile setSecurityLevel()  Sets the current record's "security_level" value
 * @method sfGuardUserProfile setUser()           Sets the current record's "User" value
 * 
 * @package    trc
 * @subpackage model
 * @author     Julian Dumez <julianx.dumez@intel.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasesfGuardUserProfile extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sf_guard_user_profile');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('token', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('security_level', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 1,
             ));

        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
        $this->option('package', 'qa.core');
        $this->option('connection', 'qa_core');
        $this->option('detect_relations', true);
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}