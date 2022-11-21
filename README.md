# Инструкция по установке проекта

1. Устанавливаем зависимости в папке Client командой **npm install**
2. Устанавливаем зависимости в папке Server командой **composer install**
3. Выполняем миграцию командой **php bin/console doctrine:migrations:migrate** из папки Server
4. Запускам сервер командой **php -S localhost:8000 -t public** из папки Server
5. Выполняем **npm run serve** из папки Client

# Информация по проекту

## При реализации проекта ипользовались следующие инстументы: Symfony 6.0, Vue 3.2, Vuex 4.1 

- Чтобы сохранить спарсенные новости в БД, можно вызвать экшен /content/save-by-url/, либо загрузить данные из файлов в экшене /content/save-by-file/.

- После старта проекта по-умолчанию загрузятся 4 новости из БД. Этот параметр можно менять на основной странице кнопкой  *Обновить количество новостей*. Пагинацияработает по скроллу. 

- Копкой *Установить время новления страницы* можно задавать временной промежуток в секундах, через который будут отправляться запросы на получение данных о рейтенге новости. Если рейтинг новости был изменен, соотвествующая новость поменяет цвет. 

- Кнокой *Обновить рейтинг* можно самостоятельно изменить рейтинг новости
