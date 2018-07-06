# ZRCMS Server React Block Renderer
This renderer allows ZRCMS blocks to be ReactJS components that render on the serve side on a remote nodeJS server.

# Technical details
The requests to the remote render service API will have bodys that look like:
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

