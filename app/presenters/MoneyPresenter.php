<?php

namespace App\Presenters;

use App\Model;
use Nette;

class MoneyPresenter extends BasePresenter
{
    /**
     * @var Model\Users
     * @inject
     */
    public $users;

    /**
     * @var Model\Money
     * @inject
     */
    public $money;

    /**
     * @var integer
     * @persistent
     */
    public $recipient_id;

    /**
     * @var float
     * @persistent
     */
    public $amount;

    public function startup()
    {
        parent::startup();
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Please log in!', 'red');
            $this->redirect('Sign:in');
        }
    }

    /**
     * Send money form
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSendMoneyForm()
    {
        $form = new Nette\Application\UI\Form();
        $form->addText('recipient_id', 'Recipient User ID')
            ->setAttribute('autocomplete', 'off')
            ->addRule(Nette\Application\UI\Form::PATTERN, 'Need User ID digit value', '[0-9]+')
            ->setRequired('Please type recipient User ID');
        $form->addText('amount', 'Coins for send')
            ->setAttribute('autocomplete', 'off')
            ->addRule(Nette\Application\UI\Form::PATTERN, 'Need decimal format: 9999.00', '\d{1,10}(\.\d{1,2})?')
            ->setRequired('Please type amount coins for send');
        $form->addSubmit('send', 'Send');
        $form->onSuccess[] = [$this, 'onSendMoneySuccess'];
        return $form;
    }

    /**
     * Callback for send money form
     * @param Nette\Application\UI\Form $form
     * @param $values
     */
    public function onSendMoneySuccess(Nette\Application\UI\Form $form, $values)
    {
        $recipient_user = $this->users->get($values->recipient_id);
        $current_user = $this->getUser()->getIdentity();
        if (!$recipient_user) {
            $form->addError('Recipient user not found!');
        }
        if ($recipient_user && ($recipient_user->id === $this->getUser()->id)) {
            $form->addError('Recipient user not allow self!');
        }
        if ($values->amount <= 0) {
            $form->addError('It is impossible to translate zero coins!');
        }
        if ($values->amount > $current_user->balance) {
            $form->addError('Not enough coins on balance!');
        }
        if (!$form->hasErrors()) {
            $this->amount = $values->amount;
            $this->recipient_id = $values->recipient_id;
            $this->template->confirm = [
                'recipient_name' => $recipient_user->name,
                'amount' => $values->amount
            ];
        }
        $this->redrawControl('form');
        $this->redrawControl('nav_menu');
    }

    /**
     * Callback for confirm send money button
     * @param string $name User name
     */
    public function handleConfirmSend($name)
    {
        $is_transfer = $this->money->transfer($this->getUser()->id, $this->recipient_id, $this->amount);
        if ($is_transfer) {
            $this->getUser()->identity->balance = $this->users->get($this->getUser()->id)->balance;
            $this->flashMessage("Transfer of coins to the user {$name} successfully completed!", 'green');
        } else {
            $this->flashMessage("Transfer of coins to the user {$name} failed!", 'red');
        }
        $this->redirect('Default:');
    }

    /**
     * History controller
     */
    public function renderDefault()
    {
        $this->template->history = $this->money->findHistoryByUser($this->getUser()->id);
    }
}