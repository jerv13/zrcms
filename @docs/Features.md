Features
========

### Everything as content ###

- Allow the interface for content to be simple
- Content is simply an array of properties and tracking data
    - Allows for 100% over-riding of data in the instance
    - Allows for simpler implementation of Content objects
    - Allows for virtually arbitrary properties AKA easy to extend functionality
- Basic architecture
    - CmsResource - Is the holder of the resource ID and info (path, host, id, etc..)
    - ContentVersion (immutable) - Represents the versions of content as arbitrary properties
    - CmsResourceHistory - Log of all changes to a resource
    
### Trackable content ###

- All changes are tracked
- All content is create ONLY (immutable)
        
### Loose Coupling to Frameworks ###

- Not couple directly to any framework
- Utilizes PSR standards

### Flexible/Extensible ###

- Properties can be easily extended without major code changes

### Standardized Fields ###

- Fields for content can be defined simply
- Fields for content have a type that can be tied to validation and rendering of a field
- Content properties can be tied directly to field definitions and utilize the validations

### Client Segregation ###

- Client (JS/HTML) is built separately from server
- Client is able to access field definitions VIA HTTP API

### API Driven ###

- Client interaction is primarily through HTTP APIs
- Application interaction is primarily through PHP API Interfaces

### Data Drive ###

- Most features come from a data source (MySQL)
- Feature are designed to have common API interfaces that do not required the application to know about the data source

### Installable ###

- (TODO) Can be installed on a PHP/Node server environment using install CLI
- (TODO) New components (client and server) can installed from admin screens
