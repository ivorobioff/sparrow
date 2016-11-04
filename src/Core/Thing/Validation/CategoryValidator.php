<?php
namespace ImmediateSolutions\Core\Thing\Validation;
use ImmediateSolutions\Core\Thing\Services\CategoryService;
use ImmediateSolutions\Support\Validation\AbstractThrowableValidator;
use ImmediateSolutions\Support\Validation\Binder;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoryValidator extends AbstractThrowableValidator
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        // TODO: Implement define() method.
    }
}