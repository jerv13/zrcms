@todo
=====

Page duplicate URL - warn on client
Render unpublished page for admin /admin-tools/

/{some-path}/?version={versionId}

Case 1: New Page - form 

- Submit
- Create new page Unpublished with new version

- go to version render (zrcms-version/{some-path}/?version={versionId})
- press publish
- find page by path
- upsert page-resource with version
    
Case 2: Publish Existing draft

- Select draft version

- go to version render (zrcms-version/{some-path}/?version={versionId})
- press publish
- find page by path
- upsert page-resource with version
    
Case 3: Publish old revision

- Select version

- go to version render (zrcms-version/{some-path}/?version={versionId})
- press publish
- find page by path
- upsert page-resource with version


Veiw modes

'current-page-version': true
'current-page-version': true

##### Version Validations

- Use field validators (verify)

##### Render page drafts and specific versions

##### Fields - not default field

- Remove all 'default'
- remove thing that builds default for validator
- check usages of existing

##### HTTP APIs for each php API

- http-api module should be able to support all common APIs that have interfaces
- Create unique validators for upsert and insert
- Do component dynamic - to allow different access for different types?

- do proper validations for content base on fields ValidateContentVersionData->properties
- IF ContentVersion ID is set, then we can ignore all validations for Upsert (verify how this works at the php api layer)
- consider moving property validation back to the php api layer

##### Importer 

- Should use fields bit (warnings ONLY)
- Split into indiviual APIs

##### Start client  - NOTE: Client packages will be built using NPM

- zrcms-application-state
    -x expose some state values to the client
    - redux compatible
    - fetchZrcmsState action
    - refreshZrcmsState action
- zrcms-admin
    - zrcms-admin-menu
    - zrcms-{others}
- field-rat-fields

##### Block data providers service aliases 

- should we use alias and allowed service names (scrap aliases)

##### Component Simplify 

See about simplifying all common patterns (content, resource, etc...)?

- CONFIG EXAMPLE:
    'zrcms-implementations' => [
        /* Default services and classes are defined here */
        'site' => [
            BuildComponentObject::class => BuildComponentObjectDefault::class,
            'component-model-interface' => Component::class,
            'component-model-class' => ComponentBasic::class,
        ],
    ],
    
- Find service that end in "Basic" that determine the service to use and rename to ByStrategy

##### GetViewByRequest as composite with priority or strategy (faster)?

##### Deal with 'zrcms-view-builders'

##### PageDataService or LayoutDataService

- get all the data for a specific page
- will need the render tags too

##### Write implementation test

- for each content type (Container with block, Page, Site, ThemeLayout, View)
- Get components
- create content
- publish content
- unpublish content
- re-publish content
- find resource and version
    
##### Add IMPLEMENTATION_REQUIRED services where needed 

##### BuildView should use a component, not config
    
##### Document the architecture and basics of how it works

##### Doctrine FindXXXsBy need to be made to work better with properties
    
##### Check and update all composer dependencies

##### FindCmsResourceByDateRange, FindContentVersionByDateRange interface

#####  Use FACTORIES instead of 'factories as config'

- cannot over-ride in a reliable way in 'factories as config'

##### RCM Compatibility

- For all createdReasons, add a BC note so we can better track BC stuf
    
Features
--------

##### Fields  #####

- Standard menus for admins using field definitions
- include validation-rats defined by a field config - use service aliases
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
