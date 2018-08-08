# HOWTO(s)

## Create project

```
composer create-project symfony/website-skeleton my-project
composer require symfony/orm-pack
composer require symfony/maker-bundle --dev
composer require laravel/homestead --dev
```
```
php vendor/bin/homestead make
```

Next, run the `vagrant up` command in your terminal and access your project at  http://homestead.test in your browser. Remember, you will still need to add an /etc/hosts file entry for homestead.test or the domain of your choice.

## Migrations

```$xslt
php bin/console doctrine:database:create
php bin/console make:entity
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

## Fixtures

```$xslt
php bin/console doctrine:fixtures:load
```

## REST bundles

```$xslt
composer require friendsofsymfony/rest-bundle
composer require jms/serializer-bundle
```

JMSSerializer should be registered before rest-bundle

```$xslt
    ...
    JMS\SerializerBundle\JMSSerializerBundle::class => ['all' => true],
    FOS\RestBundle\FOSRestBundle::class => ['all' => true],
```

## Rest API
```
composer require annotations
```

```fos_rest.yaml
fos_rest:
  param_fetcher_listener: true
  body_listener: true
  format_listener:
    enabled: true
    rules:
      - { path: '^/api', priorities: ['json', 'xml'], fallback_format: 'html' }
  versioning: true
  view:
    jsonp_handler: ~
    view_response_listener: 'force'
```

```
class MoviesController extends FOSRestController
{
//    use ControllerTrait;

    /**
     * @Rest\Route("/api/movies", name="api_movies")
     * @Rest\View()
     */
    public function getMoviesAction() {
        $movies = $this->getDoctrine()->getRepository('App:Movie')->findAll();
        $view = $this->view($movies, 200);

        return $this->handleView($view);
    }
}
```

