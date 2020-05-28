<p align="center"><a href="https://github.com/CubeQuence/CubeQuence"><img src="https://rawcdn.githack.com/CubeQuence/CubeQuence/855a8fe836989ca40c4e50a889362975eab9ac43/public/assets/images/banner.png"></a></p>

<p align="center">
<a href="https://packagist.org/packages/cubequence/cubequence"><img src="https://poser.pugx.org/cubequence/cubequence/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/cubequence/cubequence"><img src="https://poser.pugx.org/cubequence/cubequence/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/cubequence/cubequence"><img src="https://poser.pugx.org/cubequence/cubequence/license.svg" alt="License"></a>
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
