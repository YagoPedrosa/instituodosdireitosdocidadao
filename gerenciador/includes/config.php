<?php
        // Dados para conexão
        $host = "127.0.0.1";      // Exemplo: "localhost" ou IP do servidor
        $username = "u841044143_idc2025";   // Exemplo: "root"
        $password = "8yRmX1#X";      // Exemplo: "senha123"
        $dbname = "u841044143_pd_idc_2025";       // Exemplo: "meu_banco"
        
        // Cria a conexão
        $conecta = mysqli_connect($host, $username, $password, $dbname);
        
        // Checa se a conexão foi bem-sucedida
        if (!$conecta) {
            die("Falha na conexão: " . mysqli_connect_error());
        }
?>