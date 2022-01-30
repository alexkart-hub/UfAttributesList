<?php
$eventManager = Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('main', 'OnUserTypeBuildList', ['CUserTypeAttributesList', 'getUserTypeDescription']);
