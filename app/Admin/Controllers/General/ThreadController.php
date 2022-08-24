<?php

namespace App\Admin\Controllers\General;

use App\Models\Hub;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ThreadController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Threads';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Hub());

        $grid->column('id');
        $grid->column('thread_name', __('Thread name'));
        $grid->column('thread_id', __('Thread ID'));
        $grid->column('thread_category_type', __('Thread category'))
            ->display(function ($thread_category_type) {
                return $thread_category_type . ' &rarr; ' . $this->thread_category;
            });
        $grid->column('user_email', __('Email'));
        $grid->column('is_enabled', __('is enabled'))->bool();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->equal('thread_name');
            $filter->equal('thread_id');
        });

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
        $show = new Show(Hub::findOrFail($id));
        $flags = [
            0 => 'false',
            1 => 'true'
        ];

        $show->field('thread_name', __('Thread name'));
        $show->field('thread_id', __('Thread ID'));
        $show->field('thread_category_type', __('Thread category type'));
        $show->field('thread_category', __('Thread category'));
        $show->field('user_email', __('Email'));
        $show->field('is_enabled', __('is enabled'))->as(function ($is_enabled) use ($flags) {
            return "$flags[$is_enabled]";
        });
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
        $form = new Form(new Hub());

        $form->text('thread_name', __('Thread name'));
        $form->textarea('thread_id', __('Thread ID'));
        $form->select('thread_category_type', __('Thread category type'))->options([
            '学科' => '学科', '学年' => '学年', '部活' => '部活', '授業' => '授業', '就職' => '就職'
        ]);
        $form->select('thread_category', __('Thread category'))->options([
            'IS科' => 'IS科', 'IN科' => 'IN科', 'IC科' => 'IC科', 'ID科' => 'ID科', 'IM科' => 'IN科',
            '1年生' => '1年生', '2年生' => '2年生', '3年生' => '3年生', '4年生' => '4年生',
            'HxSコンピュータ部' => 'HxSコンピュータ部',
            'キャリア科目' => 'キャリア科目',
            '2022年度' => '2022年度'
        ]);
        $form->email('user_email', __('Email'));
        $form->switch('is_enabled', __('is enabled'))->default(1);

        return $form;
    }
}
