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

    $.ajax({
        method: 'post',
        url: '{$this->resource}/mail',
        data: {
            _token:LA.token,
            ids: $.admin.grid.selected(),
            action: {$this->action}
        }
	}).done(function () {
		document.location = '/admin/users/create/mail';
	}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
		console.log(XMLHttpRequest.status);
		console.log(textStatus);
		console.log(errorThrown.message);
	});
});

EOT;
    }
}
