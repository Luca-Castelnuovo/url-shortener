<p align="center"><a href="https://github.com/Luca-Castelnuovo/URL-Shortener"><img src="https://rawcdn.githack.com/Luca-Castelnuovo/URL-Shortener/3406696e4b53c5b9085e6c1042c79a3117627ed2/public/assets/images/banner.png"></a></p>

<p align="center">
<a href="https://github.com/Luca-Castelnuovo/URL-Shortener/commits/master"><img src="https://img.shields.io/github/last-commit/Luca-Castelnuovo/URL-Shortener" alt="Latest Commit"></a>
<a href="https://github.com/Luca-Castelnuovo/URL-Shortener/issues"><img src="https://img.shields.io/github/issues/Luca-Castelnuovo/URL-Shortener" alt="Issues"></a>
<a href="LICENSE.md"><img src="https://img.shields.io/github/license/Luca-Castelnuovo/URL-Shortener" alt="License"></a>
</p>

# URL-Shortener

Simple URL shortener

## Installation

For development

1. `git clone git@github.com:Luca-Castelnuovo/url-shortener.git`
2. Edit `.env`
3. `php cubequence app:key`
4. `php cubequence db:migrate`
5. `php cubequence db:seed`
6. Start development server `php -S localhost:8080 -t public`

For deployment

1. `git clone git@github.com:Luca-Castelnuovo/url-shortener.git`
2. `composer install --optimize-autoloader --no-dev`
3. Edit `.env`
4. `php cubequence app:key`
5. `php cubequence db:migrate`

## Security Vulnerabilities

Please review [our security policy](https://github.com/Luca-Castelnuovo/url-shortener/security/policy) on how to report security vulnerabilities.

## License

Copyright © 2020 [Luca Castelnuovo](https://github.com/Luca-Castelnuovo). <br />
This project is [MIT](LICENSE.md) licensed.
