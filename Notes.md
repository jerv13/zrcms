NOTES
=====

- Hydrators and extractors?
- Handlers for request status
    - This may require our own pipe
    - injectable middleware the says what to do on non-200 status codes
    
- Block instances might need be split from Page 
  (AKA: eliminate Page::getBlockVersions and replace with an API like BlockVersion\Api\FindBlockVersionsBy();
  
- Uri parser (get values from Uri)

## Can all config values and data values be properties ##

Allow for 100% over-riding of data in the instance
Allows for simpler implementation of Content objects
Allows for virtually arbitrary properties AKA easy to extend functionality

## Content states ##

- content 
- content-template
- history
- drafts

- who (userId) - what (action) - why(reason)

## Schema v1 ##

zrcms:site:{{siteId}}:{{resource}}/{{path}}

zrcms:site:1:block/{block-name}

zrcms:site:1:block-instance/{block-instance-id}

zrcms:site:1:container/{container-path}

zrcms:site:1:page/{page-path}

zrcms:site:1:page-app/{page-path}

zrcms:site:1:theme/{theme-name}

zrcms:site:1:theme-layout/{theme-layout-path}


## Issues with content tracking and URIs ##

- It would be possible to have the publish actually apply a web URI path as
  an alias to an ZRCMS URI
  
  /page-name = zrcms:site:1:page:5/page-name

- possible schema

    zrcms:site:{{siteId}}:{{resource}}:{{resourceId}}/{{path}}
    
    zrcms:site:1:block:2/block-name
    zrcms:site:1:block-instance:3/block-name
    zrcms:site:1:container:4/container-name
    zrcms:site:1:page:5/page-name
    zrcms:site:1:layout:6/layout-name
    
    // Maybe if sites had themes
    zrcms:site:1:theme:7/theme-name
    zrcms:theme:7:layout:8/layout-name

## @todo ##

- NOTE: Directory changed to location for components
- Param::getRequired to have custom exceptions
- PropertiesCmsResourcePublishHistory should be specified in each model 
  (I.E.: container should have a PropertiesContainerCmsResourcePublishHistory)
- add <identifier> to comments
- Deal with properties
    - Property definitions need to be defined somehow that is easy to understand from code
    - Property definitions might be injectable or validated

- 
