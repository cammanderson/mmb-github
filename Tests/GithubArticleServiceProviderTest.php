<?php
/*
 * Author; Cameron Manderson <cameronmanderson@gmail.com>
 */

namespace MMB\Github\Tests;

use MMB\Article;
use MMB\Markdown\Parsedown\StylisedParsedown;
use MMB\ArticleProviderInterface;

class GithubArticleServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetList()
    {
        $github = new \MMB\Github\GithubArticleService();
        $github->setProvider(new MockArticleProvider());
        $github->setRepository('mmb-github-example');
        $github->setUser('cammanderson');
        $results = $github->listArticles();
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
        $results = $github->listArticles();
        $this->assertNotEmpty($results);
        $firstResult = current($results);
        $result = $github->getArticle($firstResult->getKey());
        $this->assertNotEmpty($result);
        print get_class($result);
        $this->assertTrue(get_class($result) == 'MMB\Github\Tests\DummyArticle');
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

class DummyArticle extends Article {


    function __construct($key, $content)
    {
        $this->key = $key;
        $this->content = $content;
    }
}