# Projeto Docker-Laravel-Vue

Aplicação para registrar inscrições de alunos em atividades.
## Visão Geral

### Frontend

O frontend foi desenvolvido utilizando Vue. Ele permite que o usuário possa adicionar, remover e editar alunos e atividades. Além disso, é possível registrar alunos em atividades.

### Backend

O backend foi construído utilizando Laravel, que se conecta a um banco de dados mysql.

### Docker

Para este projeto foi utilizado o ambiente de virtualização Docker.

### Instalação Local

Para executar este projeto localmente, siga os passos abaixo:

1. Clone o repositório do projeto:
   ```bash
   git clone https://github.com/joaozanqui/projeto-vue-laravel-docker.git
2. Navegue até os arquivos do projeto:
    ``` bash
    cd projeto-vue-laravel-docker/projeto-alunos/
3. Execute o comando de inicialização do Docker e criação das imagens:
    ```bash
    docker-compose up --build
    ```
4. Abra o navegador e vá para http://localhost:8080 para visualizar o projeto. O servidor backend estará rodando em http://localhost:9000 e o banco de dados em http://localhost:3333.

### Como Utilizar

1. **Adicionar Alunos ou Atividades**: O usuário pode adicionar alunos e atividades através de uma interface intuitiva.
     *Alunos*: Nome / Email (Formato de email) / RA (Apenas números, até 10 dígitos)
     *Atividades*: Nome / Descrição
   ![.](https://i.ibb.co/Lx3cY0g/Screenshot-from-2024-08-21-08-30-33.png)
2. **Informações de Alunos ou Atividades**: O usuário pode selecionar o aluno ou a atividade clicando com o mouse em cima do mesmo, para acessar suas informações e demais ações.
   ![.](https://i.ibb.co/029VnCf/image.png)
3. **Registrar alunos em atividades**: É possível registrar alunos em atividades através de um aluno ou atividade específica.
   ![.](https://i.ibb.co/2K6WsS3/image.png)
