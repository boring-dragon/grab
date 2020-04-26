# Grab 🔮

Grab is an indexing CLI tool for WordPress API. Built with laravel Zero.

## Installation

Clone the repo.

### Download the dependency

```
composer install
```

### Create database

Make a database.sqlite file inside /database directory or you can use your config to generate the database.

[Laravel zero database](https://laravel-zero.com/docs/database/)



## Usage

Now you are all set to use the application

### Grabbing comments

Comment schema

| Name          | Datatype      |
| ------------- |:-------------:|
| source     | `string` |
| comment_id     | `unsignedInteger`      |
| post_id | `unsignedInteger`       |
| author_name | `string`       |
| comment | `text`       |
| upvotes | `unsignedInteger-nullable`       |
| downvotes | `unsignedInteger-nullable`       |
| date | `timestamp`       |

```bash
php grab fetch:comments {sitename.com}
```
- Example:

```bash
php grab fetch:comments vaahaka.com
```

If the comments are at a different endpoint you can pass in a prefix with <code>--prefix=</code>

```bash
PHP grab fetch:comments addulive.com --prefix=talks
```
Which will correspond to https://addulive.com/wp-json/wp/v2/talks


### Grabbing Posts

Post Schema

| Name          | Datatype      |
| ------------- |:-------------:|
| source     | `string` |
| post_id | `unsignedInteger`       |
| title | `string`       |
| text | `text-nullable`       |
| link | `string`       |

```bash
php grab fetch:posts {sitename.com}
```
- Example:

```bash
php grab fetch:posts vaahaka.com
```

If the posts are at a different endpoint you can pass in a prefix with <code>--prefix=</code>

```bash
PHP grab fetch:posts addulive.com --prefix=talks
```
Which will correspond to https://addulive.com/wp-json/wp/v2/talks


## This is an experimental project. Please don't misuse this application.