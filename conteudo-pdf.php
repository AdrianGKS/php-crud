<?php

    require_once "api/modelo/Database.php";
    require_once "api/modelo/Cadastro.php";
    require_once "api/repositorio/CadastroRepositorio.php";

    $db = new Database();
    $repositorio = new CadastroRepositorio($db);
    $pessoas = $repositorio->buscarTodosObj();

?>

 <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
        }

        .container-admin-banner h1 {
            margin-top: 40px;
            font-size: 30px;
        }

            table {
                width: 90%;
                margin: auto;
                border-collapse: collapse;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                background-color: #fff;
                border-color #000000: ;
                border-style: solid;
                border-radius: 8px;
                overflow: hidden;
            }

            th, td {
                padding: 12px 15px;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #4CAF50;
                color: #fff;
                font-weight: bold;
                text-align: left;
                font-size: 18px;
            }

            td {
                font-size: 16px;
                color: #333;
            }

            tr:hover {
                background-color: #f1f1f1;
            }

            @media print {
                body {
                    background-color: #fff;
                }
                table {
                    box-shadow: none;
                }
            }
 </style>

<body>
    <div class="container-admin-banner">
        <h1>Lista de Pessoas</h1>
    </div>
    <table>
        <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Sexo</th>
            <th>Telefone</th>
            <th>Endereço</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($pessoas as $pessoa): ?>
                <tr>
                    <td><?= htmlspecialchars($pessoa->nome, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($pessoa->cpf, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($pessoa->sexo, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($pessoa->telefone, ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars(
                            $pessoa->rua . ', ' .
                            $pessoa->numero . ', ' .
                            $pessoa->bairro . ', ' .
                            $pessoa->cidade . ', ' .
                            $pessoa->cep,
                            ENT_QUOTES, 'UTF-8'
                        ) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<!--</body>-->
