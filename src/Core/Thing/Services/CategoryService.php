<?php
namespace ImmediateSolutions\Core\Thing\Services;
use ImmediateSolutions\Core\Support\Service;
use ImmediateSolutions\Core\Thing\Entities\Category;
use ImmediateSolutions\Core\Thing\Payloads\CategoryPayload;
use ImmediateSolutions\Core\Thing\Validation\CategoryValidator;
use ImmediateSolutions\Core\User\Entities\User;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoryService extends Service
{
    /**
     * @param int $userId
     * @param CategoryPayload $payload
     * @return Category
     */
    public function create($userId, CategoryPayload $payload)
    {
        (new CategoryValidator($this))->validate($payload);

        $category = new Category();

        $this->exchange($payload, $category);

        /**
         * @var User $user
         */
        $user = $this->entityManager->getReference(User::class, $userId);

        $category->setUser($user);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }

    /**
     * @param int $id
     * @param CategoryPayload $payload
     */
    public function update($id, CategoryPayload $payload)
    {
        (new CategoryValidator($this))->validate($payload);

        /**
         * @var Category $category
         */
        $category = $this->entityManager->find(Category::class, $id);

        $this->exchange($payload, $category);

        $this->entityManager->flush();
    }

    /**
     * @param CategoryPayload $payload
     * @param Category $category
     */
    private function exchange(CategoryPayload $payload, Category $category)
    {
        $this->transfer($payload, $category, 'title');
        $this->transfer($payload, $category, 'parent', function($id){
            /**
             * @var Category $parent
             */
            $parent = $this->entityManager->getReference(Category::class, $id);

            return $parent;
        });
    }

    /**
     * @param int $id
     * @return Category
     */
    public function get($id)
    {
        return $this->entityManager->find(Category::class, $id);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(Category::class)->delete(['id' => $id]);
    }

    /**
     * @param int $userId
     */
    public function getAllRoots($userId)
    {

    }
}