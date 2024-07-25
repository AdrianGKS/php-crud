<?php
class Database
{
    private string $host = 'localhost';
    private string $database_name = 'cadastro';
    private string $username = 'postgres';
    private string $password = 'admin';
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