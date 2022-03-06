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
### Testing

```bash
php artisan test
```
## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email dllop@gnahs.com instead of using the issue tracker.

## Credits

- [Gaurang Sharma](https://github.com/gaurang-commits)

## License
The MIT License (MIT). Please see [MIT license](https://opensource.org/licenses/MIT) for more information.