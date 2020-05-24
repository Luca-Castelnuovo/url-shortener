# URL-Shortener

Simple URL shortener

## Installation

For development

1. `git clone git@github.com:Luca-Castelnuovo/url-shortener.git`
2. Edit `.env`
3. `composer migrate`
4. `composer seed`
5. Start development server `php -S localhost:8080 -t public`

For deployment

1. `git clone git@github.com:Luca-Castelnuovo/url-shortener.git`
2. `composer install --optimize-autoloader --no-dev`
3. Edit `.env`
4. `composer migrate`

## Security Vulnerabilities

Please review [our security policy](https://github.com/Luca-Castelnuovo/url-shortener/security/policy) on how to report security vulnerabilities.

## License

URL-Shortener is open-sourced software licensed under the [MIT license](LICENSE.md).
