Requirements
============

## Server ##

- API driven design

- PHP API functional repositories

- PSR7 Middleware

- Injectable renderers (template engines)

    - mustache as default
    
- Configs should be json files

- Decouple or loose coupling

    - Coupling only to PSR if possible
    
    - Loose coupling to a middle-ware framework
    
- Full tracking of creators and dates

    - Who (userId)
    
    - What (action)
    
    - Why (reason)
    
    - When (date)

    - All content to be immutable and all versions stored
