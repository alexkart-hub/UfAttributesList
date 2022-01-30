<?
function data2Log($sText, $sModule = "", $logPath = "empty", $silent = false)
{
    $path = $_SERVER["DOCUMENT_ROOT"]."/soap_log/" . $logPath ."/";
    if(!file_exists($path)){
        mkdir($path, 0777, true);
    }
    $path = $path.date("Y-m-d").".txt";
    if(!is_string($sText))
    {
        $sText = var_export($sText, true);
    }
    if (strlen($sText)>0)
    {
        ignore_user_abort(true);
        if ($fp = @fopen($path, "ab"))
        {
            if (flock($fp, LOCK_EX))
            {
                if (!$silent) {
                    @fwrite($fp, "Host: " . $_SERVER["HTTP_HOST"] . "\nDate: " . date("Y-m-d H:i:s") . "\nModule: " . $sModule . "\n" . $sText . "\n");
                    @fwrite($fp, "----------\n");
                } else {
                    @fwrite($fp, $sText . "\n");
                }
                @fflush($fp);
                @flock($fp, LOCK_UN);
                @fclose($fp);
            }
        }
        ignore_user_abort(false);

    }
}

function translit($str, $params = [])
{
    $search = SEARCH;
    $search['ru']['№'] = 'n';
    $lang = 'ru';


    $defaultParams = array(
        "max_len" => 100,
        "change_case" => 'L', // 'L' - toLower, 'U' - toUpper, false - do not change
        "replace_space" => '-',
        "replace_other" => '-',
        "delete_repeat_replace" => true,
        "safe_chars" => '',
    );
    foreach ($defaultParams as $key => $value)
        if (!array_key_exists($key, $params))
            $params[$key] = $value;

    $len = mb_strlen($str);
    $str_new = '';
    $last_chr_new = '';

    for ($i = 0; $i < $len; $i++) {
        $chr = mb_substr($str, $i, 1);

        if (preg_match("/[a-zA-Z0-9]/" . BX_UTF_PCRE_MODIFIER, $chr) || strpos($params["safe_chars"], $chr) !== false) {
            $chr_new = $chr;
        } elseif (preg_match("/\\s/" . BX_UTF_PCRE_MODIFIER, $chr)) {
            if (
                !$params["delete_repeat_replace"]
                ||
                ($i > 0 && $last_chr_new != $params["replace_space"])
            )
                $chr_new = $params["replace_space"];
            else
                $chr_new = '';
        } else {
            if (array_key_exists($chr, $search[$lang])) {
                $chr_new = $search[$lang][$chr];
            } else {
                if (
                    !$params["delete_repeat_replace"]
                    ||
                    ($i > 0 && $i != $len - 1 && $last_chr_new != $params["replace_other"])
                )
                    $chr_new = $params["replace_other"];
                else
                    $chr_new = '';
            }
        }

        if (mb_strlen($chr_new)) {
            if ($params["change_case"] == "L" || $params["change_case"] == "l")
                $chr_new = ToLower($chr_new);
            elseif ($params["change_case"] == "U" || $params["change_case"] == "u")
                $chr_new = ToUpper($chr_new);

            $str_new .= $chr_new;
            $last_chr_new = $chr_new;
        }

        if (strlen($str_new) >= $params["max_len"])
            break;
    }

    return $str_new;
}

function printr($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";

}