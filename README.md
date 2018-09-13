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
- Views using Twig
- Flash messages package already setup in views
- Models using eloquent + database instance already injected in container to allow access using ``$this->db``
