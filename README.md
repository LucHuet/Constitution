
# Constitution

This code is a personnal project simulating the writing of a state constitution.
The user can create actors, give them powers, designations and can make them
controle each others.
There is events to check that the written constitution is solid enough to be
used by a real country.

**Technical stack**
Symfony 4
React JS
Semantic UI
Webpack Encore


## Getting Started

**Setup parameters.yml**

First, make sure you have configured `.env` or `.env.local`
file (you should). If you don't, copy `env.dist`
to get the file and then configure the `DATABASE_URL` parameter.

Next, look at the configuration and make any adjustments you
need (like `database_password`).

**Download Composer dependencies**

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```
composer install
```

You may alternatively need to run `php composer.phar install`, depending
on how you installed Composer.

**Setup the Database**

Again, make sure `.env` is setup
for your computer. Then, create the database and the
schema!

```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

If you get an error that the database exists, that should
be ok. But if you have problems, completely drop the
database (`doctrine:database:drop --force`) and try again.

**Start the built-in web server**

You can use Nginx or Apache, but the built-in web server works
great:

```
php bin/console server:run
```

Now check out the site at `http://localhost:8000`

## Authors

* **Luc HUET** and **Marguerite FAY**

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
