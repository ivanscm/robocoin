<?php
namespace App\Presenters;

use Nette;

class SignPresenter extends BasePresenter
{
    protected function createComponentSignInForm()
    {
        $form = new Nette\Application\UI\Form();
        $form->addText('user_id', 'User ID')
            ->addRule(Nette\Application\UI\Form::PATTERN, 'Need User ID digit value', '[0-9]+')
            ->setRequired('Please type User ID');
        $form->addSubmit('login', 'Login');
        $form->onSuccess[] = [$this, 'signInFormOnSuccess'];
        return $form;
    }

    public function signInFormOnSuccess($form, $values)
    {
        try {
            $this->getUser()->setExpiration('10 minutes');
            $this->getUser()->login($values->user_id, null);
        } catch (Nette\Security\AuthenticationException $e) {
            $form->getPresenter()->flashMessage($e->getMessage(), 'red');
            $this->redirect('this');
        }
        $this->redirect('Default:');
    }

    public function actionOut()
    {
        $this->getUser()->logout();
        $this->flashMessage('Done work! Good look!', 'green');
        $this->redirect('Default:');
    }
}