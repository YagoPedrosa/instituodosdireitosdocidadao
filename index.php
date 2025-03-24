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
                <nav>
                    <ul>
                        <li><a href="./"></a>Inicio</li>
                        <li><a href="sobre.php"></a>Sobre</li>
                        <li><a href="projetos.php"></a>Projetos Sociais</li>
                        <li><a href="contato.php"></a>Contato</li>
                        <li><a href="login-associado.php" class="float-right btn btn-rosa">Sou Associado</a></li>
                        <li><a href="login-associado.php" class="float-right btn btn-azul">Sou Funcionário</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        
        <section id="slider">
            <div class="container-topo">
                <div class="info-slider">
                    <h2><span class="pequeno">Instituto dos Direitos do Cidadão</span>O Único Instituto Voltado a Ajudar o Bairro e a Comunidade</h2>
                    <p>Nosso grupo está comprometido em ajudar a comunidade com projetos sociais, atividades fisícas, cestas básicas.</p>
                    
                    <a href="projetos.php" class="btn btn-azul">Ver Projetos Sociais</a>
                </div>
                <img src="/imagens/slider/Ativo-2.jpg" alt="Imagem Slider IDC 1" class="img-slider float-right">
            </div>
        </section>
        
        <section id="projetos">
            <div class="container flex-row-center">
                <div class="cl-projeto">
                    <img src="/imagens/slider/Ativo-2.jpg" alt="">
                    <p class="float-right center">INCLUSÃO</p>
                </div>
                <div class="cl-projeto">
                    <img src="/imagens/slider/Ativo-2.jpg" alt="">
                    <p class="float-right center">SUSTENTABILIDADE</p>
                </div>
                <div class="cl-projeto">
                    <img src="/imagens/slider/Ativo-2.jpg" alt="">
                    <p class="float-right center">ACESSIBILIDADE</p>
                </div>
            </div>
            
        </section>
        
        <section id="sobre">
            <div class="container sec-pad">
                <img src="/imagens/slider/Ativo-2.jpg" alt="Imagem Slider IDC 1" class="img-slider">
                
                <div class="info-slider float-right">
                    <h2><span class="pequeno">Instituto dos Direitos do Cidadão</span>O Único Instituto Voltado a Ajudar o Bairro e a Comunidade</h2>
                    <p>Nosso grupo está comprometido em ajudar a comunidade com projetos sociais, atividades fisícas, cestas básicas.</p>
                    
                    <a href="projetos.php" class="btn btn-azul">Ver Projetos Sociais</a>
                </div>

            </div>
        </section>
		
		<section id="social">
			<div class="container">
				<ul class="flex-row-justify">
					
					<li class="cl-social">
						<img src="/imagens/icones/icon_experiencia.svg" alt="icone_experiencia_luna">
						<span>+5 Anos <span>de atuação na área</span>
							<p>ajudando mamães com assessoria especializada, reduzindo a burocracia.</p>
						</span>
					</li>
					<li class="cl-social">
						<img src="/imagens/icones/icon_beneficios.svg" alt="icone_experiencia_luna">
						<span>+ 1.000
							<span>benefícios concedidos</span>
							<p>melhorando a vida de muitas famílias, recebendo até R$ 9.200,00.</p>
						</span>
					</li>
					<li class="cl-social">
						<img src="/imagens/icones/icon_aprovacao.svg" alt="icone_experiencia_luna">
						<span>99,6% <span>de taxa de aprovação</span>
							<p>nosso time possui vasta experiência de mercado com alta taxa de sucesso!</p>
						</span>
					</li>
					<li class="cl-social">
						<img src="/imagens/icones/icon_atendimento_humanizado.svg" alt="icone_experiencia_luna">
						<span>Atendimentos <span>humano e ético</span>
							<p>focamos em atender cada mamãe de forma única e personalizada.</p>
						</span>
					</li>

				</ul>
			</div>
		</section>
		
		<section id="novidades">
			<div class="container">
				<div class="postagem-principal">
					<span>Titulo da Postagem</span>
					<p>Breve descrição do Assunto</p>
					<a href="" class="btn btn-azul">Ler mais...</a>
				</div>
				
				<div class="postagem">
					<span>Titulo da Postagem</span>
					<p>Breve descrição do Assunto</p>
					<a href="" class="btn btn-azul">Ler mais...</a>
				</div>
				<div class="postagem">
					<span>Titulo da Postagem</span>
					<p>Breve descrição do Assunto</p>
					<a href="" class="btn btn-azul">Ler mais...</a>
				</div>
				<div class="postagem">
					<span>Titulo da Postagem</span>
					<p>Breve descrição do Assunto</p>	
					<a href="" class="btn btn-azul">Ler mais...</a>
				</div>
				<div class="postagem">
					<span>Titulo da Postagem</span>
					<p>Breve descrição do Assunto</p>
					<a href="" class="btn btn-azul">Ler mais...</a>
				</div>
				
			</div>
		</section>
		
		<footer>
			<div class="topo-rodape">
				<div class="container  flex-row-justify">

					<div class="logo-rodape">
						<img src="imagens/logos/logotipo-01-idc.png" alt="logo-vertical-luna">
						<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quam ipsam consequuntur expedita fuga, sapiente eos quis iste pariatur cupiditate, suscipit totam incidunt eum, nemo aperiam officiis exercitationem. Laboriosam, unde tenetur!</p>
					</div>

					<div class="contato-rodape">	
						<ul>
							<li><i class="fa-solid fa-location-dot"></i>
								<p>Rua José dos Reis, 980 - Sala 07 Vila Prudente - São Paulo/SP Cep: 03139-040</p>
							</li>
							<li><i class="fa-brands fa-whatsapp"></i>
								<p>+55 11 9.8875.4321</p>
							</li>
							<li><i class="fa-solid fa-phone"></i>
								<p>11 3456.7890</p>
							</li>
							<li><i class="fa-regular fa-envelope"></i>
								<p>contato@lunaauxiliomaternidade.com.br</p>
							</li>
						</ul>
					</div>

				</div>
			</div>
			
			<div class="copyright">
				<div class="container">
					<span><span>&copy;2025 . Instituto dos Direitos do CIdadâo</span><span> Todos os direitos reservados </span><span> Desenvolvido por <a href="https://www.pedrosadesign.com.br/" target="_blank">Pedrosa Design</a></span></span>
				</div>
			</div>
			
		</footer>
    </body>
</html>
