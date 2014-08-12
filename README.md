Github Article Provider for mmb
==========

Github Article Service for [Minimalist Markdown Blog](https://github.com/cammanderson/mmb) Check-in your blog articles to your github account and make them accessible to your blog.Supports branching strategy, allowing you to configure your local blog to read a separate branch.

## Usage

### Composer

```yaml
{
    "require": {
        "cammanderson/mmb" : "@dev"
        "cammanderson/mmb-github" : "@dev"
    }
}
```

### Update your pimple

```php
// Silex configuration
$app->register(new MMB\ArticleServiceProvider());

// Specify articles to be sourced from github
$app['article_service'] = $app->share(function ($app) {
    $githubService = new \MMB\Github\GithubArticleService('cammanderson', 'mmb-github-example', 'master');
    $githubService->setProvider($app['article_provider']);

    return $githubService;
});
```

### Configuration

- Branch (e.g. look to master)
- Github Authentication (for private github repositories)
- Regular expressions for matching article naming convention

[See example](https://github.com/cammanderson/mmb-github-example)