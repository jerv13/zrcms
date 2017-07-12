NOTES
=====

- Hydrators and extractors?
- Handlers for request status
    - This may require our own pipe
    - injectable middleware the says what to do on non-200 status codes
    
- Block instances might need be split from Page 
  (AKA: eliminate Page::getBlockInstances and replace with an API like BlockInstance\Api\FindBlockInstancesBy();
  
- Uri parser (get values from Uri)

## Content states ##

- published 
- unpublished
- deleted

- template

- history
- drafts



/**
 * @var string
 *
 * @ORM\Column(type="string")
 */
protected $sourceUri;




