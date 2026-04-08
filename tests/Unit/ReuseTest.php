<?php

declare(strict_types=1);

namespace Tests\Unit;

use Mate\Dto\Dto;

class ReusableDto extends Dto
{
    public string $status;
    public int $count;
}

test('existing dto can be updated using fill()', function () {
    $dto = new ReusableDto(['status' => 'initial', 'count' => 0]);
    
    expect($dto->status)->toBe('initial');
    expect($dto->count)->toBe(0);
    
    $dto->fill(['status' => 'updated', 'count' => 10]);
    
    expect($dto->status)->toBe('updated');
    expect($dto->count)->toBe(10);
});

test('fill() supports method chaining', function () {
    $dto = new ReusableDto();
    
    $result = $dto->fill(['status' => 'chained', 'count' => 5])->toArray();
    
    expect($result['status'])->toBe('chained');
    expect($result['count'])->toBe(5);
});
