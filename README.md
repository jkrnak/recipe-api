# Gousto Recipe API

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