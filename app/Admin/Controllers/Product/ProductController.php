<?php

namespace App\Admin\Controllers\Product;

use App\Models\Product\Category;
use App\Models\Product\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('标题'))->editable();
        $grid->column('cate_id', __('分类'))->display(function () {
            $category = Category::find($this->cate_id);
            return $category->name;
        });
        $grid->column('market_price', __('市场价'));
        $grid->column('sale_price', __('销售价'));
        $grid->column('created_at', __('创建时间'))->sortable();
        $grid->column('updated_at', __('更新时间'))->sortable();

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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('sub_title', __('Sub title'));
        $show->field('cate_id', __('Cate id'));
        $show->field('market_price', __('Market price'));
        $show->field('sale_price', __('Sale price'));
        $show->field('thumb', __('Thumb'));
        $show->field('banner_imgs', __('Banner imgs'));
        $show->field('caption_ims', __('Caption ims'));
        $show->field('status', __('Status'));
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
        $form = new Form(new Product());

        $form->text('title', __('标题'))->required();
        $form->text('sub_title', __('副标题'));
        $form->select('cate_id', __('分类'))->options(
            Category::where('pid', '>', 0)->pluck('name', 'id')
        )->required();
        $form->text('market_price', __('市场价'))->required();
        $form->text('sale_price', __('销售价'))->required();
        $form->image('thumb', __('缩略图'))->move('product')->uniqueName()->help('列表页缩略图')->required();
        $form->multipleImage('bannerimgs', __('轮播图'))->move('product')->uniqueName()->help('详情页轮播图')->required();
        $form->multipleImage('captionimgs', __('详情图'))->move('product')->uniqueName()->help('详情页详情图')->required();

        return $form;
    }
}
