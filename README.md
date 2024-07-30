# Teste CRUD: PHP, AngularJS e PostgreSQL

## 🔧 Instalação

Para fazer a instalação do ambiente de desenvolvimento em execução você deverá:
```
Instalar o Git
Instalar o PHP
Baixar o projeto deste repositório ou cloná-lo em seu ambiente local
Criar o banco de dados de acordo com o seguinte script:
-- Criação da tabela pessoas
CREATE TABLE pessoas (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) NOT NULL UNIQUE,
    sexo CHAR(1) CHECK (sexo IN ('M', 'F', 'O')),
    telefone VARCHAR(15),
    foto VARCHAR(255)
);

-- Criação da tabela enderecos
CREATE TABLE enderecos (
    id SERIAL PRIMARY KEY,
    pessoa_id INT REFERENCES pessoas(id) ON DELETE CASCADE,
    rua VARCHAR(100),
    numero VARCHAR(10),
    bairro VARCHAR(100),
    cep VARCHAR(10),
    cidade VARCHAR(100)
);
Abrir o projeto na sua IDE
Executar o comando de instalação "composer install" no terminal na pasta base
Setar as variáveis do banco de dados na classe 'Database'
Executar o projeto no com o comando "php -S localhost:8000" (ou a porta que desejar)
Abrir o localhost no navegador "localhost:8000/web/index.html"
```
