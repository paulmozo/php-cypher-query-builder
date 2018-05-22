# php-cypher-query-builder
A PHP library for generating Cypher queries to be used with Graph databases such as Neo4J

## NOTES
* Not currently available through packagist
* This is a work in progress and there is still a lot to be done

# Making cypher queries easily using the query builder

```
$client = new QueryBuilder\Client();

echo $client
  ->match('Person', 'person')
  ->match('LIKES')
  ->match('Movie', 'movie')
  ->where('movie', 'name', "=", 'Taxi Driver')
  ->return('movie');
```

Will output the string:

`MATCH (person:Person)-[:LIKES]-(movie:Movie) WHERE movie.name = "Taxi Driver" RETURN movie`

This project makes walking a graph easy. One of the main benefits is that it automatically figures out whether it needs to match a Node or a Relationship.

# Running the tests
`./vendor/bin/phpunit tests/`

# To do on this project
* Support more operators for the where clause
* Add more clauses such as "SET", "CREATE" and "DELETE"
* More exceptions when invalid Cypher is detected
* Make this project available via packagist
