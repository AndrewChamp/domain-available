#Domain Available

Checks if a domain is registered.  Run this on a CRON and it'll email you when a domain is available.

##How To Use
```php
$domains[] = 'andrewchamp.com';
$domains[] = 'sudomedia.com';
$domains[] = 'thisdomainisprobablyavailable.com';
$domains[] = 'asdfasdfkdkjsks.com';
$available = new available($domains, 'you@youremail.com');

```
