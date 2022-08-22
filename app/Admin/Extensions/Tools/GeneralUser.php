<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class GeneralUser extends BatchAction
{
    protected $action;

    public function __construct($action = 1)
    {
        $this->action = $action;
    }

    public function script()
    {
        return <<<EOT

$('{$this->getElementClass()}').on('click', function() {
    $('<form/>', {method: 'POST', action: '/admin/users/create/mail'})
    .append($('<input/>', {type: 'hidden', name: '_token', value: LA.token}))
    .append($('<input/>', {type: 'hidden', name: 'ids', value: $.admin.grid.selected()}))
    .appendTo(document.body)
    .submit();
});

EOT;
    }
}
