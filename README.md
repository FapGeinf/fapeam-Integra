# Sistema fapeam integra
## Instalar o xampp
    - mysql server e phpmyamdin (PHP)
## Clone do Projeto
    - Clonar o projeto do github
    - Selecionar a pasta da projeto (fapeam-Integra)
## Instalar as dependencias do Projeto
    - composer install
## Criar o arquivo .env
    - Há disponivel o arquivo .env.example
    - Copiar o arquivo de exemplo e renomear para .env
    - Modificar os dados do banco de dados no arquivo .env
    - Modificar o nome da aplicação no arquivo .env
# Criar uma nova chave para a aplicação
    -php artisan key:generate
    -Verificar no .env se a key foi gerada
# Rodar as migrations com as seeds
    - php artisan migrate:fresh --seed
# Instalar as dependencias JS
    - npm install ou npm i
# Executar a aplicação
    - php artisan serve
    - npm run dev

