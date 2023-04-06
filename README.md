
## Instalación (Requiere Docker)

El proyecto esta desarrollado en Laravel y para su funcionamiento puede correr con docker.

- Clonar el repositorio.
- Abrir una terminal en la raiz del proyecto.
- Ejecutar el siguiente comando para construir el contenedor de docker.
  - docker build -t laravel-test .
- Iniciar el contenedor creado:
  - docker run -d -p 8080:80 --name laravel-test laravel-test
- Abrir el navegador en la ruta:
  - [http://localhost:8080](http://localhost:8080)

## Extras

- En la raiz del proyecto se encuentra el digrama E-R.
- Si prefiere puede importar la coleccion de POSTMAN ubicado en la raiz del proyecto.

## Produccion

- Comando para docker composer en produccion
  - COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1 docker-compose build


Autor: Luis Alberto Vasquez Perez
