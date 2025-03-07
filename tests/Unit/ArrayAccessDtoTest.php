<?php

use Mate\Dto\Dto;
use Mate\Dto\Exceptions\UndefinedPropertyException;

class ArrayAccessDtoTest extends Dto
{
    public string $property1;
    public string $property2;
}

describe('ArrayAccess DTO', function () {
    test('getter', function () {
        $dto = new ArrayAccessDtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        expect($dto['property1'])
            ->toBe('value 1');

        expect($dto['property2'])
            ->toBe('value 2');
    });

    test('setter', function () {
        $dto = new ArrayAccessDtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        $dto['property3'] = "value 3";
    })->throws(Error::class);

    test('isset true', function () {
        $dto = new ArrayAccessDtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        expect(isset($dto['property2']))
            ->toBeTrue();
    });

    test('invalid property', function () {
        $dto = new ArrayAccessDtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        $value = $dto['property3'];
    })->throws(UndefinedPropertyException::class);

    test('remove property', function () {
        $dto = new ArrayAccessDtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        unset($dto['property3']);
    })->throws(Error::class);
});
