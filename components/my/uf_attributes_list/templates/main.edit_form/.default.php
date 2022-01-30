<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/**
 * @var StringUfComponent $component
 * @var array $arResult
 */

$component = $this->getComponent();
?>
<table id='table_<?= $arResult['userField']['FIELD_NAME'] ?>'>
    <?php
    $number = 0;
    // Вытаскиваем заголовки полей из настроек
    $titleAttrName = $arResult['userField']['SETTINGS']['DEFAULT_VALUE']['TITLE']['attrName'];
    $titleAttrValues = $arResult['userField']['SETTINGS']['DEFAULT_VALUE']['TITLE']['attrValues'];
    // Если для заголовков полей не заданы значения, устанавливаем эти значения
    $titleAttrName = !empty($titleAttrName) ? $titleAttrName : 'Наименование';
    $titleAttrValues = !empty($titleAttrValues) ? $titleAttrValues : 'Значение';

    //В этом цикле отображаем значения
    foreach ($arResult['value'] as $item) {
        if (!empty($item['attrList']['value'])) {
            $value = json_decode(htmlspecialcharsback($item['attrList']['value']), true);
        } else {
            $value = json_decode(htmlspecialcharsback($item['value']), true);
        }
        $attrValues_name = implode(";", array_column($value['attrValues'], 'name'))
            ?? (string)$arResult['userField']['SETTINGS']['DEFAULT_VALUE']['attrValues'];
        $attrValues_code = implode(";", array_column($value['attrValues'], 'code'));
        ?>
        <tr>
            <td>
                <div style="display: inline-block; margin-left: 12px;">
                    <label><?=$titleAttrName?>:&nbsp;</label>
                    <input type="text" name="<?= $arResult['userField']['FIELD_NAME'] ?>[<?= $number ?>][attrName]"
                           value=<?= $value['attrName'] ?? $arResult['userField']['SETTINGS']['DEFAULT_VALUE']['attrName']?>>
                </div>&nbsp;
                <div style="display: inline-block">
                    <label><?=$titleAttrValues?>:&nbsp;</label>
                    <input type="text" name="<?= $arResult['userField']['FIELD_NAME'] ?>[<?= $number ?>][attrValues]"
                           <?= $attrValues_code ? 'code=' . $attrValues_code : ''?>
                           value=<?= $attrValues_name ?? '' ?>>
                </div>
            </td>
        </tr>
        <?
        $number++;
    }
    // Для множественного свойства добавим под значениями пустое поле для добавления
    if ((!empty($arResult['value'][0]['attrList']['value']) && $arResult['userField']['MULTIPLE'] == 'Y')
    || !empty($arResult['value'][0]['value'])) {
        $devaultName = $arResult['userField']['SETTINGS']['DEFAULT_VALUE']['attrName'] ?? '';
        $devaultValue = $arResult['userField']['SETTINGS']['DEFAULT_VALUE']['attrValues'] ?? '';
        ?>
        <tr>
            <td>
                <div style="display: inline-block; margin-left: 12px;">
                    <label><?=$titleAttrName?>:&nbsp;</label>
                    <input type="text" name="<?= $arResult['userField']['FIELD_NAME'] ?>[<?= $number ?>][attrName]"
                           value=<?= $devaultName ?>>
                </div>&nbsp;
                <div style="display: inline-block">
                    <label><?=$titleAttrValues?>:&nbsp;</label>
                    <input type="text" name="<?= $arResult['userField']['FIELD_NAME'] ?>[<?= $number ?>][attrValues]"
                           value=<?= $devaultValue ?>>
                </div>
            </td>
        </tr>
        <?
        $number++;
    }
    // Если задан параметр "Количество строчек поля ввода" больше 1 и свойство является множественным,
    // добавляем необходимое количество полей для ввода
    if ($arResult['userField']['SETTINGS']['ROWS'] > 1 && $arResult['userField']['MULTIPLE'] == 'Y') {
        while ($number < $arResult['userField']['SETTINGS']['ROWS']) {
            ?>
            <tr>
                <td>
                    <div style="display: inline-block; margin-left: 12px;">
                        <label><?=$titleAttrName?>:&nbsp;</label>
                        <input type="text" name="<?= $arResult['userField']['FIELD_NAME'] ?>[<?= $number ?>][attrName]"
                               value="">
                    </div>&nbsp;
                    <div style="display: inline-block">
                        <label><?=$titleAttrValues?>:&nbsp;</label>
                        <input type="text"
                               name="<?= $arResult['userField']['FIELD_NAME'] ?>[<?= $number ?>][attrValues]"
                               value="">
                    </div>
                </td>
            </tr>

            <?
            $number++;
        }
    }
    // Кнопка "Добавить"
    if ($arResult['userField']['MULTIPLE'] === 'Y') {
        $rowClass = '';
        $fieldNameX = str_replace('_', 'x', $arResult['userField']['FIELD_NAME']);
        ?>
        <tr>
            <td style='padding-top: 6px;'>
                <input
                        type="button"
                        value="<?= Loc::getMessage('USER_TYPE_PROP_ADD') ?>"
                        onClick="
						addNewRow(
							'table_<?= $arResult['userField']['FIELD_NAME'] ?>',
							'<?= $fieldNameX ?>|<?= $arResult['userField']['FIELD_NAME'] ?>|<?= $arResult['userField']['FIELD_NAME'] ?>_old_id'
						)"
                >
            </td>
        </tr>
    <? } ?>
</table>