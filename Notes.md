NOTES
=====

- Hydrators and extractors?
- Handlers for request status
    - This may require our own pipe
    - injectable middleware the says what to do on non-200 status codes
    
- Block instances might need be split from Page 
  (AKA: eliminate Page::getBlockInstances and replace with an API like BlockInstance\Api\FindBlockInstancesBy();
  
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

zrcms:site:1:block/block-name // if sites had blocks

zrcms:site:1:block-instance/block-name

zrcms:site:1:container/container-name
zrcms:site:1:page/page-name
zrcms:site:1:layout/layout-name

// Maybe if sites had themes
zrcms:site:1:theme/theme-name
zrcms:theme:7:layout/layout-name

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

There is an issue finding the actual creator of content

@see page/c

CREATE: page/a (content:1:creator:11)
CREATE: page/b (content:2:creator:22)
CREATE: page/c (content:3:creator:33)

Only applies to History and Draft

UPDATE: page/a (content:1:creator:11) -> page/d (content:1:creator:11) (change)
UPDATE: page/b (content:2:creator:22) -> page/a (content:2:creator:22) (change)
UPDATE: page/a (content:2:creator:22) -> page/b (content:2:creator:22) (change)
UPDATE: page/c (content:3:creator:33) -> page/a (content:3:creator:33) (change)
UPDATE: page/a (content:3:creator:33) -> page/a (content:3:creator:33) (delete)
UPDATE: page/a (content:3:creator:33) -> page/a (content:3:creator:33) (restore)
UPDATE: page/a (content:3:creator:33) -> page/c (content:3:creator:33) (change)


Result:

URI:    page/a (content:3:creator:33) 
SOURCE: page/c 
ACTUAL_SOURCE_CONTENT:    (content:3:creator:33) 
PERCEIVED_SOURCE_CONTENT: (content:3:creator:33) 

URI:    page/b (content:2:creator:22) 
SOURCE: page/a 
ACTUAL_SOURCE_CONTENT:    (content:2:creator:22)
PERCEIVED_SOURCE_CONTENT: (content:2:creator:22) 

URI:    page/c (content:2:creator:22) 
SOURCE: page/a 
ACTUAL_SOURCE_CONTENT:    (content:2:creator:22)
PERCEIVED_SOURCE_CONTENT: (content:3:creator:33)

URI:    page/d (content:1:creator:11) 
SOURCE: page/a 
ACTUAL_SOURCE_CONTENT:    (content:1:creator:11)
PERCEIVED_SOURCE_CONTENT: (content:1:creator:11)



/**
 * @var string
 *
 * @ORM\Column(type="string")
 */
protected $sourceUri;


parent::__construct(
    $uri,
    $sourceUri,
    $properties,
    $createdByUserId,
    $createdReason
);

