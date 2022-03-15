<?php

namespace App\Admin\Controllers\Product;

use App\Models\Product\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('id', __('ID'));
        $grid->column('thumb', __('缩略图'))->image('/uploads', 50, 50);
        $grid->column('pid', __('父类'))->display(function () {
            if ($this->pid) {
                $category = Category::find($this->pid);
                return $category?$category->name:'';
            }
        });
        $grid->column('name', __('名称'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('pid', __('Pid'));
        $show->field('name', __('Name'));
        $show->field('label', __('Label'));
        $show->field('thumb', __('Thumb'));
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
        $form = new Form(new Category());

        $form->select('pid', __('父类'))->options(
            Category::where('pid', null)->pluck('name', 'id')
        );
        $form->text('name', __('名称'));
        $form->image('thumb', __('分类图片'))->move('category')->uniqueName();

        return $form;
    }
}
