Настройка гита и автоматического деплоя на хостинг
-----------------------------------------------------------------------------------------------------------------------------------------------------------
1. Открыть папку с проектом в VsCode

2. В терминале выполнить команды 
git init
git add --all
git commit -m "Initial commit"

3. Создайте репозиторий на GitHub

4. Перейдите в VsCode и в терминале выполните команды
git remote add origin https://github.com/ваш-username/ваш-репозиторий.git
git push -u origin master

5. Перейдите в свой ЛК в Beget и создайте FTP-пользователя

6. Перейдите в свой аккаунт на GitHub и настройте секреты (Settings - Sectets and variables), например:

FTP_SERVER: c985833i.beget.tech
FTP_USERNAME: c985833i_site
FTP_PASSWORD: PsoN1T%lBEya

7. Перейдите в Actions и создайте файл deploy.yml (полный путь .github/workflows/deploy.yml) с содержимым (нужно поменять имя папки со styleguide на свое):

name: 🚀 Deploy to Beget

on:
  push:
    branches: [ master ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v4
    
    - name: 📤 Upload all files via FTPS
      uses: SamKirkland/FTP-Deploy-Action@v4.3.4
      with:
        server: ${{ secrets.FTP_SERVER }}
        username: ${{ secrets.FTP_USERNAME }}
        password: ${{ secrets.FTP_PASSWORD }}
        local-dir: "./"
        server-dir: "./styleguide/"
        protocol: ftps
        security: strict  # Используем strict вместо implicit
        port: 21

8. Чтобы обновлять гит одной командой, добавьте в файл git - config следующий код: 

[alias]
    acp = "!f() { git add --all && git commit -m \"$1\" && git push origin master; }; f"