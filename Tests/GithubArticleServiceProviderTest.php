<?php
/*
 * Author; Cameron Manderson <cameronmanderson@gmail.com>
 */

namespace MMB\Github\Tests;

use MMB\Article;
use MMB\ArticleProviderInterface;
use MMB\Github\GithubArticle;

class GithubArticleServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetList()
    {
        $github = new \MMB\Github\GithubArticleService();
        $github->setProvider(new MockArticleProvider());
        $github->setRepository('mmb-github-example');
        $github->setUser('cammanderson');
        $results = $github->getArticles();
        $this->assertNotEmpty($results);
        $result = current($results);
        $this->assertTrue(get_class($result) == 'MMB\Github\Tests\DummyArticle');
    }

    public function testGetArticle()
    {
        $github = new \MMB\Github\GithubArticleService();
        $github->setProvider(new MockArticleProvider());
        $github->setRepository('mmb-github-example');
        $github->setUser('cammanderson');
        $results = $github->getArticles();
        $this->assertNotEmpty($results);
        $firstResult = current($results);
        $result = $github->getArticle($firstResult->getKey());
        $this->assertNotEmpty($result);
        $this->assertTrue(get_class($result) == 'MMB\Github\Tests\DummyArticle');
    }

    public function testObtainArticleMeta()
    {
        $github = new \MMB\Github\GithubArticleService();
        $github->setProvider(new MockArticleProvider());
        $github->setRepository('mmb-github-example');
        $github->setUser('cammanderson');
        $result = $github->getArticle('2014-08-12_Hello-world.md');
        print_r($result);
        $this->assertTrue(date('Y-m-d', $result->getPublished()->getTimestamp()) == date('Y-m-d', strtotime('2014-08-11')));
    }
}

class MockArticleProvider implements ArticleProviderInterface
{
    /**
     * @param $key
     * @param $path
     * @return \MMB\Article
     */
    public function provide($key, $content)
    {
        return new DummyArticle($key, $content);
    }
}

class DummyArticle extends GithubArticle {


    function __construct($key, $content)
    {
        $this->key = $key;
        $this->content = $content;
    }
}