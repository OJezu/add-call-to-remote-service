OJezu/AddCallToRemoteServiceBundle
==================================

This bundle allows adding calls in container to other services, as
though they were declared there. Allows some decoupling - the hottest
thing in OOP.

Installation
------------
```sh
composer require ojezu/add-call-to-remote-service-bundle
```

Usage
-----

Register this bundle in app/appKernel.php:

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new OJezu\ConfigurableDiscriminationBundle\AddCallToRemoteServiceBundle(),
            // app bundles
            new Acme\TestBundle\ParentBundle(),
            new Acme\TestBundle\ChildABundle(),
            new Acme\TestBundle\ChildBBundle(),
        );
        return $bundles;
    }
}
```

Now, instead of:
```yml
services:
    acme.root_service:
        class: Acme\Services\RootService
        calls:
            - ['registerChildService', ['Foo', '@acme.children.foo']]
            - ['registerChildService', ['Bar', '@acme.children.bar']]
            
    acme.children.foo:
        class: Acme\Services\Children\FooService
        
    acme.children.bar:
        class: Acme\Services\Children\BarService
```

You can do this!
```yml
services:
    acme.root_service:
        class: Acme\Services\RootService
```

```yml
services:
    acme.children.foo:
        class: Acme\Services\Children\FooService
        public: false
        tags:
          - name: 'ojezu.add_call_to_remote_service'
            remote_service: '@acme.root_service'
            method: 'registerChildService'
            argument.0: 'Foo'
            argument.1: '@'
```

```yml
services:
    acme.children.bar:
        class: Acme\Services\Children\BarService
        public: false
        tags:
          - name: 'ojezu.add_call_to_remote_service'
            remote_service: '@acme.root_service'
            method: 'registerChildService'
            argument.0: 'Bar'
            argument.1: '@'
```

`'@'` will resolve to `acme.children.foo` and `acme.children.bar` respectively!

Questions
---------

##### Why `argument.0`, `argument.1` and not an array?

Symfony/DependencyInjector does not support that.

##### Will this load my services when they are unneeded?

No! This bundle modifies only definitions of services in container,
it does not need to (and does not) load referenced services.  

License
-------
MIT
