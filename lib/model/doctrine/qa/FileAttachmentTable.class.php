<?php

/**
 * FileAttachmentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class FileAttachmentTable extends PluginFileAttachmentTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object FileAttachmentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('FileAttachment');
    }
    
    /**
     * Delete a file attachment entry relying on its id.
     *
     * @param $fileAttachmentId The file attachment identifier.
     * @param $conn             The current connection.
     *
     */
    public function deleteFileAttachmentById($fileAttachmentId, $conn)
    {
    	$qa_generic = sfConfig::get("app_table_qa_generic");
    	
	$query = "DELETE fa FROM ".$qa_generic.".file_attachment AS fa
    			WHERE fa.id = ".$fileAttachmentId;
    	$conn->execute($query);
    }
}