<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Category\CategoryService;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryAlreadyExistsException;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

class CategoryServiceTest extends TestCase
{
    protected $categoryRepositoryMock;
    protected $categoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryRepositoryMock = Mockery::mock(CategoryRepositoryInterface::class);
        $this->categoryService = new CategoryService($this->categoryRepositoryMock);
    }

    public function testCreateCategorySuccess()
    {
        $data = ['name' => 'Electronics'];
        $category = new Category($data);

        $this->categoryRepositoryMock
            ->shouldReceive('getByName')
            ->with($data['name'])
            ->andReturn(null);

        $this->categoryRepositoryMock
            ->shouldReceive('create')
            ->with($data)
            ->andReturn($category);

        $result = $this->categoryService->createCategory($data);

        $this->assertInstanceOf(Category::class, $result);
        $this->assertEquals($data['name'], $result->name);
    }

    public function testCreateCategoryThrowsExceptionWhenCategoryExists()
    {
        $data = ['name' => 'Electronics'];
        $existingCategory = new Category($data);

        $this->categoryRepositoryMock
            ->shouldReceive('getByName')
            ->with($data['name'])
            ->andReturn($existingCategory);

        $this->expectException(CategoryAlreadyExistsException::class);

        $this->categoryService->createCategory($data);
    }

    public function testGetAllCategories()
    {
        $categories = new Collection([new Category(['name' => 'Electronics']), new Category(['name' => 'Books'])]);

        $this->categoryRepositoryMock
            ->shouldReceive('getAll')
            ->andReturn($categories);

        $result = $this->categoryService->getAllCategories();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function testGetCategoryByIdSuccess()
    {
        $category = new Category(['id' => '1', 'name' => 'Electronics']);

        $this->categoryRepositoryMock
            ->shouldReceive('getById')
            ->with('1')
            ->andReturn($category);

        $result = $this->categoryService->getCategoryById('1');

        $this->assertInstanceOf(Category::class, $result);
        $this->assertEquals('Electronics', $result->name);
    }

    public function testGetCategoryByIdThrowsExceptionWhenNotFound()
    {
        $this->categoryRepositoryMock
            ->shouldReceive('getById')
            ->with('1')
            ->andReturn(null);

        $this->expectException(CategoryNotFoundException::class);

        $this->categoryService->getCategoryById('1');
    }

    public function testGetCategoryByNameSuccess()
    {
        $category = new Category(['name' => 'Electronics']);

        $this->categoryRepositoryMock
            ->shouldReceive('getByName')
            ->with('Electronics')
            ->andReturn($category);

        $result = $this->categoryService->getCategoryByName('Electronics');

        $this->assertInstanceOf(Category::class, $result);
        $this->assertEquals('Electronics', $result->name);
    }

    public function testGetCategoryByNameThrowsExceptionWhenNotFound()
    {
        $this->categoryRepositoryMock
            ->shouldReceive('getByName')
            ->with('Electronics')
            ->andReturn(null);

        $this->expectException(CategoryNotFoundException::class);

        $this->categoryService->getCategoryByName('Electronics');
    }

    public function testDeleteCategorySuccess()
    {
        $category = new Category(['id' => '1', 'name' => 'Electronics']);

        $this->categoryRepositoryMock
            ->shouldReceive('getById')
            ->with('1')
            ->andReturn($category);

        $this->categoryRepositoryMock
            ->shouldReceive('delete')
            ->with('1')
            ->andReturn(true);

        $result = $this->categoryService->deleteCategory('1');

        $this->assertTrue($result);
    }

    public function testDeleteCategoryThrowsExceptionWhenNotFound()
    {
        $this->categoryRepositoryMock
            ->shouldReceive('getById')
            ->with('1')
            ->andReturn(null);

        $this->expectException(CategoryNotFoundException::class);

        $this->categoryService->deleteCategory('1');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}