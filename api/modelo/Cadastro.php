<?php


class Cadastro
{
    private ?int $id;
    private string $nome;
    private string $cpf;
    private string $sexo;
    private Endereco $endereco;
    private string $telefone;
//    private string $foto;


    public function __construct(?int $id, string $nome, string $cpf, string $sexo, Endereco $endereco,
                                string $telefone)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->sexo = $sexo;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
//        $this->foto = $foto;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function getSexo(): string
    {
        return $this->sexo;
    }

    public function getEndereco(): Endereco
    {
        return $this->endereco;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

//    public function getFoto(): string
//    {
//        return $this->foto;
//    }
//
//    public function setFoto(string $foto): void
//    {
//        $this->foto = $foto;
//    }
//
//    public function getFotoDiretorio(): string
//    {
//        return __DIR__ . "/uploads/".$this->foto;
//    }

}