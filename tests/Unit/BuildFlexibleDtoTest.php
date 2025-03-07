<?php

use Mate\Dto\Dto;
use Mate\Dto\Attributes\Flexible;

#[Flexible]
class FlexibleDtoTest extends Dto
{
    public string $property1;
    public ?string $property2;
}

describe('Build Flexible DTO', function () {
    test('from constructor', function () {
        $dto = new FlexibleDtoTest(
            property1: 'value 1',
            property2: 'value 2',
            property3: 'value 3'
        );

        $data = [
            "property1" => 'value 1',
            "property2" => 'value 2',
            "property3" => 'value 3',
        ];

        expect($dto->toArray())
            ->toBe($data);

        expect($dto->property3)
            ->toBe("value 3");
    });

    test('from array', function () {
        $data = [
            "property1" => 'value 1',
            "property2" => 'value 2',
            "property3" => 'value 3',
        ];

        $dto = FlexibleDtoTest::fromArray($data);

        expect($dto->toArray())
            ->toBe($data);

        expect($dto->property3)
            ->toBe("value 3");
    });

    test('from object', function () {
        $data = new stdClass();
        $data->property1 = "value 1";
        $data->property2 = "value 2";
        $data->property3 = "value 3";

        $expected = [
            "property1" => 'value 1',
            "property2" => 'value 2',
            "property3" => 'value 3',
        ];

        $dto = FlexibleDtoTest::fromObject($data);

        expect($dto->toArray())
            ->toBe($expected);

        expect($dto->property3)
            ->toBe("value 3");
    });

    test('from json string', function () {
        $obj = new stdClass();
        $obj->property1 = "value 1";
        $obj->property2 = "value 2";
        $obj->property3 = "value 3";

        $data = json_encode($obj);

        $expected = [
            "property1" => 'value 1',
            "property2" => 'value 2',
            "property3" => 'value 3',
        ];

        $dto = FlexibleDtoTest::fromJson($data);

        expect($dto->toArray())
            ->toBe($expected);

        expect($dto->property3)
            ->toBe("value 3");
    });
});
