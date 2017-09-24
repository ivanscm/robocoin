<?php
namespace Test;


$container = require __DIR__ . '/bootstrap.php';

use App\Model\Comments;
use Nette;
use Tester;


/**
 * @testCase
 */
class CommentsTest extends Tester\TestCase
{
    function testFindAll()
    {
        global $container;
        /**
         * @var $comments Comments
         */
        $comments = $container->getByType('App\Model\Comments');
        Tester\Assert::true($comments->find() instanceof Nette\Database\ResultSet);
    }
}


(new CommentsTest())->run();
