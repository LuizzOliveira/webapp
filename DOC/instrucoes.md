| Linha | Bloco / Função                                                                        |
| ----- | --------------------------------------------------------------------------------------- |
| 1     | Início da sessão (`session_start`)                                                  |
| 3     | Requisições de dependências (`require_once`)                                       |
| 7     | Conexão com o banco e instanciamento dos models                                        |
| 11    | Carregamento da mensagem de sessão                                                     |
| 15    | **[UPLOAD]**Início do bloco de upload via `POST`                                     |
| 17    | Verificação dos campos `foto`,`nome_usuario`e `email_usuario`                   |
| 20    | Definição e verificação de tipo, tamanho e dados obrigatórios da imagem            |
| 31    | Busca de usuário por email e criação, se necessário                                 |
| 44    | Validação da extensão da imagem                                                      |
| 52    | Criação de diretório de uploads (se necessário)                                     |
| 56    | Geração de nome único e caminho para o arquivo                                       |
| 60    | Upload do arquivo e relacionamento com usuário                                         |
| 80    | Redirecionamento após processamento do upload                                          |
| 84    | **[PAGINAÇÃO]**Configuração de paginação (`$imagensPorPagina`,`$paginaAtual`) |
| 88    | Leitura do nome digitado na busca                                                       |
| 90    | Busca de usuário e imagens com base no nome digitado                                   |
| 100   | Busca padrão (sem filtro)                                                              |
| 106   | Cálculo do total de páginas                                                           |
| 111   | Tratamento para páginas vazias ou inválidas                                           |
| 118   | Definição da variável `$paginaVazia`                                               |
| 124   | Início do HTML                                                                         |
| 129   | Inclusão de CSS e fontes Google                                                        |
| 135   | **[COLUNA ESQUERDA]**Formulário de upload                                              |
| 142   | Exibição de mensagens de sucesso ou erro                                              |
| 145   | Formulário `POST`para envio da imagem                                                |
| 152   | Link para `cadastroUsuario.php`                                                       |
| 155   | **[FILTRO]**Formulário de busca de imagens por nome                                    |
| 161   | Botão "Ver todas" se houver busca ativa                                                |
| 167   | **[COLUNA DIREITA]**Visualização das imagens                                          |
| 170   | Título condicional com base na busca                                                   |
| 174   | Grid de exibição das imagens                                                          |
| 175   | Caso nenhuma imagem seja encontrada                                                     |
| 177   | Laço `foreach`para exibir cada imagem                                                |
| 185   | **[PAGINAÇÃO]**Navegação entre páginas                                             |
| 187   | Botão "Anterior"                                                                       |
| 190   | Laço de números de páginas                                                           |
| 200   | Botão "Próximo"                                                                       |
| 211   | Fim do corpo da página (`</body>`)                                                   |
| 213   | **[JS]**Script para esconder mensagens após 3 segundos                                 |
