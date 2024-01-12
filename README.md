## Paye_test

## Project Description

This aplication is for fetching articles from an external api.

## Project Setup

### Cloning the GitHub Repository

Clone the repository to your local machine by running the terminal command below.

```bash
git clone https://github.com/Oluwablin/paye_test
```

### Setup Database

Create a MySQL database and note down the required connection parameters. (DB Host, Username, Password, Name)

### Install Composer Dependencies

Navigate to the project root directory via terminal and run the following command.

```bash
composer install
```

### Create a copy of your .env file

Run the following command

```bash
cp .env.example .env
```

This should create an exact copy of the .env.example file. Name the newly created file .env and update it with your local environment variables (database connection info and others).

### Laravel Command Usage

Run the following command to fetch articles from external url if it has no limit( five by default), if limit is 20, has only comments etc

```bash
php artisan fetch_articles
```

```bash
php artisan fetch_articles --limit=20
```

```bash
php artisan fetch_articles --has_comments_only
```

```bash
php artisan fetch_articles --limit=20 --has_comments_only
```
