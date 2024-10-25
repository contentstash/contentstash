# contentstash

[![License][license-src]][license-href]

A headless CMS ecosystem built with Laravel, Inertia.js, Vue 3, and Tailwind CSS.

## Prerequisites

- PHP 8.3
- Composer
- Node.js >= 20.x
- PNPM >= 9.12.x

## Installation

1. Clone the repository:

```sh
git clone git@github.com:contentstash/contentstash.git
cd contentstash
```

2. Install the PHP dependencies:

```sh
cd apps/example
composer install
cd ../..
cd packages/core
composer install
cd ../..
```

3. Install the Node.js dependencies:

```sh
pnpm install
```

4. Setup apps/example:

```sh
cd apps/example
cp .env.example .env
nano .env # or use your favorite editor to adjust the configuration
php artisan key:generate
php artisan migrate
php artisan db:seed
cd ../..
```

## Development

You can use the docker-compose file to start all required services:

```sh
docker-compose up -d
```

To start the development server, run the following command:

```sh
pnpm dev
```

## Code style

This project uses ESLint, Prettier and Pint to enforce code style. To see the code style errors and warnings, run the following commands:

```sh
pnpm lint
pnpm format
pnpm pint
```

or bundle them into a single command:

```sh
pnpm codestyle
```

To fix the code style errors and warnings, run the following commands:

```sh
pnpm lint:fix
pnpm format:fix
pnpm pint:fix
```

or bundle them into a single command:

```sh
pnpm codestyle:fix
```

## Update dependencies

To update the PHP dependencies, run the following commands:

```sh
cd apps/example
composer update
cd ../..
cd packages/core
composer update
cd ../..
```

To check for Node.js dependencies updates, run the following command:

```sh
pnpm taze
```

To update the Node.js dependencies, run the following command:

```sh
pnpm taze:w
pnpm install
```

## Testing

### Example app

To run the example app first run all required services via docker-compose (see [Development](#development)). After that, run the following command:

```sh
cd apps/example
pnpm dev
```

If you want to run the example app in the production mode, run the following command:

```sh
cd apps/example
pnpm build
php -S localhost:8000 -t public 
```

## Contributing

Please read the [CONTRIBUTING.md].

## License

Licensed under the [MIT license](https://github.com/contentstash/contentstash/blob/main/LICENSE).

<!-- Badges -->
[license-src]: https://img.shields.io/github/license/contentstash/contentstash?style=flat-square&logo=markdown&labelColor=000000&color=3EAA80
[license-href]: https://github.com/contentstash/contentstash/blob/main/LICENSE
