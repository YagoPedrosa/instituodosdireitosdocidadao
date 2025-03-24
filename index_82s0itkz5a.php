<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/funcoes/funcoes.php');

$sql_seo = $db->read(
	"pd_seo",
	array(),
	"link = 'home'",
	""
);

$rs_seo = $sql_seo->fetchObject();


//SEO
if (is_null($rs_seo->seo_titulo) || $rs_seo->seo_titulo == '' || $rs_seo->seo_titulo == ' ' || $rs_seo->seo_titulo == '  ') {
	$meta_titulo = 'Bem Vindo | ' . empresa . ' | ' . slogan;
} else {
	$meta_titulo = $rs_seo->seo_titulo . ' | ' . empresa . ' | ' . slogan;
}

if (is_null($rs_seo->seo_descricao) || $rs_seo->seo_descricao == '' || $rs_seo->seo_descricao == ' ' || $rs_seo->seo_descricao == '  ') {
	$meta_descricao = seo_descricao;
} else {
	$meta_descricao = $rs_seo->seo_descricao;
}


if (is_null($rs_seo->seo_keywords) || $rs_seo->seo_keywords == '' || $rs_seo->seo_keywords == ' ' || $rs_seo->seo_keywords == '  ') {
	$meta_keywords = seo_keywords;
} else {
	$meta_keywords = $rs_seo->seo_keywords;
}

if (isset($_SESSION['usuario_LBS_ID'])) {
	$usuario = " " . $_SESSION['usuario_LBS_Nome'];
	$logado  = 1;
} else {
	$usuario = "";
	$logado  = 0;
}

$tabindex = 1;
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo empresa; ?></title>
        <link rel="stylesheet" href="css/estilos.css">

        <script src="https://kit.fontawesome.com/d749c0f332.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <div class="container">
                <img src="/imagens/logos/logotipo-02-idc.png" alt="">
                <nav class="float-right">
                    <ul>
                        <li><a href="./"></a>Inicio</li>
                        <li><a href="sobre.php"></a>Sobre</li>
                        <li><a href="projetos.php"></a>Projetos Sociais</li>
                        <li><a href="contato.php"></a>Contato</li>
                    </ul>
                    <a href="login-associado.php" class="float-right">Painel de Associado</a>
                </nav>
            </div>
        </header>
        
        <section id="slider">
            <div class="container-topo">
                <div class="info-slider">
                    <span>Instituto dos Direitos do Cidadão</span>
                    <h2>O Único Instituto Voltado a Ajudar o Bairro e a Comunidade</h2>
                    <p>Nosso grupo está comprometido em ajudar a comunidade com projetos sociais, atividades fisícas, cestas básicas.</p>
                    
                    <a href="projetos.php">Ver Projetos Sociais</a>
                </div>
                <div class="img-slider">
                    <img src="imagens/slider/img-slider-1.jpg" alt="Imagem Slider IDC 1">
                </div>
            </div>
        </section>
    </body>
</html>

<?php
echo "<mm:dwdrfml documentRoot=" . __FILE__ .">";$included_files = get_included_files();foreach ($included_files as $filename) { echo "<mm:IncludeFile path=" . $filename . " />"; } echo "</mm:dwdrfml>";
?>