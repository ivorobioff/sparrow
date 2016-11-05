<?php
namespace ImmediateSolutions\Core\Thing\Services;
use ImmediateSolutions\Core\Support\Service;
use ImmediateSolutions\Core\Thing\Entities\Category;
use ImmediateSolutions\Core\Thing\Payloads\CategoryPayload;
use ImmediateSolutions\Core\Thing\Validation\CategoryValidator;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Core\User\Services\UserService;

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
        /**
         * @var User $user
         */
        $user = $this->entityManager->find(User::class, $userId);

        /**
         * @var UserService $userService
         */
        $userService = $this->container->get(UserService::class);

        (new CategoryValidator($userService, $user))->validate($payload);

        $category = new Category();

        $this->exchange($payload, $category);

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
        /**
         * @var Category $category
         */
        $category = $this->entityManager->find(Category::class, $id);

        /**
         * @var UserService $userService
         */
        $userService = $this->container->get(UserService::class);

        (new CategoryValidator($userService, $category))->validate($payload, true);

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
     * @return Category[]
     */
    public function getAll($userId)
    {
        return $this->entityManager->getRepository(Category::class)
            ->findBy(['user' => $userId]);
    }

    /**
     * @param int $userId
     * @return Category[]
     */
    public function getAllRoots($userId)
    {
        return $this->entityManager->getRepository(Category::class)
            ->findBy(['parent' => null, 'user' => $userId]);
    }
}