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
