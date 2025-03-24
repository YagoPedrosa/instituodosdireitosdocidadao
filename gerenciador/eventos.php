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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sistema IDC</title>
	<link rel="stylesheet" href="css/estilos.css">


    <script src="https://kit.fontawesome.com/d749c0f332.js" crossorigin="anonymous"></script>
</head>
<body>

    
    <?php include_once('includes/sidebar.php') ?>

	<section class="section" id="dashboard">
        <div class="topo">
            <a href="associados.php"><i class="fa-solid fa-user"></i><span>Ver Associados</span></a>
            <a href="associados.php"><i class="fa-solid fa-user"></i><span>Ver Associados</span></a>
        </div>
        <div class="content">
            <div class="larg12">
                <div class="table6">
                    <h3 class="t-table"><i class="fa-solid fa-user"></i><span>Associados</span></h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Nome da Mãe</th>
                                <th>Nacionalidade</th>
                                <th>Estado Civil</th>
                                <th>Profissão</th>
                                <th>Data de Nascimento</th>
                                <th>CPF</th>
                                <th>RG</th>
                                <th>Endereço</th>
                                <th>CEP</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                            </tr>
                        </thead>

                        <?php 
                        
                        $total_associados  = $db->total(tbl_prefixo . "associados", "ID > 0");

                        if ($total_associados > 0):
                        ?>

                        <tbody>

                            <?php
                            $sql_associados = $db->read(
                                tbl_prefixo . "associados",
                                array(),
                                "ID > 0",
                                ""
                            );

                            while ($rs_associados = $sql_associados->fetchObject()):
                            ?>

                            <tr>
                                <td><?php echo $rs_associados->ID; ?></td>
                                <td><?php echo $rs_associados->nome; ?></td>
                                <td><?php echo $rs_associados->mae; ?></td>
                                <td><?php echo $rs_associados->nacionalidade; ?></td>
                                <td><?php echo $rs_associados->estado_civil; ?></td>
                                <td><?php echo $rs_associados->profissao; ?></td>
                                <td><?php echo $rs_associados->nascimento; ?></td>
                                <td><?php echo $rs_associados->cpf; ?></td>
                                <td><?php echo $rs_associados->rg; ?></td>
                                <td><?php echo $rs_associados->endereco."-".$rs_associados->numero."-".$rs_associados->bairro."-".$rs_associados->cidade."-".$rs_associados->estado; ?></td>
                                <td><?php echo $rs_associados->cep; ?></td>
                                <td><?php echo $rs_associados->telefone; ?></td>
                                <td><?php echo $rs_associados->email; ?></td>
                            </tr>

                            <?php endwhile; ?>

                        </tbody>

                        <?php endif; ?>

                    </table>
                </div>
            </div>
        </div>
	</section>
</body>
</html>