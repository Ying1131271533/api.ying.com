FORMAT: 1A

# ying-api

# AppHttpControllersTestController

## 注册用户 [POST /api/in]
使用 `username` 和 `password` 注册用户。

+ Request (application/json)
    + Body

            {
                "username": "foo",
                "password": "bar"
            }

+ Response 200 (application/json)
    + Body

            {
                "id": 10,
                "username": "foo"
            }

+ Response 422 (application/json)
    + Body

            {
                "error": {
                    "username": [
                        "Username is already taken."
                    ]
                }
            }