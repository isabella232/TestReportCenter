<?php

/**
 * ComplementaryTool filter form base class.
 *
 * @package    trc
 * @subpackage filter
 * @author     Julian Dumez <julianx.dumez@intel.com>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseComplementaryToolFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'version'     => new sfWidgetFormFilterInput(),
      'description' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'entry_link'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'        => new sfValidatorPass(array('required' => false)),
      'version'     => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'entry_link'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('complementary_tool_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ComplementaryTool';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'name'        => 'Text',
      'version'     => 'Text',
      'description' => 'Text',
      'entry_link'  => 'Text',
    );
  }
}
