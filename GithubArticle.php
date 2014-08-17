<?php
/*
 * Author; Cameron Manderson <cameronmanderson@gmail.com>
 */

namespace MMB\Github;

use MMB\AbstractArticle;
use MMB\Meta\AuthoredInterface;
use MMB\Meta\ContributedInterface;
use MMB\Meta\MetaAuthorTrait;
use MMB\Meta\MetaContributorsTrait;
use MMB\Meta\MetaTimestampTrait;
use MMB\Meta\MetaVersionTrait;
use MMB\Meta\TimestampedInterface;
use MMB\Meta\VersionedInterface;

class GithubArticle extends AbstractArticle implements VersionedInterface, TimestampedInterface, AuthoredInterface, ContributedInterface
{
    use MetaVersionTrait, MetaTimestampTrait, MetaAuthorTrait, MetaContributorsTrait;
}
 