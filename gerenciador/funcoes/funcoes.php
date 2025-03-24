<?php
header('Content-type: text/html; charset=UTF-8');
if (basename($_SERVER["PHP_SELF"]) == "funcoes.php") {
    die("Ops... você não pode fazer isso!");
}


ini_set('max_execution_time', 80);
ini_set('mysql.connect_timeout', 6000);
ini_set('default_socket_timeout', 6000);
setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

require_once "init.php";
require_once "pd-acs.php";


//SQL Injection
$phpself = $_SERVER['PHP_SELF'];
if (!empty($_SERVER['QUERY_STRING'])) {
    $IncEvil = $phpself .= "?" . $_SERVER['QUERY_STRING'];
}


function anti_injection($Value)
{
    if (!empty($Value)) {
        $Value = str_replace("'", '&#39;', $Value);
        try {
            if (preg_match('{/(\%27)|(\')|(\-\-)|(\%23)|(#)/ix}', $Value))
                throw new Exception("Tentativa de SQL Injection simples");
            else if (preg_match('{/((\%3D)|(=))[^\n]*((\%27)|(\')|(\-\-)|(\%3B)|(;))/i}', $Value))
                throw new Exception("Tentativa de SQL Injection por meta-characters");
            else if (preg_match('{/\w*((\%27)|(\'))((\%6F)|o|(\%4F))((\%72)|r|(\%52))/ix}', $Value))
                throw new Exception("Tentativa de SQL Injection normal");
            else if (preg_match('{/exec(\s|\+)+(s|x)p\w+/ix}', $Value))
                throw new Exception("Tentativa de SQL Injection com execução de core");
            else if (preg_match('{/((\%3C)|<)((\%2F)|\/)*[a-z0-9\%]+((\%3E)|>)/ix}', $Value))
                throw new Exception("Tentativa de XSS simples");
            else if (preg_match('{/((\%3C)|<)((\%69)|i|(\%49))((\%6D)|m|(\%4D))((\%67)|g|(\%47))[^\n]+((\%3E)|>)/I}', $Value))
                throw new Exception("Tentativa de XSS");
            else if (preg_match('{/((\%3C)|<)[^\n]+((\%3E)|>)/I}', $Value))
                throw new Exception("Tentativa de XSS");
        } catch (Exception $e) {
            unset($Value);
            $Messeger = "[" . date("d/m/Y H:i:s") . "] Foi detectado uma tentativa de invasão  pelo IP " . $_SERVER['REMOTE_ADDR'] . ": " . $e->getMessage() . "\r\n";
            file_put_contents('log_seguranca.log', $Messeger, FILE_APPEND);
        }

        return addslashes($Value);
    } else {
        return "";
    }
}





function url_amigavel($str)
{
    $str = trim($str);
    $str = strtolower($str);
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    $str = preg_replace('/[ñ]/ui', 'n', $str);
    // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
    $str = preg_replace('/[^a-z0-9]/i', '-', $str);
    $str = preg_replace('/_+/', '-', $str);
    $str = preg_replace('/-----+/', '-', $str);
    $str = preg_replace('/----+/', '-', $str);
    $str = preg_replace('/---+/', '-', $str);
    $str = preg_replace('/--+/', '-', $str);
    return $str;
}



function cpf($vl)
{
    $cpf = substr_replace($vl, '.', 3, 0);
    $cpf = substr_replace($cpf, '.', 7, 0);
    $cpf = substr_replace($cpf, '-', -2, 0);
    return $cpf;
}


function formataCep($cep)
{
    $cep_ini = substr($cep, 0, 5);
    $cep_fim = substr($cep, 5);
    return $cep_ini . '-' . $cep_fim;
}


function convertem($term, $tp)
{

    if ($tp == "1") $palavra = strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    elseif ($tp == "0") $palavra = strtr(strtolower($term), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
    return $palavra;
}



function cortaTexto($string, $numChars)
{
    if (strlen($string) > $numChars) {

        $chars = 0;
        $tag = 0;
        $newString = "";
        for ($num = 0; $chars < $numChars; $num++) {
            if ($string[$num] == "<") $tag++;
            else if ($string[$num] == ">") $tag = 0;
            else if ($tag == 0) {
                $chars++;
            }
            $newString .= $string[$num];
            $pos = strrpos($newString, " ");
        }
    } else {
        $newString = $string;
        $pos = strrpos($newString, " ");
    }
    return substr($newString, 0, $pos) . "...";
}




function quebra($textquebra)
{
    $textquebra = str_replace("<br />", "", $textquebra);
    $textquebra = str_replace("<br>", "", $textquebra);
    return $textquebra;
}


function retiraTagHTML($textoComTag)
{
    return strip_tags($textoComTag, '<(.*?)>');
}


function url_encode($string)
{
    if ((isset($string)) && (is_string($string))) {
        $enc_string = base64_encode($string);
        $enc_string = str_replace("=", "", $enc_string);
        $enc_string = strrev($enc_string);
        $md5 = md5($string);
        $enc_string = substr($md5, 0, 3) . $enc_string . substr($md5, -3);
    } else {
        $enc_string = "";
    }
    return $enc_string;
}

function url_decode($string)
{
    $des_string = '';
    if ((isset($string)) && (is_string($string))) {
        $ini = substr($string, 0, 3);
        $end = substr($string, -3);
        $des_string = substr($string, 0, -3);
        $des_string = substr($des_string, 3);
        $des_string = strrev($des_string);
        $des_string = base64_decode($des_string);
        $md5 = md5($des_string);
        $ver = substr($md5, 0, 3) . substr($md5, -3);
    }
    return $des_string;
}


/*criptografia*/

//encriptar
$key = "abeus";

function cripty($text)
{

    $iv_size = 0;
    $iv = 0;
    $iv_size = mcrypt_get_iv_size(MCRYPT_XTEA, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $enc = mcrypt_encrypt(MCRYPT_XTEA, $key, $text, MCRYPT_MODE_ECB, $iv);
    return $enc;
}


function descripty($text)
{

    $iv_size = 0;
    $iv = 0;
    $iv_size = mcrypt_get_iv_size(MCRYPT_XTEA, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_decrypt(MCRYPT_XTEA, $key, $text, MCRYPT_MODE_ECB, $iv);
    return rtrim($crypttext, "\0");
}


function ByteSize($bytes)
{

    $size = $bytes / 1024;

    if ($size < 1024) {

        $size = number_format($size, 2);
        $size .= ' KB';
    } else {

        if ($size / 1024 < 1024) {

            $size = number_format($size / 1024, 2);
            $size .= ' MB';
        } else if ($size / 1024 / 1024 < 1024) {

            $size = number_format($size / 1024 / 1024, 2);
            $size .= ' GB';
        }
    }
    return $size;
}


//converter para minusculo
function minusculo($convert)
{
    return strtr(strtolower($convert), "ÁÉÍÓÚÀÈÌÒÙÃÕÄËÏÖÜÂÊÎÔÛÇáéíóúàèìòùãõäëïöüâêîôûç ", "aeiouaeiouaoaeiouaeioucaeiouaeiouaoaeiouaeiouc+");
}


function dt_br_mysql($dt, $separador)
{
    if ($dt == "00000000") {
        $dt = '01' . $separador . '01' . $separador . '1900';
    }
    if ($dt == "") {
        $dt = '01' . $separador . '01' . $separador . '1900';
    }

    $dt_def = explode($separador, $dt);
    return $dt_def['2'] . '-' . $dt_def['1'] . '-' . $dt_def['0'];
}


function dth_br_mysql($dt, $separador)
{
    if ($dt == "00000000") {
        $dt = '01' . $separador . '01' . $separador . '1900 00:00:00';
    }
    if ($dt == "") {
        $dt = '01' . $separador . '01' . $separador . '1900 00:00:00';
    }

    $dt_def1 = explode(' ', $dt);
    if (isset($dt_def1[1])) {
        $hr = $dt_def1[1];
    } else {
        $hr = '00:00';
    }

    $dt_def = explode($separador, $dt_def1[0]);
    return $dt_def['2'] . '-' . $dt_def['1'] . '-' . $dt_def['0'] . ' ' . $hr;
}


/* Específico */
function dt_mysql_br($dt, $separador)
{
    if ($dt == '0000-00-00 00:00:00') {
        return '';
    } elseif ($dt == '0000-00-00') {
        return '';
    } elseif ($dt == '1900-01-01') {
        return '';
    } else {
        if ($dt == "") {
            $dt = '0000-00-00 00:00:00';
        }
        $dt_def = explode(' ', $dt);
        $dt_fim = explode('-', $dt_def['0']);
        return $dt_fim['2'] . $separador . $dt_fim['1'] . $separador . $dt_fim['0'];
    }
}


/* Específico */
function dth_mysql_br($dt, $separador)
{
    if ($dt == '0000-00-00 00:00:00') {
        return '';
    } elseif ($dt == '0000-00-00') {
        return '';
    } elseif ($dt == '1900-01-01') {
        return '';
    } else {
        if ($dt == "") {
            $dt = '0000-00-00 00:00:00';
        }
        $dt_def1 = explode(' ', $dt);
        if (isset($dt_def1[1])) {
            $hr = $dt_def1[1];
        } else {
            $hr = '00:00';
        }

        $dt_def = explode('-', $dt_def1['0']);
        return $dt_def['2'] . $separador . $dt_def['1'] . $separador . $dt_def['0'] . ' ' . $hr;
    }
}


function shttp($linkhttp)
{
    $linkhttp = str_replace("http://", "", $linkhttp);
    $linkhttp = str_replace("https://", "", $linkhttp);
    return $linkhttp;
}



function remove_acentos($string)
{
    $string = preg_replace("/[áàâãä]/", "a", $string);
    $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
    $string = preg_replace("/[éèê]/", "e", $string);
    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
    $string = preg_replace("/[íì]/", "i", $string);
    $string = preg_replace("/[ÍÌ]/", "I", $string);
    $string = preg_replace("/[óòôõö]/", "o", $string);
    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
    $string = preg_replace("/[úùü]/", "u", $string);
    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
    $string = preg_replace("/ç/", "c", $string);
    $string = preg_replace("/Ç/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`@]/", "", $string);
    return $string;
}




/*defino para mostrar todos os erros e desfaço o efeito do register_globals, outra parte insegura que nao existira mais no PHP6*/
if (function_exists("ini_get")) {
    if (!ini_get("display_errors")) {
        ini_set("display_errors", 1);
    }

    if (ini_get("magic_quotes_sybase")) {
        ini_set("magic_quotes_sybase", 0);
    }

    if (ini_get("register_globals")) {
        foreach ($GLOBALS as $s_variable_name => $m_variable_value) {
            if (!in_array($s_variable_name, array("GLOBALS", "argv", "argc", "_FILES", "_COOKIE", "_POST", "_GET", "_SERVER", "_ENV", "_SESSION", "s_variable_name", "m_variable_value"))) {
                unset($GLOBALS[$s_variable_name]);
            }
        }
        unset($GLOBALS["s_variable_name"]);
        unset($GLOBALS["m_variable_value"]);
    }
}




// se formos usar classes elas nao precisaram ser incluidas nos scripts só estanciadas.
// function __autoload($classe){
//         require_once $classe.".php";    
// }   
//http://br.php.net/manual/pt_BR/function.clearstatcache.php
clearstatcache();


define('URL_ATUAL', $_SERVER["REQUEST_URI"]);

$p = explode("/", str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]));

if (isset($p[1])) {
    $var_url = anti_injection($p[1]);
} else {
    $var_url = "";
}
if (isset($p[2])) {
    $var_url1 = anti_injection($p[2]);
} else {
    $var_url1 = "";
}
if (isset($p[3])) {
    $var_url2 = anti_injection($p[3]);
} else {
    $var_url2 = "";
}
if (isset($p[4])) {
    $var_url3 = anti_injection($p[4]);
} else {
    $var_url3 = "";
}
if (isset($p[5])) {
    $var_url4 = anti_injection($p[5]);
} else {
    $var_url4 = "";
}
