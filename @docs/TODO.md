@todo
=====

- add <identifier> to comments
- Deal with properties
    - Property definitions need to be defined somehow that is easy to understand from code
    - Property definitions might be injectable or validated
        - if we inject properties objects, the properties could be validated without needing hard coded checks (might not be good)
    - Properties need to be synced between Content and array
    - 
- config factories: Arguments over-ride issue due to config merge

- Layout version might require themeName as property

- Need ViewDataGetters (port or wrap from ZF view helpers):
    - rcmGoogleAnalytics
    - browser-warning.html
    - rcmAdminPanel
    - rcmHtmlEditorOptions
    - basePath
  
- Document the architecture and basics of how it works

- GetRegisterComponentsAbstract needs a default service name, not ReadComponentConfig

- Check all component Properties and config values
    - BLOCKS:
        - RENDERER
        - DATA_PROVIDER
        - ?RENDER_TAGS_GETTER (not currently supported)
        
    - Layout
        - RENDERER
        - RENDER_TAGS_GETTER
        - RENDER_TAG_NAME_PARSER
        
    - ViewRenderTagsGatter
        - RENDER_TAGS_GETTER

- RENAME ViewLayoutTagsGetter to LayoutTag and rearrange code
    - NOTE: the pattern is different so split them @see GetViewRenderTagsBasic
    -x GetContentRenderTags -> GetContentRenderTags
    
    - GetViewRenderTags -> GetLayoutTags
    - ViewLayoutTagsGetter -> LayoutTagsGetter
    - NS ViewLayoutTagsGetter -> LayoutTags
    - VIEW_RENDER_TAGS_GETTER -> RENDER_TAGS_GETTER
    - view-layout-tags-getter -> layout-tags-getter

- Refactor GetRegisterThemeComponentsBasic to use same interfaces as the rest

- Fix caching (cache registry not components)
