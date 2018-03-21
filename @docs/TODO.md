@todo
=====

##### Page Version Rendering

Case 1: New Page - form 

- Submit
- Create new page Unpublished with new version

- go to version render (zrcms-version/{some-path}/?version={versionId})
- press publish
- find page by path
- create page-resource with version
    
Case 2: Publish Existing draft

- Select draft version

- go to version render (zrcms-version/{some-path}/?version={versionId})
- press publish
- find page by path
- create page-resource with version
    
Case 3: Publish old revision

- Select version

- go to version render (zrcms-version/{some-path}/?version={versionId})
- press publish
- find page by path
- create page-resource with version



##### Add Request Site middleware with attribute

- Add middleware to discover site by request
- Extent attribute from GetSiteByRequest service
- Use Attribute for caching on the request

##### Importer 

- Should use fields bit (warnings ONLY)
- Split into indiviual APIs

##### Block data providers service aliases 

- should we use alias and allowed service names (scrap aliases)

##### Component Simplify 

- Find service that end in "Basic" that determine the service to use and rename to ByStrategy

##### Write implementation test

- for each content type (Container with block, Page, Site, ThemeLayout, View)
- Get components
- create content
- publish content
- unpublish content
- re-publish content
- find resource and version
    
##### Add IMPLEMENTATION_REQUIRED services where needed 
    
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
