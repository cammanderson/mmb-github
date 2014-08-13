<?php
/*
 * Author; Cameron Manderson <cameronmanderson@gmail.com>
 */
namespace MMB\Github;

use MMB\AbstractArticleService;
use Github\Client;

class GithubArticleService extends AbstractArticleService
{
    protected $user;
    protected $repository;
    protected $reference = 'master';
    protected $pathPrefix = '';

    protected $authMethod;
    protected $authUserToken;
    protected $authPassword;

    protected $match = '/(\d{2,4})[_\/\-]+(\d{2})[_\/\-]+(\d{2})[_\/\-]+(.+\.md)$/i';

    public function __construct($user = null, $repository = null, $reference = null)
    {
        $this->reference = $reference;
        $this->repository = $repository;
        $this->user = $user;
    }

    public function getArticle($key)
    {
        // Obtain the file directly
        try {
            if(!preg_match($this->match, $key))
                throw new \Exception('Restricted by configuration');
            $result = $this->getClient()->api('repo')->contents()->download($this->user, $this->repository, $this->prefix($key), $this->reference);

            return $this->provider->provide($key, $result);
        } catch (\Exception $e) {
            throw new \MMB\ArticleNotFoundException();
        }
    }

    public function listArticles()
    {
        $articles = array();
        foreach($this->index() as $articlePath) {
            $result = $this->getClient()->api('repo')->contents()->download($this->user, $this->repository, $this->prefix($articlePath), $this->reference);
            $articles[$articlePath] = $this->provider->provide($articlePath, $result);
        }
        krsort($articles);

        return $articles;
    }

    /**
     * Index the repository for markdown content
     * @param $articles
     * @param $path
     */
    protected function index($path = '')
    {
        $articles = array();
        $results = $this->getClient()->api('repo')->contents()->show($this->user, $this->repository, $this->prefix($path), $this->reference);
        foreach ($results as $result) {
            switch ($result['type']) {
                case 'file':
                    if (preg_match($this->match, $result['path'])) {
                        $articles[] = $result['path'];
                    }
                    break;
                case 'dir':
                    // Recurse
                    array_merge($articles, $this->index($result['path']));
                    break;
            }
        }

        return $articles;
    }

    protected function prefix($path)
    {
        if(!trim($this->pathPrefix)) return $path;
        // Always expect path to start with a slash
        return (trim($this->pathPrefix) && substr($this->pathPrefix, -1) == '/' ? substr($this->pathPrefix, 0, -1) : $this->pathPrefix) .
            (trim($path) && substr($path, 0, 1) != '/' ? '/' . $path : $path);
    }

    protected function getClient()
    {
        if (empty($this->client)) {
            // TODO: Implement the caching as required as configuration
            $this->client = new Client(new \Github\HttpClient\CachedHttpClient(array('cache_dir' => '/tmp/github-api-cache')));

            // Authenticate
            if (trim($this->authUserToken)) {
                $this->client->authenticate($this->authUserToken, $this->authPassword, $this->authMethod);
            }

        }

        return $this->client;
    }

    /**
     * @param mixed $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $authMethod
     */
    public function setAuthMethod($authMethod)
    {
        $this->authMethod = $authMethod;
    }

    /**
     * @param mixed $authPassword
     */
    public function setAuthPassword($authPassword)
    {
        $this->authPassword = $authPassword;
    }

    /**
     * @param mixed $authUserToken
     */
    public function setAuthUserToken($authUserToken)
    {
        $this->authUserToken = $authUserToken;
    }

    /**
     * @param string $match
     */
    public function setMatch($match)
    {
        $this->match = $match;
    }

    /**
     * @param string $pathPrefix
     */
    public function setPathPrefix($pathPrefix)
    {
        $this->pathPrefix = $pathPrefix;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getAuthMethod()
    {
        return $this->authMethod;
    }

    /**
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->authPassword;
    }

    /**
     * @return mixed
     */
    public function getAuthUserToken()
    {
        return $this->authUserToken;
    }

    /**
     * @return string
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @return string
     */
    public function getPathPrefix()
    {
        return $this->pathPrefix;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

}
