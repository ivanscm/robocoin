<?php
namespace App\Model;

use Nette;

class Users implements Nette\Security\IAuthenticator
{
    use Nette\SmartObject;

    const
        TABLE_NAME_USERS = 'users',
        COLUMN_ID = 'id';
    const ROLE_DEFAULT = 'user';
    /**
     * @var Nette\Database\Context
     */
    private $database;

    /**
     * Users constructor.
     * @param Nette\Database\Context $database
     */
    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    /**
     * Performs an authentication.
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($id, $password) = $credentials;
        $row = $this->database->table(self::TABLE_NAME_USERS)->where(self::COLUMN_ID, $id)->fetch();
        if (!$row) {
            throw new Nette\Security\AuthenticationException('The id is incorrect.', self::IDENTITY_NOT_FOUND);
        }
        $arr = $row->toArray();
        return new Nette\Security\Identity($row[self::COLUMN_ID], self::ROLE_DEFAULT, $arr);
    }

}