<?php

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @var array $arResult
 */
//print (
//$arResult['additionalParameters']['VALUE'] <> ''? $arResult['additionalParameters']['VALUE'] : '&nbsp;'
//);
$arValues = json_decode(htmlspecialcharsback($arResult['additionalParameters']['VALUE']), true);
$text = '<b>' . $arValues['attrName'] .': </b>';
$text .= implode(";",array_column($arValues['attrValues'], 'name'));
echo $text;