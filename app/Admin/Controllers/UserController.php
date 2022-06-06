<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Admin\Extensions\Tools\GeneralUser;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->add(__('Send Mail'), new GeneralUser(1));
            });
        });

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('email_verified_at', __('Email verified at'));
        $grid->column('password', __('Password'));
        $grid->column('two_factor_secret', __('Two factor secret'));
        $grid->column('two_factor_recovery_codes', __('Two factor recovery codes'));
        $grid->column('two_factor_confirmed_at', __('Two factor confirmed at'));
        $grid->column('remember_token', __('Remember token'));
        $grid->column('current_team_id', __('Current team id'));
        $grid->column('profile_photo_path', __('Profile photo path'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('two_factor_secret', __('Two factor secret'));
        $show->field('two_factor_recovery_codes', __('Two factor recovery codes'));
        $show->field('two_factor_confirmed_at', __('Two factor confirmed at'));
        $show->field('remember_token', __('Remember token'));
        $show->field('current_team_id', __('Current team id'));
        $show->field('profile_photo_path', __('Profile photo path'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->textarea('two_factor_secret', __('Two factor secret'));
        $form->textarea('two_factor_recovery_codes', __('Two factor recovery codes'));
        $form->datetime('two_factor_confirmed_at', __('Two factor confirmed at'))->default(date('Y-m-d H:i:s'));
        $form->text('remember_token', __('Remember token'));
        $form->number('current_team_id', __('Current team id'));
        $form->text('profile_photo_path', __('Profile photo path'));

        $form->saving(function (Form $form) {
            $form->password = Hash::make($form->password);
        });

        return $form;
    }
}
