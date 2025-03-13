<?php

use Mate\Dto\Dto;
use Mate\Dto\Attributes\Ignored;

class DtoWithIgnoredAttributeTest extends Dto
{
    #[Ignored]
    public string $property1;
    public string $property2;
}

class DtoWithDefaultValueTest extends Dto
{
    public string $property1;
    public string $property2 = "value 2";
    public ?string $property3;
}

class DtoWithNestedObjectTest extends Dto
{
    public string $say;
    public DtoWithDefaultValueTest $dto;
}

describe('DTOs', function () {
    test('ignored attribute', function () {
        $dto = new DtoWithIgnoredAttributeTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        expect($dto->property1)
            ->toBe("asdasd");
    })->throws(Error::class);

    test('nullable attribute without value', function () {
        $data = [
            "property1" => 'value 1',
            "property2" => 'value 2',
        ];

        $dto = DtoWithDefaultValueTest::fromArray($data);

        expect($dto->property3)
            ->toBe(null);
    });

    test('attribute with default value', function () {
        $data = [
            "property1" => 'value 1',
        ];

        $dto = DtoWithDefaultValueTest::fromArray($data);

        expect($dto->property2)
            ->toBe("value 2");
    });

    test('nested', function () {
        $attributeDto = DtoWithDefaultValueTest::fromArray([
            "property1" => 'value 1',
            "property2" => 'value 2',
        ]);

        $dto = new DtoWithNestedObjectTest(
            say: 'Hello!',
            dto: $attributeDto
        );

        $expected = [
            "say" => 'Hello!',
            "dto" => [
                "property1" => 'value 1',
                "property2" => 'value 2',
                "property3" => null,
            ]
        ];

        expect($dto->toArray())
            ->toBe($expected);
    });

    test('missing attribute value', function () {
        $dto = DtoWithDefaultValueTest::fromArray([]);

        $expected = [
            "property2" => 'value 2',
            "property3" => null,
        ];

        expect($dto->toArray())
            ->toBe($expected);
    });


    test('check all keys', function () {
        $dto = DtoWithDefaultValueTest::fromArray([
            'property1' => "value 1",
            'property2' => "value 2",
            'property3' => "value 3",
        ]);

        $expected = [
            "property1",
            "property2",
            "property3",
        ];

        expect($dto->keys())
            ->toBe($expected);
    });

    test('check all values', function () {
        $dto = DtoWithDefaultValueTest::fromArray([
            'property1' => "value 1",
            'property2' => "value 2",
        ]);

        $expected = [
            "value 1",
            "value 2",
            null
        ];

        expect($dto->values())
            ->toBe($expected);
    });
});
