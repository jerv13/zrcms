Install
=======

Install Application
-------------------

@todo Create scripts to build server and setup code

- Install skeleton with core dependencies
- Add config for DB connection (doctrine) config (secrets)
- Test connections
- Create admin account
- Import some default data (or import file) to create sites and pages
- Multi-server syncing: 
    - might use GIT for this
    - might use SFTP or FTP

Install Component
-----------------

@todo Create way to install components

- Composer might be good solution
    
- Need to be able to track version
- Need to be able to make DB changes
    - Install
    - Upgrade
    - Downgrade
    - Delete
- Need multi-server syncing
- Install/Upgrade Concept:
    - verify is an ZRCMS component or select from list (requires registry)
    - If not ZRCMS component, WARNING
    - composer show --latest --format json (get current version of a component)
    - run v.v.v-backup.php if exists for current version
    - record latest or selected version
    - Turn sites off (this is for multi site servers)
    - composer install latest or selected version
    - Run v.v.v-install.php if exists for new component
    - OR Run v.v.v-upgrade.php if version went up 
      (run all for every version between) if exists for existing component
    - OR v.v.v-downgrade.php if version went down
    - Run multi server sync
    - Turn sites back on
    
- Remove Concept:
    - composer show --latest --format json (get current version of a component)
    - run v.v.v-backup.php if exists for current version
    - Turn sites off (this is for multi site servers)
    - run v.v.v-remove.php if exists for current version
    - composer remove package
    - Run multi server sync
    - Turn sites back on
