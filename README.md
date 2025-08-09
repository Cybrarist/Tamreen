# Tamreen
Tamreen (workout in arabic) is an app that motivate the person to exercise while playing video games, doing chores or anything.
create plan for what you like and keep track of workouts to get better.

# Documentation
Feel free to access the up-to-date documentation from [Here](https://tamreen-docs.cybrarist.com)

# Live App
you can have free access to the app on [Tamreen](https://tamreen.cybrarist.com)

please consider donating to keep the app alive.

## Deployment
feel fre to check the documentation [Tamreen Installation](https://tamreen-docs.cybrarist.com/installation/operating_system)

# Updating
If you updating the system, please run the following command

```text
php artisan tamreen:update
```
## Connect
If you are coming outside github or don't like to use it, feel free to join [Discord](https://discord.com/invite/E54ydZ4MHk).

## Docker
Please check the docker repos to pull the image you prefer [Docker](https://hub.docker.com/r/cybrarist/tamreen)

If you run docker-compose before creating a .env file, it will have created a '.env'.
To fix it, just delete the .env folder and make sure you create your own .env file before running:
```
rm -rf .env
cp .env.example .env
```

Don't forget to also populate the .env file with your own APP_KEY (a random 32 characters string).
