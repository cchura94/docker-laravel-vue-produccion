# Comandos GIT
## Configuración de GIT
### Descargar e Instalar
- https://git-scm.com/
### Crear una cuenta en Github, GitLab, BigBucket (Empresas)
- https://github.com/
## Configuración
- Presentarse ante GIT
```
git config --global user.name "Cristian"
git config --global user.email "cchura.cpc@gmail.com"
```
## Comandos para iniciar en GIT
- para clonar si existe el repositorio remoto
```
git clone direccion_remota
```
- para inicializar 
```
git init
```
- en el archivo (.gitignore) se registra todas las carpetas o archivos a ignorar
- en el archivo (README.md) para describir el proyecto
------
Para realizar una referencia del repositorio local con el repositorio remoto 
- Nota: Para (direccion_remota) es necesario crear un nuevo repositorio en (GitHub)
```
git remote add origin direccion_remota
# ejemplo
git remote add origin https://github.com/cchura94/backend_proyecto_laravue.git
```
### verificamos 
```
git remote 
git remote -v
```
## Para Subir los cambios al repositorio remote
```
git add .
git commit -m "Proyecto Base y migracion personas (1:1)"
git push origin master
```

