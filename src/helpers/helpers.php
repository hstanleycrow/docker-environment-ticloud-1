<?php
function redirect(string $to): void
{
    header("Location: $to");
    exit;
}
function isLogged()
{
    return isset($_SESSION['isLogged']) && $_SESSION['isLogged'] === true;
}

function middlewareAuth(): void
{
    if (!isLogged()) :
        redirect('/login');
        exit();
    endif;
}
function pd(?string $text): void
{
    die($text);
}
function vdd(mixed $var): void
{
    var_dump($var);
    die();
}
function prd(?array $arr): void
{
    echo "<pre>";
    print_r($arr);
    die();
}
function between($value, $min, $max): bool
{
    return $value >= $min && $value <= $max;
}

function slug($string)
{
    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä', '&aacute;', '&Aacute;'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'a', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë', '&eacute;', '&Eacute;'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'e', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î', '&iacute;', '&Iacute;'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'i', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô', '&oacute;', '&Oacute;'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'o', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü', '&uacute;', '&Uacute;'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'u', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç', '&ntilde;', '&Ntilde;'),
        array('n', 'N', 'c', 'C', 'n', 'N'),
        $string
    );
    #return strtolower($string);
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array(
            "\\", "¨", "º", "-", "~",
            "#", "@", "|", "!", "\"",
            "$", "%", "&", "/",
            "(", ")", "?", "'", "¡",
            "¿", "[", "^", "`", "]",
            "+", "}", "{", "¨", "´",
            ">", "<", ";", ",", ":",

        ),
        '',
        $string
    );
    $string = str_replace(" ", "-", $string);

    return strtolower($string);
}

/***************** HELPERS LOCALES ******************** */
function normalizeID(string $docNumber): string
{
    return ltrim(str_replace("-", "", $docNumber), '0');
}
