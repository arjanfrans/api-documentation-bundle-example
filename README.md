# ApiDocumentationBundle Example

An example project demonstration the [fusonic/api-documentation-bundle](https://github.com/fusonic/php-api-documentation-bundle)
with the [fusonic/http-kernel-extensions](https://github.com/fusonic/php-http-kernel-extensions).

Two example controllers are included:
 * `src/ContactController.php` (using plain OpenApi, regular Route annotations, cumbersome validation and (de)serialization)
 * `src/ImprovedController.php` (using features from the http-kernel-extensions and api-documentation-bundle)

 To view the documentation, navigate to `/api/docs`.

## Recommended development setup

1. Install [Docker](https://www.docker.com/)
2. Start the PHP container: `./start-docker-container.sh`.
3. (In container) Install the packages: `composer install`.
4. (In container) Start the development server (inside the container): `./bin/start-server.sh`
