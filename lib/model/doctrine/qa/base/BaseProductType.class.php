<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('ProductType', 'qa_core');

/**
 * BaseProductType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property text $description
 * @property string $name_slug
 * 
 * @method integer     getId()          Returns the current record's "id" value
 * @method string      getName()        Returns the current record's "name" value
 * @method text        getDescription() Returns the current record's "description" value
 * @method string      getNameSlug()    Returns the current record's "name_slug" value
 * @method ProductType setId()          Sets the current record's "id" value
 * @method ProductType setName()        Sets the current record's "name" value
 * @method ProductType setDescription() Sets the current record's "description" value
 * @method ProductType setNameSlug()    Sets the current record's "name_slug" value
 * 
 * @package    trc
 * @subpackage model
 * @author     Julian Dumez <julianx.dumez@intel.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProductType extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('product_type');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 45,
             ));
        $this->hasColumn('description', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('name_slug', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));

        $this->option('charset', 'utf8');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}