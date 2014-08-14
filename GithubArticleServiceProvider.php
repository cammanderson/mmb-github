<?php
/*
 * Author; Cameron Manderson <cameronmanderson@gmail.com>
 */
namespace MMB\Github;

use Silex\Application;
use Silex\ServiceProviderInterface;

class GithubArticleServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app An Application instance
     */
    public function register(Application $app)
    {
        $app['article_service'] = $app->share(function ($app) {
                $githubService = new \MMB\Github\GithubArticleService(
                    $app['config']['parameters']['github_user'],
                    $app['config']['parameters']['github_repository'],
                    $app['config']['parameters']['github_reference']
                );

                $githubService->setAuthUserToken($app['config']['parameters']['github_auth_user_token']);
                $githubService->setAuthMethod($app['config']['parameters']['github_auth_method']);
                $githubService->setAuthPassword($app['config']['parameters']['github_auth_password']);
                $githubService->setProvider($app['article_provider']);

                return $githubService;
            });

    }

    /**
     */
    public function boot(Application $app)
    {

    }

}
