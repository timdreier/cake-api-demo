# Cake-API Demo

This is a Demo project to show how to create a simple API using [Symfony](https://symfony.com) and [API Platform](https://api-platform.com).

This project consists of two branches:
* `main`: Contains the basic setup of the project and all files created during the tutorial.
* `empty`: Contains only the basic setup of the project and the tutorial.

## Prerequisites
You need to install the following tools to run this project:

- 🐳 [Docker](https://www.docker.com/get-started)
- 💻 [Task](https://taskfile.dev/installation/) (optional)

## Getting Started
First, create a Folder `api` the project folder. This folder will contain the Symfony project.

```
Before you start, you need to start the Docker containers:
```
task run

# without task: docker compose up -d
```

Since the project is using Docker, all commands in this project need to be run inside the Docker container. You can run the following command to enter the container:

```
task shell

# without task: docker-compose exec -it php bash
```


## Basic Setup
```
# Create new Symfony project
composer create-project symfony/skeleton:"7.1.*" api

# Change to Symfony project directory
cd api

# Install API Platform and ORM Pack (answer no to all questions)
composer require api symfony/orm-pack

# Install Maker Bundle (helps to generate code)
composer require --dev symfony/maker-bundle
```

Configure the database connection in the `.env` file:
```
DATABASE_URL="mysql://root:mariadb@db:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

Change the response format of the API to JSON instead of JSON-LD in `config/packages/api_platform.yaml`:
```
    formats:
        json: ['application/json']
    docs_formats:
        json: ['application/json']
        jsonopenapi: ['application/vnd.openapi+json']
        html: ['text/html']
```

Create the database and the schema:
```
php bin/console doctrine:database:create
```

## Create the first entity

Create your first entity. This will be the `Cake` entity and the `CakeRepository` repository:
```
php bin/console make:entity
```

<details>
    <summary>Full Log</summary>

    Class name of the entity to create or update (e.g. TinyPuppy):
    > Cake
    
    Mark this class as an API Platform resource (expose a CRUD API for it) (yes/no) [no]:
    > yes
    
    created: src/Entity/Cake.php
    created: src/Repository/CakeRepository.php
    
    Entity generated! Now let's add some fields!
    You can always add more fields later manually or by re-running this command.
    
    New property name (press <return> to stop adding fields):
    > title
    
    Field type (enter ? to see all types) [string]:
    > string
    
    Field length [255]:
    >
    
    Can this field be null in the database (nullable) (yes/no) [no]:
    > no
    
    updated: src/Entity/Cake.php
    
    Add another property? Enter the property name (or press <return> to stop adding fields):
    >

    Success!

    Next: When you're ready, create a migration with php bin/console make:migration
</details>

Migrate the database:
```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Create your first (virtual) cake 🎂

🔗 Open your browser and go to http://localhost:8000/api. You should see your first API endpoints.

Create a new Cake using the `POST:/api/cakes endpoint`:
```
{
  "title": "Brownies"
}
```

After creating the Cake, you can see it in the `GET:/api/cakes` endpoint.

## Creating relationships between entities

Create a new entity called `Rating`:
```
php bin/console make:entity
```

<details>
    <summary>Full Log</summary>

    Class name of the entity to create or update (e.g. FierceKangaroo):
    > Rating
    
    Mark this class as an API Platform resource (expose a CRUD API for it) (yes/no) [no]:
    > yes
    
    created: src/Entity/Rating.php
    created: src/Repository/RatingRepository.php
    
    Entity generated! Now let's add some fields!
    You can always add more fields later manually or by re-running this command.
    
    New property name (press <return> to stop adding fields):
    > cake
    
    Field type (enter ? to see all types) [string]:
    > relation
    
    What class should this entity be related to?:
    > Cake
    
    What type of relationship is this?
     ------------ ------------------------------------------------------------------- 
    Type         Description
     ------------ ------------------------------------------------------------------- 
    ManyToOne    Each Rating relates to (has) one Cake.                             
    Each Cake can relate to (can have) many Rating objects.
    
    OneToMany    Each Rating can relate to (can have) many Cake objects.            
    Each Cake relates to (has) one Rating.
    
    ManyToMany   Each Rating can relate to (can have) many Cake objects.            
    Each Cake can also relate to (can also have) many Rating objects.
    
    OneToOne     Each Rating relates to (has) exactly one Cake.                     
    Each Cake also relates to (has) exactly one Rating.
     ------------ ------------------------------------------------------------------- 
    
    Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
    > ManyToOne
    
    Is the Rating.cake property allowed to be null (nullable)? (yes/no) [yes]:
    > no
    
    Do you want to add a new property to Cake so that you can access/update Rating objects from it - e.g. $cake->getRatings()? (yes/no) [yes]:
    > yes
    
    A new property will also be added to the Cake class so that you can access the related Rating objects from it.
    
    New field name inside Cake [ratings]:
    >
    
    Do you want to activate orphanRemoval on your relationship?
    A Rating is "orphaned" when it is removed from its related Cake.
    e.g. $cake->removeRating($rating)
    
    NOTE: If a Rating may *change* from one Cake to another, answer "no".
    
    Do you want to automatically delete orphaned App\Entity\Rating objects (orphanRemoval)? (yes/no) [no]:
    > yes
    
    updated: src/Entity/Rating.php
    updated: src/Entity/Cake.php
    
    Add another property? Enter the property name (or press <return> to stop adding fields):
    > taste
    
    Field type (enter ? to see all types) [string]:
    > integer
    
    Can this field be null in the database (nullable) (yes/no) [no]:
    > yes
    
    updated: src/Entity/Rating.php
    
    Add another property? Enter the property name (or press <return> to stop adding fields):
    > look
    
    Field type (enter ? to see all types) [string]:
    > integer
    
    Can this field be null in the database (nullable) (yes/no) [no]:
    > yes
    
    updated: src/Entity/Rating.php
    
    Add another property? Enter the property name (or press <return> to stop adding fields):
    >
    
    Success!
    
    Next: When you're ready, create a migration with php bin/console make:migration
</details>

Migrate the database:
```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

## Create the first rating for your Cake

🔗 Open your browser and go to http://localhost:8000/api. You should now see the additional endpoints for the `Rating` entity.

Create a new Rating using the `POST:/api/ratings endpoint`:
```
{
  "cake": "/api/cakes/1",
  "taste": 10,
  "look": 10
}
```

## Filter the ratings by cake

Add the following annotation to the `Rating` entity after the `#[ApiResource]` annotation:

```
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'price' => 'exact', 'description' => 'partial'])]
```

🔗 Open your browser and go to http://localhost:8000/api. You should now be able to filter the ratings by cake.

## Restricting API methods

By default, API Platform adds a default set of HTTP methods. Since we never want to delete a cake, we can remove the DELETE method. This can be done by explicitly defining the methods we want to use.
Add the following annotation to the `Cake` entity after the `#[ApiResource]` annotation:

```
#[Get]
#[GetCollection]
#[Post]
#[Put]
#[Patch]
```

🔗 Open your browser and go to http://localhost:8000/api. You will see that only the methods we defined are available.

## Limit the properties returned by the API

Currently the `GET` endpoints for the `Cake` entity return the id, title and ratings of the cake.
To minimize data returned, we can limit the properties returned by the API.

To do so, we need to modify the #[ApiResource] annotation in the `Cake` entity:
```
#[ApiResource(
    normalizationContext: ['groups' => ['cake:read']],
    denormalizationContext: ['groups' => ['cake:write']],
)]
```

And add the following annotations to the `$id` and the `$title` Attribute of the `Cake` entity:
```
#[Groups(['cake:read'])]
private ?int $id = null;
    
#[Groups(['cake:read', 'cake:write'])]
private ?string $title = null;
```

🔗 Open your browser and go to http://localhost:8000/api. You will see that only the id and title are returned in the `GET` endpoints for the `Cake` entity.