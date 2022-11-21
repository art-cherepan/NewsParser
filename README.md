# Инструкция по установке проекта

1. Устанавливаем все зависимости через npm в папке Client командой **npm install**
2. Устанавливаем зависимости в папке Server командой **composer install**
3. Выполняем миграцию командой **php bin/console doctrine:migrations:migrate** из папки Server
4. Запускам сервер командой **php -S localhost:8000 -t public** из папки Server
5. Выполняем **npm run serve** из папки Client

