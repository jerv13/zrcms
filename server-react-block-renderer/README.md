# ZRCMS Server React Block Renderer
This renderer allows ZRCMS blocks to be ReactJS components that render on the server side on a remote nodeJS server.

# Setup
In you app, set the following config key:
```php
<?php
return [
    'zrcmsServerReactBlockRenderer' => [
        'remoteRenderApiUrl' => 'https://HUMAN_PUT_SOMETHING_HERE/zrcms-server-react-block-renderer/render-block'
    ],
];
```

# Technical details
Remote render service request bodies will look like:
```json
{
    "name": "SuggestedProducts",
    "props": {
        "id": "203825",
        "config": {
            "categoryName": "Nutritional Products",
            "productCount": "6",
            "headerText": "Recommended Products"
        },
        "data": [],
        "configJson": "{\"categoryName\":\"Nutritional Products\",\"productCount\":\"6\",\"headerText\":\"Recommended Products\"}"
    }
}
```
Remote render service response bodies will look like:
```json
{
    "html": "<h1>Helloooo There!</h1><p>This is me saying hi.</p>"
}
```

# Future plans:
- Figure out and implement PHP-side caching
