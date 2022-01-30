<?php

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\UserField\HtmlBuilder;

/**
 * @var StringUfComponent $component
 * @var array $arResult
 * @var HtmlBuilder $htmlBuilder
 */

$htmlBuilder = $this->getComponent()->getHtmlBuilder();

//if($arResult['fieldValues']['tag'] === 'input')
//{
//	?>
<!--	<input-->
<!--		--><?//= $htmlBuilder->buildTagAttributes($arResult['fieldValues']['attrList']) ?>
<!--		value="--><?//= $arResult['additionalParameters']['VALUE'] ?><!--"-->
<!--	>-->
<!--	--><?php
//}
//else
//{
//	?>
<!--	<textarea-->
<!--		--><?//= $htmlBuilder->buildTagAttributes($arResult['fieldValues']['attrList']) ?>
<!--	>--><?//= $arResult['additionalParameters']['VALUE'] ?><!--</textarea>-->
<!--	--><?php
//}

//if($arResult['fieldValues']['tag'] === 'input')
//{
    $arValues = json_decode(htmlspecialcharsback($arResult['additionalParameters']['VALUE']), true);
    $fieldName = $arResult['fieldValues']['attrList']['name'];
    $arResult['fieldValues']['attrList']['name'] = $fieldName . '[attrName]';
    ?>
    <input
        <?= $htmlBuilder->buildTagAttributes($arResult['fieldValues']['attrList']) ?>
            value="<?= $arValues['attrName'] ?>"
    >
    <? $arResult['fieldValues']['attrList']['name'] = $fieldName . '[attrValues]'; ?>
    <input
        <?= $htmlBuilder->buildTagAttributes($arResult['fieldValues']['attrList']) ?>
            value="<?= implode(";",array_column($arValues['attrValues'], 'name')); ?>"
    >
    <?php
//}
//else
//{
//    ?>
<!--    <textarea-->
<!--		--><?//= $htmlBuilder->buildTagAttributes($arResult['fieldValues']['attrList']) ?>
<!--	>--><?//= $arResult['additionalParameters']['VALUE'] ?><!--</textarea>-->
<!--    --><?php
//}