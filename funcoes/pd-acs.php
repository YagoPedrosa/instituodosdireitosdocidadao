<?php
header('Content-type: text/html; charset=UTF-8');
//aqui eu nao deixo a pessoa acessar o arquivo diretamente

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (basename($_SERVER["PHP_SELF"]) == "pd-acs.php") {
    die("Ops... você não pode fazer isso!");
}

if (!function_exists('url_decode')) {

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
}

$producao = 0;

if ($producao == 1) {

    ini_set('display_errors', 0);
    ini_set('display_startup_erros', 0);
    error_reporting(0);

    define("url_site", "https://www.institutodosdireitosdocidadao.org/");
    define("url_site_adm", "https://www.institutodosdireitosdocidadao.org/gerenciador/");

    define("diretorio", "/home/u841044143.idc4532pd/public_html/");
    define("diretorio_adm", "/home/u841044143.idc4532pd/public_html/gerenciador/");
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_erros', 1);
    error_reporting(E_ALL);


    define("url_site", "https://www.institutodosdireitosdocidadao.org/");
    define("url_site_adm", "https://www.institutodosdireitosdocidadao.org/gerenciador/");

    define("diretorio", "/home/u841044143.idc4532pd/public_html/");
    define("diretorio_adm", "/home/u841044143.idc4532pd/public_html/gerenciador/");
}


define("HOST_BD", "localhost");
define("BANCO_BD", "u841044143_pd_idc_2025");
define("USUARIO_BD", "u841044143_idc2025");
define("SENHA_BD", '8yRmX1#X');
define("tbl_prefixo", "pd_sis_");

require_once("model.classes.php");


$db = new Model;


$sql = $db->read(
    "pd_contato",
    array(),
    "ID = '1001'",
    ""
);

$rs = $sql->fetchObject();



define("empresa", $rs->empresa);
define("slogan", $rs->slogan);
define("razao_social", $rs->razao_social);
define("endereco", $rs->endereco);
define("numero", $rs->numero);
define("complemento", $rs->complemento);
define("bairro", $rs->bairro);
define("cidade", $rs->cidade);
define("uf", $rs->uf);
define("cep", $rs->cep);

define("cpf_cnpj", $rs->cpf_cnpj);

define("endereco_completo", $rs->endereco . ', ' . $rs->numero . ' ' . $rs->complemento . ' - ' . $rs->bairro . ' - ' . $rs->cidade . '/' . $rs->uf . ' - Cep: ' . $rs->cep);

define("tipo", $rs->tipo);
if ($rs->tipo == 1) {
    define("tipo_escrito", "Pessoa Física");
} else {
    define("tipo_escrito", "Pessoa Jurídica");
}

define("telefone1", $rs->telefone1);
define("telefone2", $rs->telefone2);
define("telefone3", $rs->telefone3);
define("telefone4", $rs->telefone4);

define("whatsapp", $rs->whatsapp);

define("email_form", $rs->email_forms);
define("email_contato", $rs->email_contato);

define("facebook", $rs->facebook);
define("instagram", $rs->instagram);
define("twitter", $rs->twitter);
define("youtube", $rs->youtube);
define("vimeo", $rs->vimeo);
define("linkedin", $rs->linkedin);
define("pinterest", $rs->pinterest);


define("googleanalytics", $rs->analytics);


define("pixel_facebook", $rs->pixel_facebook);
define("pixel_google", $rs->pixel_google);


define("form_titulo", $rs->email_titulo);
define("form_reply", $rs->email_reply);

define("form_email", $rs->email_remetente);

define("form_host", $rs->email_smtp);
define("form_porta", $rs->email_porta);
define("form_usuario", $rs->email_usuario);
define("form_senha", url_decode($rs->email_senha));
define("form_seguranca", $rs->email_seguranca);


define("seo_titulo", $rs->seo_titulo);
define("seo_descricao", $rs->seo_descricao);
define("seo_keywords", $rs->seo_keywords);


function enviaEmail($mail, $debug = null)
{

    // Define os dados do servidor e tipo de conexão
    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    if ($debug != null) {

        $mail->SMTPDebug = $debug; // Default == 3  Enable verbose debug output

    }
    $mail->IsSMTP(); // Define que a mensagem será SMTP
    $mail->Host = form_host; // Endereço do servidor SMTP
    $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
    $mail->Username = form_usuario; // 'seumail@dominio.net'; // Usuário do servidor SMTP
    $mail->Password = form_senha; // // Senha do servidor SMTP
    if (form_seguranca == 1) {
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
        $mail->SMTPAutoTLS = false;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            )
        );
    }
    $mail->Port = form_porta; // TCP port to connect to
    $mail->isHTML(true); // Define que o e-mail será enviado como HTML
    $mail->CharSet = 'utf-8'; // Define o Charset                                      // Define que o e-mail será enviado como HTML

}
