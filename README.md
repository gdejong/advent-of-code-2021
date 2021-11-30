# advent-of-code-2021

If you enjoy the Advent of Code please consider donating to keep the project running.

# CLI

Build:

```shell script
docker-compose build
```

Run:

```shell script
docker-compose run --rm php-cli php cli.php day:01
```

# Xdebug

Run with debugger:

```shell script
docker-compose run --rm php-cli php -dxdebug.mode=debug -dxdebug.start_with_request=yes -dxdebug.client_port=9000 -dxdebug.client_host=192.168.1.38 cli.php day:01
```

In PHPStorm go to Settings > Languages & Frameworks > PHP > Servers and create a new server called `aoc.local`. Setup
the path mapping from your local directory to `/opt/project`.
