<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Exceptions\Entry\EntryNotFoundException;
use App\Exceptions\InvalidDateRangeException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Models\Entry;
use App\Models\Product;
use App\Repositories\Entry\EntryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\Entry\EntryService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Mockery;

class EntryServiceTest extends TestCase
{
    protected EntryService $entryService;
    protected $entryRepositoryMock;
    protected $productRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->entryRepositoryMock = Mockery::mock(EntryRepositoryInterface::class);
        $this->productRepositoryMock = Mockery::mock(ProductRepositoryInterface::class);

        $this->entryService = new EntryService(
            $this->entryRepositoryMock,
            $this->productRepositoryMock
        );
    }

    public function testCreateEntrySuccessfully()
    {
        $data = [
            'product_id' => 1,
            'quantity' => 10,
        ];

        $product = Mockery::mock(Product::class)->makePartial();
        $product->shouldReceive('save')->once();
        $product->quantity = 0;

        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with($data['product_id'])
            ->andReturn($product);

        $this->entryRepositoryMock
            ->shouldReceive('create')
            ->with(Mockery::on(function ($arg) use ($data) {
                return $arg['product_id'] === $data['product_id'] &&
                    $arg['quantity'] === $data['quantity'] &&
                    isset($arg['entry_date']);
            }))
            ->andReturn(new Entry());

        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });

        $entry = $this->entryService->createEntry($data);

        $this->assertInstanceOf(Entry::class, $entry);
        $this->assertEquals(10, $product->quantity);
    }

    public function testCreateEntryThrowsProductNotFoundException()
    {
        $this->expectException(ProductNotFoundException::class);

        $data = [
            'product_id' => 1,
            'quantity' => 10,
        ];

        $this->productRepositoryMock
            ->shouldReceive('findById')
            ->with($data['product_id'])
            ->andReturn(null);

        DB::shouldReceive('transaction')->andReturnUsing(function ($callback) {
            return $callback();
        });
        
        $this->entryService->createEntry($data);
    }

    public function testGetAllEntries()
    {
        $entries = new Collection([new Entry(), new Entry()]);

        $this->entryRepositoryMock
            ->shouldReceive('getAll')
            ->andReturn($entries);

        $result = $this->entryService->getAllEntries();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testGetEntryByIdSuccessfully()
    {
        $entry = new Entry();

        $this->entryRepositoryMock
            ->shouldReceive('getById')
            ->with(1)
            ->andReturn($entry);

        $result = $this->entryService->getEntryById(1);

        $this->assertInstanceOf(Entry::class, $result);
    }

    public function testGetEntryByIdThrowsEntryNotFoundException()
    {
        $this->expectException(EntryNotFoundException::class);

        $this->entryRepositoryMock
            ->shouldReceive('getById')
            ->with(1)
            ->andReturn(null);

        $this->entryService->getEntryById(1);
    }

    public function testGetEntriesByProductIdSuccessfully()
    {
        $entries = new Collection([new Entry(), new Entry()]);

        $this->entryRepositoryMock
            ->shouldReceive('getByProductId')
            ->with('1')
            ->andReturn($entries);

        $result = $this->entryService->getEntriesByProductId('1');

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testGetEntriesByProductIdThrowsProductNotFoundException()
    {
        $this->expectException(ProductNotFoundException::class);

        $this->entryRepositoryMock
            ->shouldReceive('getByProductId')
            ->with('1')
            ->andReturn(new Collection());

        $this->entryService->getEntriesByProductId('1');
    }

    public function testGetEntriesByDateRangeSuccessfully()
    {
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        $entries = new Collection([new Entry(), new Entry()]);

        $this->entryRepositoryMock
            ->shouldReceive('getByDateRange')
            ->with($startDate, $endDate)
            ->andReturn($entries);

        $result = $this->entryService->getEntriesByDateRange($startDate, $endDate);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Collection::class, $result);
    }

    public function testGetEntriesByDateRangeThrowsInvalidDateRangeException()
    {
        $this->expectException(InvalidDateRangeException::class);

        $this->entryService->getEntriesByDateRange(null, null);
    }
}