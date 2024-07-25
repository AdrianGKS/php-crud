<?php

class Endereco
{
    private ?int $id;
    private ?int $pessoaId;
    private string $rua;
    private string $numero;
    private string $bairro;
    private string $cidade;
    private string $cep;

    public function __construct(?int $id, ?int $pessoaId, string $rua, string $numero, string $bairro, string $cidade, string $cep)
    {
        $this->rua = $rua;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->cep = $cep;
        $this->id = $id;
        $this->pessoaId = $pessoaId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPessoaId(): ?int
    {
        return $this->pessoaId;
    }

    public function getRua(): string
    {
        return $this->rua;
    }

    public function getNumero(): string
    {
        return $this->numero;
    }

    public function getBairro(): string
    {
        return $this->bairro;
    }

    public function getCidade(): string
    {
        return $this->cidade;
    }

    public function getCep(): string
    {
        return $this->cep;
    }

}