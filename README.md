# 📚 Biblioteca Dirigida

Projeto de PPO desenvolvido pelos alunos **Inti** e **Emanoel**, com o objetivo de criar um sistema web para gerenciamento e acesso a uma biblioteca de estudos online.

---

## 📌 Sobre o Projeto

A **Biblioteca Dirigida** é uma aplicação web desenvolvida em **PHP** com banco de dados **MySQL**, pensada para auxiliar alunos no acesso a materiais de estudo organizados por categorias e tipos (ebooks, artigos, vídeos, etc).

O sistema permite o cadastro e login de usuários, visualização de materiais, comentários, progresso de estudo, e muito mais.

---

## 🛠️ Tecnologias Utilizadas

- 💻 **PHP** (backend)
- 🗃️ **MySQL** (banco de dados relacional)
- 🌐 **HTML/CSS/JavaScript** (frontend básico)
- 🛠️ **MySQL Workbench** (modelagem de banco e EER Diagram)
- 📦 (Opcional) **XAMPP/Laragon** para ambiente local

---

## 📁 Estrutura do Projeto
biblioteca-dirigida/
│
├── 📁 config/              # Configurações gerais do sistema
│   └── db.php             # Conexão com o banco de dados
│
├── 📁 controllers/         # Lógica de controle (fluxo entre view e model)
│   ├── usuarioController.php
│   ├── materialController.php
│   └── categoriaController.php
│
├── 📁 models/              # Consultas ao banco de dados
│   ├── Usuario.php
│   ├── Material.php
│   └── Categoria.php
│
├── 📁 views/               # Páginas HTML/PHP exibidas ao usuário
│   ├── home.php
│   ├── login.php
│   ├── cadastro.php
│   ├── dashboard.php
│   └── materiais.php
│
├── 📁 public/              # Arquivos públicos e estáticos
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── script.js
│   └── imagens/
│       └── logo.png
│
├── 📁 sql/                 # Scripts SQL
│   ├── biblioteca_dirigida.sql  # Criação das tabelas
│   └── diagram.png              # Imagem do EER (opcional)
│
├── index.php              # Página inicial do projeto
├── routes.php             # Arquivo que redireciona rotas simples
├── README.md              # Documentação do projeto
└── .htaccess              # (opcional) URLs amigáveis


---

## 🧱 Estrutura do Banco de Dados

O banco de dados é composto pelas seguintes tabelas principais:

- **usuarios** – Cadastro e login
- **materiais** – Armazena os conteúdos disponíveis
- **categorias** – Organização dos materiais por tema
- **comentarios** – Interações dos usuários com os conteúdos
- **favoritos** – Lista pessoal de materiais salvos
- **progresso_estudo** – Acompanhamento de leitura/estudo
- **avaliacoes** – Notas e feedback dos usuários

> O diagrama EER do projeto está disponível no diretório `/sql`.

---

## 🚀 Como Executar o Projeto

1. **Clone o repositório** (caso esteja no GitHub ou semelhante):
   ```bash
   git clone https://github.com/intibohmann/Biblioteca-Dirigida.git


