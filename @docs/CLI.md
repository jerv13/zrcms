Command Line
============

## Examples ##

Doctrine Dump:

```
ENV="local" bin/console orm:schema-tool:update --dump-sql > ./data/0.0.0.sql
```

Doctrine Schema Update:

```
ENV="local" bin/console orm:schema-tool:update --force
```

Exporting from RCM:

```
ENV="local" ./bin/console rcm:export --file ./data/export.json --limit 100 --pp 1
```

Importing to ZRCMS:

```
ENV="local" ./bin/console zrcms:import --file ./data/export.json 
```
