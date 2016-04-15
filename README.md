# gpp-symfony

### Init

```
composer.phar install
./bin/console doctrine:schema:update --force
```

Create Client oAuth :
```
./bin/console gpp:client:create --grant-type="password" --grant-type="refresh_token" --grant-type="token" --grant-type="client_credentials"
```

Get token

```
http://gpp-framework.io/oauth/v2/token?client_id=clientid&client_secret=clientsecret&username=username&password=password&grant_type=password
```

Routing

Get one resource

```
GET http://gpp-framework.io/api/{type}s
params :
    - query : json example =>  {"enabled" => true}
```

Get all resources

```
GET http://gpp-framework.io/api/{type}s
params :
    - query : json example =>  {"enabled" => true}
    - orderby : json example => {"id" => "DESC"}
    - limit : integer
    - page : integer
```

Add an resource

```
POST http://gpp-framework.io/api/{type}
json example =>  {"project" => {"title":"first title", "description": "first description"}}
```

Update an resource

```
PUT http://gpp-framework.io/api/{type}/{id}
json example =>  {"project" => {"title":"modify title", "description": "modify description"}}
```

Delete an resource

```
DELETE http://gpp-framework.io/api/{type}/{id}
```
