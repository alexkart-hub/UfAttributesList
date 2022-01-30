<?php

class CUserTypeAttributesList extends Bitrix\Main\UserField\Types\StringType
{
    const
        USER_TYPE_ID = 'AttributesList',
        USER_DESCRIPTION = 'Список аттрибутов',
        RENDER_COMPONENT = 'my:uf_attributes_list';

    public static function getDescription(): array
    {
        return array(
            "DESCRIPTION" => static::USER_DESCRIPTION,
            "USE_FIELD_COMPONENT" => true // component name my:uf_attributes_list
        );
    }

    public function OnBeforeSave($arUserField, $value)
    {
        data2Log($value);
        if (empty($value['attrValues']) || empty($value['attrName'])) {
            $value = $value[0];
            if (empty($value['attrValues']) || empty($value['attrName'])) {
                return false;
            }
        }
        $code = translit($value['attrValues'], ["replace_space" => "-", "replace_other" => "-", "safe_chars" => ';']);
        $valuesArray = explode(';', $value['attrValues']);
        $codesArray = explode(';', $code);
        $value['attrValues'] = array_map(function ($code, $value) {
            return [
                'name' => trim($value, ' -'),
                'code' => trim($code, ' -'),
            ];
        }, $codesArray, $valuesArray);
        $value = json_encode($value);

        return $value;
    }
}