# contentstash

[![License][license-src]][license-href]

A headless CMS ecosystem built with Laravel, Inertia.js, Vue 3, and Tailwind CSS.

## Prerequisites

- PHP 8.3
- Composer
- Node.js >= 20.x
- PNPM >= 8.15.x

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

## Contributing

Please read the [CONTRIBUTING.md].

## License

Licensed under the [MIT license](https://github.com/contentstash/contentstash/blob/main/LICENSE).

<!-- Badges -->
[license-src]: https://img.shields.io/github/license/contentstash/contentstash?style=flat-square&logo=markdown&labelColor=000000&color=3EAA80
[license-href]: https://github.com/contentstash/contentstash/blob/main/LICENSE
