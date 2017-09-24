<?php
namespace App\Model;

use Nette;

class Money
{
    use Nette\SmartObject;

    const TRANSFERS_TABLE_NAME = 'transfers';
    const USERS_TABLE_NAME = 'users';
    const TRANSFER_TYPE_IN = 'in',
        TRANSFER_TYPE_OUT = 'out';

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
     * Find history payments for user
     * @param int $user_id
     * @return Nette\Database\Table\Selection
     */
    public function findHistoryByUser($user_id)
    {
        return $this->database->table(self::TRANSFERS_TABLE_NAME)->where('from_user_id = ? OR to_user_id = ?', [$user_id, $user_id]);
    }

    /**
     * Transfer money between users
     * @param int $from_user_id
     * @param ind $to_user_id
     * @param float $amount
     * @return bool
     */
    public function transfer($from_user_id, $to_user_id, $amount)
    {
        $dateNow = new Nette\Utils\DateTime();
        $amount = number_format($amount, 2, '.', '');
        $this->database->beginTransaction();
        // out
        $this->database->table(self::TRANSFERS_TABLE_NAME)->insert([
            'from_user_id' => $from_user_id,
            'to_user_id' => $to_user_id,
            'type' => self::TRANSFER_TYPE_OUT,
            'amount' => $amount,
            'dt' => $dateNow
        ]);
        if ($from_user_id != 0) {
            $from_user = $this->database->table(self::USERS_TABLE_NAME)->get($from_user_id);
            // check rules
            if (
                ($from_user)
                && ($from_user->balance > 0)
                && ($from_user->balance >= $amount)
            ) {
                $this->database->table(self::USERS_TABLE_NAME)
                    ->where('id', $from_user_id)
                    ->update([
                        'balance' => $from_user->balance - $amount,
                    ]);
            } else {
                $this->database->rollBack();
                return false;
            }
        }
        if ($to_user_id != 0) {
            // TODO: one query
            $to_user = $this->database->table(self::USERS_TABLE_NAME)->get($to_user_id);
            $this->database->table(self::USERS_TABLE_NAME)
                ->where('id', $to_user_id)
                ->update([
                    'balance' => $to_user->balance + $amount,
                ]);
        }
        $this->database->commit();
        return true;
    }
}