<?php

/**
 * ComplementaryToolRelationTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ComplementaryToolRelationTable extends PluginComplementaryToolRelationTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object ComplementaryToolRelationTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('ComplementaryToolRelation');
    }
}