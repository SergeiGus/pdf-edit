<?php

require('Singleton.php');

$object = NewFpdm::getInstance(TEMPLATE_PDF);
$fpdm = $object->getFpdm();
$fields = $object->getFields();
if (!file_exists('output')) {
	$fpdm->Load($fields, true);
	$fpdm->Merge();
    mkdir('output', 0777, true);
	$fpdm->Output('F', 'output/alfa_update.pdf');
}