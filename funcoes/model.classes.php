<?php
//aqui eu nao deixo a pessoa acessar o arquivo diretamente
if (basename($_SERVER["PHP_SELF"]) == "model.classes.php") {
        $Messeger = "[".date("d/m/Y H:i:s")."] Foi detectado uma tentativa de invasão  pelo IP ".$_SERVER['REMOTE_ADDR'].": acessando model.classes.php\r\n";
        file_put_contents('log_seguranca.log', $Messeger, FILE_APPEND);
        die("Este arquivo não pode ser acessado diretamente.");
}    

    class Model {
        protected $db;
        public function __construct() {
            try {
                $this->db = new PDO('mysql:host='.HOST_BD.';dbname='.BANCO_BD, USUARIO_BD, SENHA_BD,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            } catch(PDOException $e) {                
                echo 'Falha ao conectar-se ao banco de dados:<br>' . $e->getMessage();
            }
        }
        
        

        public function insert($tabela, Array $dados) {
            
            foreach ($dados as $inds => $vals){
                $campos[] = $inds;
                $valores[] = $vals;
            }
            $campos = implode(', ', $campos);
            $valores = "'".implode("','", $valores)."'";
            $query = $this->db->prepare("INSERT INTO `{$tabela}` ({$campos}) VALUES ({$valores})");
            
            return $query->execute();
        }
        
        

        public function read($tabela, Array $dados, $where = NULL, $order = NULL) {
            
            $where = ($where != NULL ? "WHERE {$where}" : "");
            $order = ($order != NULL ? "{$order}" : "");
            if(empty($dados)) { $campos = "*"; } else {
             $campos = implode(', ', array_values($dados));
            }
            $result = '$'.implode(', $', array_values($dados));
            
            return $this->db->query("SELECT {$campos}  FROM `{$tabela}` {$where} {$order}");;
        }
        
        

        public function readLeftJoin($tabela,$tabela1,$campo1,$campo2, Array $dados, $where = NULL, $order = NULL) {
            
            $where = ($where != NULL ? "WHERE {$where}" : "");
            $order = ($order != NULL ? "{$order}" : "");
            if(empty($dados)) { $campos = "*"; } else {
             $campos = implode(', ', array_values($dados));
            }
            $result = '$'.implode(', $', array_values($dados));
            
            return $this->db->query("SELECT {$campos}  FROM `{$tabela}` as T1 LEFT JOIN  `{$tabela1}` as T2 ON `{$campo1}`=`{$campo2}` {$where} {$order}");;
        }
        
        

        public function update($tabela, Array $dados, $where) {
            
            foreach ($dados as $ind => $val){
                $campos[] = "{$ind} = '{$val}'";
            }
            $campos = implode(', ', $campos);
            
            return $this->db->query("UPDATE `{$tabela}` SET {$campos} WHERE {$where}");
        }
        
        

        public function delete($tabela, $where) {
            
            $this->db->query("DELETE FROM `{$tabela}` WHERE {$where}");
            
        }
        
        

        public function total($tabela, $where = NULL) {
            
            $where = ($where != NULL ? "WHERE {$where}" : "");
            $tot = $this->db->query("SELECT * FROM `{$tabela}` {$where}");
            
            return $tot->rowCount();
        }
        
        

        public function ultimo($tabela, $where = NULL) {
            
            $where = ($where != NULL ? "WHERE {$where}" : "");
            $ultimo = $this->db->query("SELECT ID FROM `{$tabela}` {$where} ORDER BY ID DESC LIMIT 1");

            $rs_ultimo = $ultimo->fetchObject();
            return $rs_ultimo->ID;
        }
        
    }

?>
