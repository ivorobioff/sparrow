<?php
namespace ImmediateSolutions\Api\Thing\Controllers;
use ImmediateSolutions\Api\Support\Controller;
use ImmediateSolutions\Api\Thing\Processors\CategoriesProcessor;
use ImmediateSolutions\Api\Thing\Serializers\CategorySerializer;
use ImmediateSolutions\Core\Thing\Services\CategoryService;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoriesController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function initialize(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->reply->collection(
            $this->categoryService->getAllRoots($this->session->getUser()->getId()),
            $this->serializer(CategorySerializer::class)
        );
    }

    /**
     * @param CategoriesProcessor $processor
     * @return ResponseInterface
     */
    public function store(CategoriesProcessor $processor)
    {
        $category = $this->categoryService->create(
            $this->session->getUser()->getId(),
            $processor->createPayload()
        );

        return $this->reply->single($category, $this->serializer(CategorySerializer::class));
    }

    /**
     * @param int $categoryId
     * @param CategoriesProcessor $processor
     * @return ResponseInterface
     */
    public function update($categoryId, CategoriesProcessor $processor)
    {
        $this->categoryService->update($categoryId, $processor->createPayload());

        return $this->reply->blank();
    }

    /**
     * @param int $categoryId
     * @return ResponseInterface
     */
    public function show($categoryId)
    {
        return $this->reply->single(
            $this->categoryService->get($categoryId),
            $this->serializer(CategorySerializer::class)
        );
    }

    /**
     * @param int $categoryId
     * @return ResponseInterface
     */
    public function destroy($categoryId)
    {
        $this->categoryService->delete($categoryId);

        return $this->reply->blank();
    }
}