<?php

namespace App\Model;

use Nette;

class Comments
{
    const TABLE_NAME_COMMENTS = 'comments';
    const TABLE_NAME_USERS = 'users';

    /**
     * @var Nette\Database\Context
     */
    private $database;

    /**
     * Comments constructor.
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    /**
     * Find last comments for all users
     * @param int $limit Is 0, return all users
     * @return Nette\Database\ResultSet
     */
    public function find($limit = 0)
    {

        if ($limit !== 0) {
            $limit = ' LIMIT ' . $limit;
        } else {
            $limit = '';
        }
        return $this->database->query('SELECT users.name AS user_name, comments.text AS comment FROM users RIGHT JOIN comments ON comments.user_id = users.id GROUP BY users.id ORDER BY comments.id DESC' . $limit);
    }
}