Features
========

### Everything as content ###

- Allow the interface for content to be simple

- Content is simply an array of properties and tracking data

    - Allows for 100% over-riding of data in the instance
    
    - Allows for simpler implementation of Content objects
    
    - Allows for virtually arbitrary properties AKA easy to extend functionality
    
- All content is immutable

- Basic architecture

    - Models (immutable)
    
        - CmsResource - Is the holder of the resource info (path, host, id, etc..)
        
        - Content - Represents the content itself
        
        - ContentVersion - Represents the versions of content 
        
     - API
     
        - Action - Doing specific logical things to content
        
        - Render - Involved with rendering
        
        - Repository - DB style interactions
