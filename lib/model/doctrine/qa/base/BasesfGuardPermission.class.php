<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('sfGuardPermission', 'qa_core');

/**
 * BasesfGuardPermission
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property Doctrine_Collection $Groups
 * @property Doctrine_Collection $sfGuardGroupPermission
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $sfGuardUserPermission
 * 
 * @method integer             getId()                     Returns the current record's "id" value
 * @method string              getName()                   Returns the current record's "name" value
 * @method string              getDescription()            Returns the current record's "description" value
 * @method Doctrine_Collection getGroups()                 Returns the current record's "Groups" collection
 * @method Doctrine_Collection getSfGuardGroupPermission() Returns the current record's "sfGuardGroupPermission" collection
 * @method Doctrine_Collection getUsers()                  Returns the current record's "Users" collection
 * @method Doctrine_Collection getSfGuardUserPermission()  Returns the current record's "sfGuardUserPermission" collection
 * @method sfGuardPermission   setId()                     Sets the current record's "id" value
 * @method sfGuardPermission   setName()                   Sets the current record's "name" value
 * @method sfGuardPermission   setDescription()            Sets the current record's "description" value
 * @method sfGuardPermission   setGroups()                 Sets the current record's "Groups" collection
 * @method sfGuardPermission   setSfGuardGroupPermission() Sets the current record's "sfGuardGroupPermission" collection
 * @method sfGuardPermission   setUsers()                  Sets the current record's "Users" collection
 * @method sfGuardPermission   setSfGuardUserPermission()  Sets the current record's "sfGuardUserPermission" collection
 * 
 * @package    trc
 * @subpackage model
 * @author     Julian Dumez <julianx.dumez@intel.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasesfGuardPermission extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sf_guard_permission');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'unique' => true,
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             ));

        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
        $this->option('package', 'qa.core');
        $this->option('connection', 'qa_core');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('sfGuardGroup as Groups', array(
             'refClass' => 'sfGuardGroupPermission',
             'local' => 'permission_id',
             'foreign' => 'group_id'));

        $this->hasMany('sfGuardGroupPermission', array(
             'local' => 'id',
             'foreign' => 'permission_id'));

        $this->hasMany('sfGuardUser as Users', array(
             'refClass' => 'sfGuardUserPermission',
             'local' => 'permission_id',
             'foreign' => 'user_id'));

        $this->hasMany('sfGuardUserPermission', array(
             'local' => 'id',
             'foreign' => 'permission_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}