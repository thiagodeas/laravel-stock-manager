<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Exceptions\Product\ProductAlreadyExistsException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Product\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;

class ProductServiceTest extends TestCase
{
    protected ProductService $productService;
    protected $productRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepositoryMock = Mockery::mock(ProductRepositoryInterface::class);
        $this->productService = new ProductService($this->productRepositoryMock);
    }

    public function testCreateProductSuccessfully()
    {
        $data = ['name' => 'Test Product', 'price' => 100];

        $this->productRepositoryMock
            ->shouldReceive('findByName')
            ->with($data['name'])
            ->andReturn(null);

        $this->productRepositoryMock
            ->shouldReceive('create')
            ->with($data)
            ->andReturn(new Product($data));

        $product = $this->productService->createProduct($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($data['name'], $product->name);
    }

    public function testCreateProductThrowsExceptionIfProductExists()
    {
        $data = ['name' => 'Existing Product'];

        $this->productRepositoryMock
            ->shouldReceive('findByName')
            ->with($data['name'])
            ->andReturn(new Product($data));

        $this->expectException(ProductAlreadyExistsException::class);

        $this->productService->createProduct($data);
    }

    public function testGetAllProducts()
    {
        $products = new Collection([new Product(['name' => 'Product 1']), new Product(['name' => 'Product 2'])]);

        $this->productRepositoryMock
            ->shouldReceive('getAll')
            ->andReturn($products);

        $result = $this->productService->getAllProducts();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function testFindProductByIdSuccessfully()
    {
        $product = new Product(['id' => '1', 'name' => 'Test Product']);

        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with('1')
            ->andReturn($product);

        $result = $this->productService->findProductById('1');

        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals('Test Product', $result->name);
    }

    public function testFindProductByIdThrowsExceptionIfNotFound()
    {
        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with('1')
            ->andReturn(null);

        $this->expectException(ProductNotFoundException::class);

        $this->productService->findProductById('1');
    }

    public function testUpdateProductSuccessfully()
    {
        $data = ['name' => 'Updated Product'];
        $product = new Product(['id' => '1', 'name' => 'Old Product']);

        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with('1')
            ->andReturn($product);

        $this->productRepositoryMock
            ->shouldReceive('update')
            ->with('1', $data)
            ->andReturn(new Product(array_merge(['id' => '1'], $data)));

        $result = $this->productService->updateProduct('1', $data);

        $this->assertInstanceOf(Product::class, $result);
        $this->assertEquals('Updated Product', $result->name);
    }

    public function testUpdateProductThrowsExceptionIfNotFound()
    {
        $data = ['name' => 'Updated Product'];

        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with('1')
            ->andReturn(null);

        $this->expectException(ProductNotFoundException::class);

        $this->productService->updateProduct('1', $data);
    }

    public function testDeleteProductSuccessfully()
    {
        $product = new Product(['id' => '1', 'name' => 'Test Product']);

        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with('1')
            ->andReturn($product);

        $this->productRepositoryMock
            ->shouldReceive('delete')
            ->with('1')
            ->andReturnNull();

        $this->productService->deleteProduct('1');

        $this->assertTrue(true); // If no exception is thrown, the test passes.
    }

    public function testDeleteProductThrowsExceptionIfNotFound()
    {
        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with('1')
            ->andReturn(null);

        $this->expectException(ProductNotFoundException::class);

        $this->productService->deleteProduct('1');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}