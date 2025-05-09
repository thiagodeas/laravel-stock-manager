<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Exceptions\InvalidDateRangeException;
use App\Exceptions\Output\OutputNotFoundException;
use App\Exceptions\Product\InsufficientStockException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Output;
use App\Models\Product;
use App\Repositories\Output\OutputRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Output\OutputService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Mockery;

class OutputServiceTest extends TestCase
{
    protected OutputService $outputService;
    protected $outputRepositoryMock;
    protected $productRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->outputRepositoryMock = Mockery::mock(OutputRepositoryInterface::class);
        $this->productRepositoryMock = Mockery::mock(ProductRepositoryInterface::class);

        $this->outputService = new OutputService(
            $this->outputRepositoryMock,
            $this->productRepositoryMock
        );

        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });
    }

    public function testCreateOutputSuccessfully()
    {
        $data = ['product_id' => 1, 'quantity' => 5];
        $product = Mockery::mock(Product::class)->makePartial();
        $product->quantity = 10;

        $product->shouldReceive('save')->once();

        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with($data['product_id'])
            ->andReturn($product);

        $this->outputRepositoryMock
            ->shouldReceive('create')
            ->with(Mockery::on(function ($arg) use ($data) {
                return $arg['product_id'] === $data['product_id'] &&
                    $arg['quantity'] === $data['quantity'] &&
                    isset($arg['output_date']);
            }))
            ->andReturn(new Output($data));

        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });

        $output = $this->outputService->createOutput($data);

        $this->assertInstanceOf(Output::class, $output);
        $this->assertEquals(5, $product->quantity);
    }

    public function testCreateOutputThrowsProductNotFoundException()
    {
        $this->expectException(ProductNotFoundException::class);

        $data = ['product_id' => 1, 'quantity' => 5];

        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with($data['product_id'])
            ->andReturn(null);

        $this->outputService->createOutput($data);
    }

    public function testCreateOutputThrowsInsufficientStockException()
    {
        $this->expectException(InsufficientStockException::class);

        $data = ['product_id' => 1, 'quantity' => 15];
        $product = Mockery::mock(Product::class)->makePartial();
        $product->quantity = 10;

        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with($data['product_id'])
            ->andReturn($product);

        $this->outputService->createOutput($data);
    }

    public function testGetAllOutputs()
    {
        $outputs = new Collection([new Output(), new Output()]);

        $this->outputRepositoryMock
            ->shouldReceive('getAll')
            ->andReturn($outputs);

        $result = $this->outputService->getAllOutputs();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testGetOutputByIdSuccessfully()
    {
        $output = new Output(['id' => 1]);

        $this->outputRepositoryMock
            ->shouldReceive('getById')
            ->with(1)
            ->andReturn($output);

        $result = $this->outputService->getOutputById(1);

        $this->assertInstanceOf(Output::class, $result);
    }

    public function testGetOutputByIdThrowsOutputNotFoundException()
    {
        $this->expectException(OutputNotFoundException::class);

        $this->outputRepositoryMock
            ->shouldReceive('getById')
            ->with(1)
            ->andReturn(null);

        $this->outputService->getOutputById(1);
    }

    public function testGetOutputsByProductIdSuccessfully()
    {
        $outputs = new Collection([new Output(), new Output()]);

        $this->outputRepositoryMock
            ->shouldReceive('getByProductId')
            ->with('1')
            ->andReturn($outputs);

        $result = $this->outputService->getOutputsByProductId('1');

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testGetOutputsByProductIdThrowsProductNotFoundException()
    {
        $this->expectException(ProductNotFoundException::class);

        $this->outputRepositoryMock
            ->shouldReceive('getByProductId')
            ->with('1')
            ->andReturn(new Collection());

        $this->outputService->getOutputsByProductId('1');
    }

    public function testGetOutputsByDateRangeSuccessfully()
    {
        $startDate = Carbon::today()->subDays(7);
        $endDate = Carbon::today();
        $outputs = new Collection([new Output(), new Output()]);

        $this->outputRepositoryMock
            ->shouldReceive('getByDateRange')
            ->with($startDate, $endDate)
            ->andReturn($outputs);

        $result = $this->outputService->getOutputsByDateRange($startDate, $endDate);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testGetOutputsByDateRangeThrowsInvalidDateRangeException()
    {
        $this->expectException(InvalidDateRangeException::class);

        $this->outputService->getOutputsByDateRange(null, null);
    }
}