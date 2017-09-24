<?php
namespace App\Presenters;


use App\Model;

class DefaultPresenter extends BasePresenter
{
    /**
     * @var Model\Comments
     * @inject
     */
    public $commentsModel;

    public function renderDefault()
    {
        $comments = $this->commentsModel->find(10);
        $this->template->comments = $comments;
        $this->template->commentsSQL = $comments->getQueryString();
    }
}