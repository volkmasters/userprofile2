<?php

if ($object->xpdo) {
	/** @var modX $modx */
	$modx =& $object->xpdo;

	switch ($options[xPDOTransport::PACKAGE_ACTION]) {
		case xPDOTransport::ACTION_UPGRADE:
		case xPDOTransport::ACTION_INSTALL:
			$modelPath = $modx->getOption('userprofile2_core_path', null, $modx->getOption('core_path') . 'components/userprofile2/') . 'model/';
			$modx->addPackage('userprofile2', $modelPath);

			$manager = $modx->getManager();
			$objects = array(
				'up2Profile',
				'up2TypeFild',

			);
			foreach ($objects as $tmp) {
				$manager->createObjectContainer($tmp);
			}
			break;

		case xPDOTransport::ACTION_UNINSTALL:
			break;
	}
}
return true;