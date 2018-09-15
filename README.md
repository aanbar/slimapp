# slimapp

## Usage
```bash
$ git clone https://github.com/aanbar/slimapp [app_name]
$ cd [app_name]
$ composer install
$ rm -rf .git
```

## Includes
- Auto resolve controllers in routes using: ``ControllerName:Method``
- Support .env files
- Views using Twig
- Flash messages package already setup in views
- Models using eloquent + database instance already injected in container to allow access using ``$this->db``
- Form validation using [Respect](https://github.com/respect/validation)
- Validation errors & old input data are injected into views automatically
- Built-in authentication system with Auth & Guest Middleware
- Automatic Csrf check with `csrf.field` in twig views + custom exclusion list in middleware 