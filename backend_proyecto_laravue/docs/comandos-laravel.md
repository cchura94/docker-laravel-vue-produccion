```
php artisan migrate

php artisan make:migration create_personas_table
php artisan make:model Persona

php artisan migrate:status
php artisan migrate:rollback

php artisan tinker
------------------------------
php artisan make:model Role -m
php artisan make:migration create_role_user_table
........----------------------
php artisan make:model Categoria -m
php artisan make:model Producto -m

```

## Controladores

```
php artisan make:controller CategoriaController
php artisan make:controller RoleController -r
php artisan make:controller PersonaController --api

php artisan make:controller UserController --api
php artisan make:controller ProductoController --api
```