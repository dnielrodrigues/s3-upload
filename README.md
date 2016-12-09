## Instalar instância:

1. A raiz do site será o clone do repositório [portal_leg_view]. Ou seja, clonar e renomear para "www", ou "public_html", ou "html"; de acordo com seu servidor apache.
2. Um nível cima da raiz do site, clonar o repositório [portal_leg_app] e renomear a pasta para [system-portalleg].
    OBS: Também é possível usar outro nome alterando o atributo no arquivo Settings.php.
3. Instanciar o composer dentro da pasta system-portalleg:
  `composer install`
4. Clonar o repositório do framework Cristal dentro da pasta: /system-portalleg/vendor.
    - endereço: https://github.com/dnielrodrigues/cristal
    - OBS: Ficando o caminho final = [raiz do site]/../system-portalleg/vendor/cristal
5. Clonar os repositórios de ferramentas externas (pasta vendor):
    - jQuery File Upload:
    https://github.com/blueimp/jQuery-File-Upload
6. Dependências de Bibliotecas no PHP:
    - Image Magick
    http://php.net/manual/pt_BR/imagick.setup.php
    - Instalar Bibliotecas de tratamento de arquivos no ubuntu:
    sudo apt-get install php5-imagick php5-gd libpng-dev libjpeg-dev libmagickwand-dev imagemagick
7. Criar os seguintes arquivos duplicando o arquivo "-sample" na mesma pasta, renomeando e aplicando as devidas alterações:
    - [raiz do site]/admin/app/js/config.js
    - [raiz do site]/../system-portalleg/config/Connect.php
8. Criar a pasta [logs] dentro de system-portalleg (para salvar os logs de erro do sistema.
9. O link para interface de teste do webservice é [url do site]/service-test.


## Para servidores com NGinx:

1. Para dicionar um domínio, criar um arquivo `dominio.com` em `/etc/nginx/sites-available` com:

    ```
    server {
        listen 80;
        listen [::]:80;

        root /home/ubuntu/dominio.com/public;
        index index.php index.html index.htm;

        server_name dominio.com www.dominio.com;

        location / {
            try_files $uri $uri/ /index.php?q=$uri&$args;
        }

        location ~ \.php$ {
            try_files $uri =404;
            fastcgi_pass unix:/var/run/php5-fpm.sock;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  /usr/share/nginx/www$fastcgi_script_name;
            include         fastcgi_params;
        }
    }
    ```

2. Criar o atalho para o arquivo de config do dominio nos dominios ativados:

    ```
    sudo ln -s /etc/nginx/sites-available/dominio.com /etc/nginx/sites-enabled/
    ```

3. Reiniciar o NGinx: `sudo service nginx restart`


## Configuração do Servidor

1. Limite dos tamanhos de arquivos:
    - No arquivo /etc/php5/cli/php.ini alterar:
        ```
        max_input_time = 10000
        max_execution_time = 10000
        upload_max_filesize = 10M
        post_max_size = 10M
        memory_limit = 10M
        ```
    - No arquivo /etc/nginx/nginx.conf alterar:
        ```
        client_max_body_size 24000M;
        ```

## Banco de dados:
    
rodar scripts de instação e patchs na pasta compartilhada do Google Drive (projeto_cms/Banco de dados/...)

## Dados iniciais:
    
No primeiro acesso, ativar o "modo instalacao". No arquivo Settings.php inserir "true" no atributo @installMode.

## Sobre tratamento de erros:

 - Registro de erros no arquivo config/errors.json. Pode-se usar apenas:

    Lib::returnError("numero do erro");

 - Para os erros do banco, este método salva um arquivo log na pasta log (importante usar o "die;" para não retornar 2 jsons):
    
    Lib::dbWarning($exception); die;

 - Importante registrar todos os erros nesse arquivo.
 - Uso opcional: Os erros padrões do Cristal começam com "c" ( exemplo: Lib::returnError("c10"); ) e estão em: vendor/cristal/config/errors.json.

## Pendências mais Atuais:

- slug dos elementos acessíveis ao usuario
- métodos getAllElements() de Categorias de Notícias ()
- métodos getAllElements() de Notícias (Posts)
-----------------
- Autenticação e persistência no browser das infos do usuário.
- Tela nova-noticia, nova-pagina: setar o id do usuário dinamicamente (está como 1).
- Tela nova-noticia, nova-pagina: puxar as opções de categoria dinamicamente.
- Tela nova-noticia, nova-pagina: captura e envio de foto.
- jLib: implementar metodos de mensagens com o notify plugin.


## Próximos releases e sugestões: 
    
- Comentários em notícias
- Otimização de endereços e informações da prefeitura e e-SIC
- Histórico de [ data / usuário ] das alterações de news, pages, etc...
- Otimizar gerar thumbs das noticias...
- Deixar o "Digite algo" do editor wysiwig como placeholder

# Script update.sh de atualização dos repositórios na instância:

Shell Script para atualização de várias instâncias na amazon:

```
  #!/bin/bash
  echo "Usuário atual:"
  whoami
  cd /home/ubuntu/campogrande.rn.gov.br/public/
  git pull
  cd /home/ubuntu/campogrande.rn.gov.br/system-portalleg/
  git pull
  cd /home/ubuntu/autesp.com.br/public/
  git pull
  cd /home/ubuntu/autesp.com.br/system-portalleg/
  git pull
  cd /home/ubuntu/cmsaovicenteferrer.ma.gov.br/public/
  git pull
  cd /home/ubuntu/cmsaovicenteferrer.ma.gov.br/system-portalleg/
  git pull
```

## Script para atualização de imagens no banco

```
UPDATE ma_saovicenteferrer.media
SET url = replace(url, 'homolog4.infocasp.com.br', 'cmsaovicenteferrer.ma.gov.br');
SELECT url FROM ma_saovicenteferrer.media;
```

## Script para atualização de menus no banco (ainda em fase de teste!!!!!)

```
UPDATE rn_campogrande.menu
SET men_links = replace(men_links, 'homolog3.infocasp.com.br', 'campogrande.rn.gov.br');
SELECT men_links FROM rn_campogrande.menu;
```
## Comando no terminal caso o download do homestead der erro de SSL
```
vagrant box add laravel/homestead -c
```
