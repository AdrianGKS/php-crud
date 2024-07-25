<?php


class CadastroRepositorio
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db->getConexao();
    }

    private function formarObjeto($dados)
    {
        $endereco = new Endereco(
                $dados['id'],
                $dados['pessoa_id'],
                $dados['rua'],
                $dados['numero'],
                $dados['bairro'],
                $dados['cidade'],
                $dados['cep']
        );

        return new Cadastro(
            $dados['id'],
            $dados['nome'],
            $dados['cpf'],
            $dados['sexo'],
            $endereco,
            $dados['telefone'],
            $dados['foto']
        );
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT p.id, p.nome, p.cpf, p.sexo, p.telefone, p.foto,
                e.rua, e.numero, e.bairro, e.cep, e.cidade
                FROM pessoas p
                LEFT JOIN enderecos e ON p.id = e.pessoa_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id) {
        $sql = "SELECT p.id, p.nome, p.cpf, p.sexo, p.telefone, p.foto,
                e.rua, e.numero, e.bairro, e.cep, e.cidade
                FROM pessoas p
                LEFT JOIN enderecos e ON p.id = e.pessoa_id
        WHERE p.id = ?";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function salvar(Cadastro $pessoa)
    {
            // Inserir na tabela pessoas
            $sql = "INSERT INTO pessoas (nome, cpf, sexo, telefone, foto) VALUES (?, ?, ?, ?, ?)";
            $statement = $this->db->prepare($sql);
            $statement->bindValue(1, $pessoa->getNome());
            $statement->bindValue(2, $pessoa->getCpf());
            $statement->bindValue(3, $pessoa->getSexo());
            $statement->bindValue(4, $pessoa->getTelefone());
            $statement->bindValue(5, $pessoa->getFoto());
            $statement->execute();

            $pessoaId = $this->db->lastInsertId();

            $sql = "INSERT INTO enderecos (pessoa_id, rua, numero, bairro, cep, cidade) VALUES (?, ?, ?, ?, ?, ?)";
            $statement = $this->db->prepare($sql);
            $statement->bindValue(1, $pessoaId);
            $statement->bindValue(2, $pessoa->getEndereco()->getRua());
            $statement->bindValue(3, $pessoa->getEndereco()->getNumero());
            $statement->bindValue(4, $pessoa->getEndereco()->getBairro());
            $statement->bindValue(5, $pessoa->getEndereco()->getCep());
            $statement->bindValue(6, $pessoa->getEndereco()->getCidade());
            $statement->execute();

    }
    public function atualizar(Cadastro $pessoa)
    {
            $sql = "UPDATE pessoas SET nome = ?, cpf = ?, sexo = ?, telefone = ? WHERE id = ?";
            $statement = $this->db->prepare($sql);
            $statement->bindValue(1, $pessoa->getNome());
            $statement->bindValue(2, $pessoa->getCpf());
            $statement->bindValue(3, $pessoa->getSexo());
            $statement->bindValue(4, $pessoa->getTelefone());
            $statement->bindValue(5, $pessoa->getId());
            $statement->execute();

            // Atualizar foto se necessário
            if ($pessoa->getFoto() !== 'foto-padrao.png') {
                $this->atualizarFoto($pessoa);
            }

            $sql = "UPDATE enderecos SET rua = ?, numero = ?, bairro = ?, cep = ?, cidade = ? WHERE pessoa_id = ?";
            $statement = $this->db->prepare($sql);
            $statement->bindValue(1, $pessoa->getEndereco()->getRua());
            $statement->bindValue(2, $pessoa->getEndereco()->getNumero());
            $statement->bindValue(3, $pessoa->getEndereco()->getBairro());
            $statement->bindValue(4, $pessoa->getEndereco()->getCep());
            $statement->bindValue(5, $pessoa->getEndereco()->getCidade());
            $statement->bindValue(6, $pessoa->getId());
            $statement->execute();
    }

    private function atualizarFoto(Cadastro $pessoa)
    {
        $sql = "UPDATE pessoas SET foto = ? WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(1, $pessoa->getFoto());
        $statement->bindValue(2, $pessoa->getId());
        $statement->execute();
    }

    public function deletar(int $id) {
        $sql = "DELETE FROM pessoas WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();

        $sql = "DELETE FROM enderecos WHERE pessoa_id = ?";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();

    }
}