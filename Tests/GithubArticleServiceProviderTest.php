<?php
/*
 * Author; Cameron Manderson <cameronmanderson@gmail.com>
 */

namespace MMB\Github\Tests;

class GithubArticleServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetList()
    {
        $github = new \MMB\Github\GithubArticleService();
        $github->setRepository('mmb-github-example');
        $github->setUser('cammanderson');
        $results = $github->listArticles();
        $this->assertNotEmpty($results);
    }

    public function testGetArticle()
    {
        $github = new \MMB\Github\GithubArticleService();
        $github->setProvider(new \MMB\Markdown\MarkdownArticleProvider(new \MMB\Markdown\Parsedown\StylisedParsedown()));
        $github->setRepository('mmb-github-example');
        $github->setUser('cammanderson');
        $results = $github->listArticles();
        $result = $github->getArticle($results[0]);
        $this->assertNotEmpty($result);
        $this->assertTrue(get_class($result) == 'MMB\Markdown\MarkdownArticle');
    }
}