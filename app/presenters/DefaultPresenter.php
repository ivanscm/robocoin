<?php
namespace App\Presenters;


use App\Model;

/**
 * Class DefaultPresenter
 * @package App\Presenters
 */
class DefaultPresenter extends BasePresenter
{
    /**
     * @var Model\Comments
     * @inject
     */
    public $commentsModel;

    /**
     * Homepage controller
     */
    public function renderDefault()
    {
        $comments = $this->commentsModel->find(10);
        $this->template->comments = $comments;
        $this->template->commentsSQL = $comments->getQueryString();
    }
}