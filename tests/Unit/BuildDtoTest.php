<?php

use Mate\Dto\Dto;
use Mate\Dto\Exceptions\NotFlexibleException;

class DtoTest extends Dto
{
    public string $property1;
    public string $property2;
}

class NestedDtoTest extends Dto
{
    public string $property;
    public DtoTest $dto;
}

class NestedDto2Test extends Dto
{
    public string $property;
    public DtoTest $dto;
    protected bool $nestedToArrayEnabled = false;
}

class NestedStdClassDtoTest extends Dto
{
    public string $property;
    public stdClass $dto;
}

class DtoWithNotPublicAttributeTest extends Dto
{
    protected string $property1;
    public string $property2;
}

class DtoWithStaticAttributeTest extends Dto
{
    public static string $property1;
    public string $property2;
}

class CamelcaseAttributeAttributeTest extends Dto
{
    public ?string $lastName = null;
    public ?string $firstName = null;
}

describe('Build DTO', function () {
    test('from constructor', function () {
        $dto = new DtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        $data = [
            "property1" => 'value 1',
            "property2" => 'value 2',
        ];

        expect($dto->toArray())
            ->toBe($data);
    });

    test('from dto', function () {
        $otherDto = new DtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        $data = [
            "property1" => 'value 1',
            "property2" => 'value 2',
        ];

        $dto = DtoTest::fromDto($otherDto);

        expect($dto->toArray())
            ->toBe($data);
    });

    test('from array', function () {
        $data = [
            "property1" => 'value 1',
            "property2" => 'value 2',
        ];

        $dto = DtoTest::fromArray($data);

        expect($dto->toArray())
            ->toBe($data);
    });

    test('from object', function () {
        $data = new stdClass();
        $data->property1 = "value 1";
        $data->property2 = "value 2";

        $expected = [
            "property1" => 'value 1',
            "property2" => 'value 2',
        ];

        $dto = DtoTest::fromObject($data);

        expect($dto->toArray())
            ->toBe($expected);
    });

    test('from json string', function () {
        $obj = new stdClass();
        $obj->property1 = "value 1";
        $obj->property2 = "value 2";

        $data = json_encode($obj);

        $expected = [
            "property1" => 'value 1',
            "property2" => 'value 2',
        ];

        $dto = DtoTest::fromJson($data);

        expect($dto->toArray())
            ->toBe($expected);
    });

    test('from array with dinamic value', function () {
        $data = [
            "property1" => 'value 1',
            "property2" => 'value 2',
            "property3" => 'value 3',
        ];

        $expected = [
            "property1" => 'value 1',
            "property2" => 'value 2',
        ];

        $dto = DtoTest::fromArray($data);

        expect($dto->toArray())
            ->toBe($expected);
    })->throws(NotFlexibleException::class);

    test('with nested dtos', function () {
        $data = [
            "property" => 'value',
            "dto" => DtoTest::fromArray([
                "property1" => 'value 1',
                "property2" => 'value 2',
            ]),
        ];

        $expected = [
            "property" => 'value',
            "dto" => [
                "property1" => 'value 1',
                "property2" => 'value 2',
            ],
        ];

        $dto = NestedDtoTest::fromArray($data);

        expect($dto->toArray())
            ->toBe($expected);
    });

    test('with nested dtos - without nestedToArrayEnabled', function () {
        $child = DtoTest::fromArray([
            "property1" => 'value 1',
            "property2" => 'value 2',
        ]);

        $data = [
            "property" => 'value',
            "dto" => $child,
        ];

        $expected = [
            "property" => 'value',
            "dto" => $child,
        ];

        $dto = NestedDto2Test::fromArray($data);

        expect($dto->toArray())
            ->toBe($expected);
    });

    test('with nested stdclass', function () {
        $nestedDto = new stdClass();
        $nestedDto->property1 = "value 1";
        $nestedDto->property2 = "value 2";

        $data = [
            "property" => 'value',
            "dto" => $nestedDto,
        ];

        $expected = [
            "property" => 'value',
            "dto" => $nestedDto,
        ];

        $dto = NestedStdClassDtoTest::fromArray($data);

        expect($dto->toArray())
            ->toBe($expected);
    });

    test('with not public attribute', function () {
        $dto = DtoWithNotPublicAttributeTest::fromArray([
            "property1" => "value 1",
            "property2" => "value 2",
        ]);

        $expected = [
            "property1" => "value 1",
            "property2" => "value 2",
        ];

        expect($dto->toArray())
            ->toBe($expected);
    })->throws(NotFlexibleException::class);

    test('with static attribute', function () {
        $dto = DtoWithStaticAttributeTest::fromArray([
            "property2" => "value 2",
        ]);

        $expected = [
            "property2" => "value 2",
        ];

        expect($dto->toArray())
            ->toBe($expected);
    });

    test('set snakecase', function () {
        $dto = new CamelcaseAttributeAttributeTest();
        $dto->lastName = "last name";
        $dto->first_name = "first name";

        $expected = [
            "lastName" => "last name",
            "firstName" => "first name",
        ];

        expect($dto->toArray())
            ->toBe($expected);
    });

    test('fill set snakecase', function () {
        $dto = new CamelcaseAttributeAttributeTest(...[
            "lastName" => "last name",
            "first_name" => "first name"
        ]);

        $expected = [
            "lastName" => "last name",
            "firstName" => "first name",
        ];

        expect($dto->toArray())
            ->toBe($expected);
    });
});
