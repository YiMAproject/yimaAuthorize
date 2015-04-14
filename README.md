yimaAuthorize
=============

[zend framework2, zf2] Authentication

___Login User Programaticly___

```php
/** @var AuthService $auth */
$auth = $this->authorize('yima_authorize.sample');

$auth->getAuthAdapter()->identity()->setUserIdentity('ehsan');
$auth->getAuthAdapter()->identity()->login();

if (!$auth->isAllowed(null, new PermResource(['route_name' => 'contact'])))
    $auth->riseException();

die($auth->getAuthAdapter()->identity()->hasAuthenticated());
```
