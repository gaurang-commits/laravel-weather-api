# 🌤️ Laravel Weather Api

## Installation
```bash
composer install
```
change `.env.example` to `.env`
```bash
php artisan key:generate
```
Initialize API documentation for testing
```bash
php artisan l5-swagger:generate
```
## Usage
Intitalize Queue
```bash
php artisan queue:work
```
Pull weather from API
```bash
php artisan pull:weather
```
Serve the application
```bash
php artisan service
```
##### Api Documentation will be accessible at `127.0.0.1:8000/api/documentation`
### Testing

```bash
php artisan test
```
## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Gaurang Sharma](https://github.com/gaurang-commits)

## License
The MIT License (MIT). Please see [MIT license](https://opensource.org/licenses/MIT) for more information.