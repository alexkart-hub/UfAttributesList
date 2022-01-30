<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Component\BaseUfComponent;

/**
 * Class UfProperties
 */
class UfAttributesListComponent extends BaseUfComponent
{
    protected static function getUserTypeId(): string
    {
        return CUserTypeAttributesList::USER_TYPE_ID;
    }
}