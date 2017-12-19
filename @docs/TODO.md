@todo
=====

##### Component Simplify #####

- See about simplifying all common patterns (content, resource, etc...)?

    - CONFIG EXAMPLE:
        'zrcms-types' => [
            /* Default services and classes are defined here */
            'basic' => [
                BuildComponentObject::class => BuildComponentObjectDefault::class,
                'component-model-interface' => Component::class,
                'component-model-class' => ComponentBasic::class,
            ],
        ],
        
    - Find service that end in "Basic" that determine the service to use and rename to ByStrategy
"javascript": [
    "global:/public/my.js",
    "admin:/public/my-admin.js"
]

#### ToDo ####

- View-head with Block JS and CSS:
    - Use RenderTag in RenderBlockCssTag and RenderBlockJsTag
    

- GetViewByRequest as composite with priority?

- SitePages: Service for getting url list from page, product pages, etc... (site map??)
    - NOTE: this can use FindPageCmsResourcesBy and the existing API when it is written

- view-head
    - allow registering scripts and css for routes or pages
    - allow adding scripts and css for blocks and containers ('zrcms-view-head.head-meta' property in the component)

- Deal with 'zrcms-view-builders'
 
- Start client  - NOTE: Client packages will be built using NPM
    - zrcms-admin
        - zrcms-admin-menu
        - zrcms-{others}
    - zrcms-fields

- Add services to js

- PageDataService or LayoutDataService
    - get all the data for a specific page
    - will need the render tags too
      
- HTTP APIs for each php API
    - core stuff

- Write implementation test
    - for each content type (Container with block, Page, Site, ThemeLayout, View)
    - Get components
    - create content
    - publish content
    - unpublish content
    - re-publish content
    - find resource and version
    
- Add IMPLEMENTATION_REQUIRED services where needed 

- Need a way to clear caches on registries and component configs

- BuildView should use a component, not config
    
- Document the architecture and basics of how it works

- Doctrine FindXXXsBy need to be made to work better with properties
    
- Check and update all composer dependencies

- FindCmsResourceByDateRange, FindContentVersionByDateRange interface
    
Features
--------

##### Fields  #####

- Standard menus for admins using field definitions
- include input-validations defined by a field config - use service aliases
- create js/ui lib
    
Clean up - Refactoring
----------------------

##### GetViewLayoutTags interface could take on Request and use attributes #####

- Might simplify the interface
- View can be an attribute (see Zrcms\HttpViewRender\Request\RequestWithView)
- View does NOT have to be Content can be simple data model
- View could have ->addProperty()

##### Composition over Inheritance #####

- Might decouple a bit
    
    
OPTIMIZATION: api (after FindResourceVersion implemented)
---------------------------------------------------------

- Optimize queries
- Add indexes
- GetViewLayoutTagsBasic - See @todo in class
- view-head
    - reduce loops
    - optimize BC
    - Use const for strings
- Caching
    - Create file caching service (not just array cache)
