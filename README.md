# php-cypher-query-builder
A PHP library for generating Cypher queries to be used with Graph databases such as Neo4J

## NOTES
* Not currently available through packagist
* This is a work in progress and there is still a lot to be done

# Making cypher queries easily using the query builder

```
$client = new Moozla\QueryBuilder\Client();

$client
  ->match('Person', 'person')
  ->match('LIKES')
  ->match('Movie', 'movie')
  ->where('movie', 'name', "=", 'Taxi Driver')
  ->return('movie');

echo (string)$client;
```

Will output the string:

`MATCH (person:Person)-[:LIKES]-(movie:Movie) WHERE movie.name = "Taxi Driver" RETURN movie`

This project makes walking a graph easy. One of the main benefits is that it automatically figures out whether it needs to match a Node or a Relationship.

# Running the tests
`./vendor/bin/phpunit tests/`

# To do on this project
* Support more operators for the where clause
* Add more clauses such as "SET", "CREATE" and "DELETE"
* Add Directional relationships support
* More exceptions when invalid Cypher is detected
* Make this project available via packagist

# Examples

For a full list of examples look at the client tests found in `tests/ClientTests/`

## Match Node-relation-Node and return all 3

```
$client = new Moozla\QueryBuilder\Client();

$client
  ->match('Person', 'person')
  ->match('LIKES', 'likes')
  ->match('Movie', 'movie')
  ->return('person')
  ->return('likes')
  ->return('movie');

echo (string)$client;
```

Will output the string:

`MATCH (person:Person)-[likes:LIKES]-(movie:Movie) RETURN person, likes, movie`

## Match Node then add custom CYPHER to all clauses

```
$client = new Moozla\QueryBuilder\Client();

$client
  ->match('Person', 'person')
  ->appendToMatch('-[]->(:CustomMatch)')
  ->appendToWhere('(person)-[:KNOWS]-({name: 'Jeff'})')
  ->appendToReturn('count(person)');

echo (string)$client;
```
Will output the string:

`MATCH (person:Person)-[]->(:CustomMatch) WHERE (person)-[:KNOWS]-({name: 'Jeff'}) RETURN count(person)`

Note: All of the 'appendTo' methods will simply append the given string to the specified clause allowing for CYPHER not directly supported through the other query builder methods
