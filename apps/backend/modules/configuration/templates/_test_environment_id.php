(<a href="<?php echo url_for("edit_test_environment", array("id" => $configuration->getTestEnvironmentId())); ?>"><?php echo $configuration->getTestEnvironmentId(); ?></a>) <a href="<?php echo url_for("edit_test_environment", array("id" => $configuration->getTestEnvironmentId())); ?>"><?php echo Doctrine_Core::getTable("TestEnvironment")->findOneById($configuration->getTestEnvironmentId())->getName(); ?></a>