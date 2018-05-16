Command Line
============

## Examples ##

Doctrine Dump:

```
ENV="local" bin/console orm:schema-tool:update --dump-sql > ./data/0.0.0.sql
```

Doctrine Schema Update:

``` 
#Turn RCM compat OFF first!
ENV="local" bin/console orm:schema-tool:update --force
```

Exporting from RCM:

``` 
#Turn RCM compat OFF first!
ENV="local" ./bin/console rcm:export --file ./data/rcm-data.json

# OR limit to a list of siteIds:
ENV="local" ./bin/console rcm:export --file ./data/rcm-data.json --siteIds "[1,3,10,21,1065]"

# OR with more options:
# ENV="local" ./bin/console rcm:export --file ./data/rcm-data.json --limit 100 --pp 1
```

Importing to ZRCMS:

```
ENV="local" ./bin/console zrcms:import --file ./data/rcm-data.json 
```
