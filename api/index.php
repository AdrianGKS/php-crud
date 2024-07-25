<?php

require 'modelo/Database.php';
require 'modelo/Cadastro.php';
require 'modelo/Endereco.php';
require 'repositorio/CadastroRepositorio.php';

$db = new Database();
$repositorio = new CadastroRepositorio($db);

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        try {
            $dados = $repositorio->buscarTodos();
            echo json_encode($dados);
        } catch (Exception $e) {
            echo json_encode(['error' => "Erro ao listar registros: " . $e->getMessage()]);
        }
        break;
    case 'getUser':
        try {
            $id = $_GET['id'] ?? null;

            if (!is_numeric($id)) {
                throw new Exception("ID não fornecido ou inválido.");
            }

            $pessoa = $repositorio->buscarPorId($id);

            if ($pessoa) {
                echo json_encode($pessoa);
            } else {
                throw new Exception("Usuário não encontrado.");
            }
        } catch (Exception $e) {
            echo json_encode(['error' => "Erro ao carregar dados: " . $e->getMessage()]);
        }
        break;

    case 'save':
        try {
            $endereco = new Endereco(
                null,
                null,
                $_POST['rua'],
                $_POST['numero'],
                $_POST['bairro'],
                $_POST['cidade'],
                $_POST['cep']
            );

            $pessoa = new Cadastro(
                null,
                $_POST['nome'],
                $_POST['cpf'],
                $_POST['sexo'],
                $endereco,
                $_POST['telefone']
            );

            if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                $pessoa->setFoto(uniqid().$_FILES['foto']['name']);
                move_uploaded_file($_FILES['foto']['tmp_name'], $pessoa->getFotoDiretorio());
            } else {
                throw new Exception("Erro ao salvar foto.");
            }

            $repositorio->salvar($pessoa);
            echo json_encode(['message' => "Registro salvo com sucesso"]);
        } catch (Exception $e) {
            echo json_encode(['error' => "Erro ao salvar registro: " . $e->getMessage()]);
        }
        break;

    case 'update':

        try {
            $endereco = new Endereco(
                null,
                $_POST['id'],
                $_POST['rua'],
                $_POST['numero'],
                $_POST['bairro'],
                $_POST['cidade'],
                $_POST['cep']
            );

            $pessoa = new Cadastro(
                $_POST['id'],
                $_POST['nome'],
                $_POST['cpf'],
                $_POST['sexo'],
                $endereco,
                $_POST['telefone']
            );

            if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                $pessoa->setFoto(uniqid().$_FILES['foto']['name']);
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $pessoa->getFotoDiretorio())) {
                    echo "Arquivo enviado com sucesso!";
                } else {
                    echo "Erro ao mover o arquivo.";
                }

            }

            $repositorio->atualizar($pessoa);
            echo json_encode(['message' => "Registro atualizado com sucesso"]);
        } catch (Exception $e) {
            echo json_encode(['error' => "Erro ao atualizar registro: " . $e->getMessage()]);
        }
        break;

    case 'delete':
        try {
            $data = json_decode(file_get_contents("php://input"));
            $id = $data->id;

            if (!is_numeric($id)) {
                throw new Exception("ID não fornecido ou inválido.");
            }

            $repositorio->deletar($id);
            echo json_encode(['message' => "Registro deletado com sucesso"]);
        } catch (Exception $e) {
            echo json_encode(['error' => "Erro ao deletar registro: " . $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['error' => "Ação inválida"]);
        break;
}

