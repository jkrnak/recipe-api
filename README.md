# Gousto Recipe API

## Decisions

### Docker

Defining requirements for a project with all the dependencies and versions could take up a lot of time while setting up a project.
Using docker allows this project to be isolated and self containing and allows the setup to be controlled. 

### Framework

I chose the Laravel framework to get familiar with it. I haven't used Laravel in the past and this looked like a good opportunity to learn more about it.
The framework is really developer friendly, much more opinionated than Symfony. 
It's really easy to get going with it.

The application is running on PHP 7.1

### Different API consumers

The setup currently injects in a generic transformer for the recipes. This transformer generates the output format which each API consumer gets.
It also converts request bodys to recipes when updating or creating new recipes.

The transformation has an interface so this could be extended into different formats depending on what the consumer wants.
There could be an HTTP request header which states who is the consumer, something like `X-Consumer: mobile` .
A factory then could pick up this header from the request and create the appropriate formatter. This factory could be injected
into the controller.

But if we are expecting a lot of different formats based on client requirements we should probably evaluate using GraphQL 
which then would allow the clients to define their own response formats and what data they want to retrieve.


## Prerequisities

 * docker
 * make
 
> This setup has only been tested on OSX, but should work on *nix operating systems as well. 
For Windows you probably need to set up a few things manually. 

## Available Commands

### Building an Image

To be able to run the application or the tests first you will need to build a docker image of the application.

Run:
```
make build
```

### Running Tests

Run:
```
make test
```

### Running Coding Standards Check

Run:
```
make phpcs
```

### Running The API

Run:
```
make run 
```

This will bind the API to http://0.0.0.0:8000 or if the port is already taken you can make the API bind to any local port.
For example, binding it to port 8181
```
make run PORT=8181
```

## The Endpoints

### Create a Recipe
`POST /api/recipe`

`Content-type: application/json`

Body can be any partial of the following JSON:
```
{
  "title": "My Recipe",
  "description": "some description",
  "calories": 100,
  "fat": 200,
  "protein": 250,
  "carbohydrates": 120,
  "box_type": "vegeterian",
  "slug": "my-recipe",
  "short_title": "",
  "bulletpoint1": "point 1",
  "bulletpoint2": "point 2",
  "bulletpoint3": "point 3",
  "recipe_diet_type_id": "meat",
  "season": "summer",
  "base": "rice",
  "protein_source": "chicken",
  "preparation_time_minutes": 30,
  "shelf_life_days": 3,
  "equipment_needed": "kitchen",
  "origin_country": "UK",
  "recipe_cuisine": "French",
  "in_your_box": [
    "chicken",
    "rice"
  ],
  "gousto_reference": 42
}
```

### Get Recipe by Id

`GET /api/recipe/{id}`

### Get Recipes

`GET /api/recipe?page=1&pageSize=10&criteria[recipe_cuisine]=asian`

### Update Recipe by Id

`PUT /api/recipe/{id}`

`Content-type: application/json`

See the create endpoint for request body example.

### Rate a Recipe

`PUT /api/recipe/{id}/rate`

`Content-type: application/json`

Body:
```
{
    "rating": 5
}
```

For more information on endpoints see the functional test called RecipeControllerTest.
