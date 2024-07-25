<?php
class Database
{
    private string $host = 'seuHost';
    private string $database_name = 'seuBanco';
    private string $username = 'seuUsuario';
    private string $password = 'seuAdmin';
    public ?PDO $conexao;

    public function __construct()
    {
        $this->conexao = null;
        try {
            $dsn = "pgsql:host=$this->host;dbname=$this->database_name";
            $this->conexao = new PDO($dsn, $this->username, $this->password);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
    }

    public function getConexao(): ?PDO
    {
        return $this->conexao;
    }
}