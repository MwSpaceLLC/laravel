# MwSpace <img src="https://laravel.com/img/logotype.min.svg" width="150">

> New package for manage [Laravel](https://laravel.com/).

| PHP Version | Status | Require    | version |
|-------------|--------|------------|---------|
| PHP >=8.2   | @Dev   | Laravel 11 | 1.0     |

> #### Install Library (private repository):

`composer require mwspace/laravel`

###### !!! INSTALL ON FRESH LARAVEL 11 APPLICATION !!!

This command install the latest mwspace/laravel @package.

> #### Init MwSpace Package:

`php artisan mwspace:install`

This command install the skeleton of worker main app.

> #### Configure ENV worker:

```dotenv
APP_NAME
MWSPACE_API_TOKEN
GOOGLE_ANALYTICS
IUBENDA_POLICY_ID
IUBENDA_COOKIE_ID
GOOGLE_SITE_VERIFICATION
LOG_SLACK_WEBHOOK_URL

# If u want disable compress html
# MWSPACE_DISABLE_COMPRESS_HTML=true

```

This env is used on x-mwspace::html component.

----------------------

> MwSpace Api Token REQUIRED

If u want usa media content creation at MwSpace like **posts, pages, contacts and more**, u must subscribe and retrive
your
api token.


----------------------
Thank you for considering contributing to the MwSpace Company! The contribution can be found in
the [MwSpace Website](https://mwspace.com/it).

## Security Vulnerabilities

If you discover a security vulnerability within **mwspace/admin**, please send an e-mail to Dev team
via [dev@mwspace.com](mailto:dev@mwspace.com). All security vulnerabilities will be promptly addressed.

## License

The **mwspace/laravel** is application programming interface licensed under
the [Apache License 2.0](http://www.apache.org/licenses/LICENSE-2.0.txt).
