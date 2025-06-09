# 📦 Projeto WebApp - Sistema de Cadastro de Usuários com Upload de Imagens

Este projeto é um sistema web básico desenvolvido em PHP utilizando o padrão **MVC (Model-View-Controller)**. Ele permite o cadastro de usuários, envio de imagens e paginação de dados, utilizando uma arquitetura organizada por responsabilidade.

---

---

## 📁 Estrutura do Projeto

```
webapp/
│
├── App/
│   ├── config/
│   │   └── database.php
│   ├── model/
│   │   ├── BaseModel.php
│   │   ├── ImagemModel.php
│   │   └── UsuarioModel.php
│   ├── SQL/
│   │   └── script.sql
│   └── view/
│       ├── assets/
│       │   ├── css/
│       │   ├── img/
│       │   └── js/
│       ├── componentes/
│       │   ├── functions/
│       │   │   ├── paginationHandler.php
│       │   │   ├── uploadHandler.php
│       │   │   └── userRegistrationHandler.php
│       │   └── sections/
│       │       ├── formularioBusca.php
│       │       ├── formularioCadastroUsuario.php
│       │       ├── formularioUpload.php
│       │       ├── gridImagens.php
│       │       ├── mensagem.php
│       │       └── paginacao.php
│       └── pages/
│           └── cadastroUsuario.php
├── index.php
├── README.md
└── DOC/
```

✅ Funcionalidades

- 📋 Cadastro de Usuários
- 📤 Upload de Imagens
- 🔍 Busca e Paginação de Resultados
- 💡 Feedback de sucesso/erro nas operações

---

## ⚙️ Tecnologias Utilizadas

- PHP (sem framework)
- HTML5 e CSS3
- JavaScript
- MySQL (via PDO)
- Estrutura modularizada por responsabilidade (MVC)

---

## 🚀 Como Executar

1. **Requisitos:**

   - PHP 8+
   - MySQL
   - Apache (recomendado XAMPP, WAMP ou Laragon)
2. **Clonar o projeto:**

```bash
git clone https://github.com/seuusuario/webapp.git
```

3. **Importar o banco de dados:**

   - Utilize o script em:
     `App/SQL/script.sql`
4. **Configurar a conexão com o banco:**

   - Edite o arquivo:
     `App/config/database.php`
5. **Acessar via navegador:**

```bash
http://localhost/webapp/App/view/pages/index.php
```

---

## 📄 Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
