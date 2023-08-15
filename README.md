### ToDo

- [x] Install project
- [x] Install Easy Admin
- [x] Quiz CRUD
- [x] Questions CRUD
- [x] Answers CRUD

### 06-08-23

- [ ] Реализовать функциональность countdown таймера
- [x] Создать категории для Quiz
- [x] Создать страницу категорий
- [x] Login/Register for users/candidates
- [x] User profile
- [x] User quiz CRUD
- [x] User questions CRUD
- [x] User answers CRUD
- [x] Создать страницу кандидатов викторин
- [ ] Еще раз пройтись по быстрому старту
  - [ ] Pagination
  - [x] Sessions in DB
  - [x] Обработка событий
  - [x] Жизненный цикл объектов Doctrine

### Front end improvements


### 12-08-23 deploy MVP



### commands
```
php bin/console doctrine:schema:drop --full-database --force # очистить базу, удалив все таблицы

php bin/console doctrine:migrations:diff # создать новою миграцию. ПЕРЕД ЭТИМ НУЖНО УДАЛИТЬ ВСЕ СТАРЫЕ МИГРАЦИИ!

php bin/console doctrine:migrations:migrate # отправить новою миграцию в базу
php bin/console doctrine:fixtures:load # загрузить фейковые и реальные данные
```