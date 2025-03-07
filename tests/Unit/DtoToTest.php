<?php

use Mate\Dto\Dto;

describe('export', function () {
    test('to array', function () {
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

    test('to json', function () {
        $dto = new DtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        $data = json_encode([
            "property1" => 'value 1',
            "property2" => 'value 2',
        ]);

        expect($dto->toJson())
            ->toBe($data);
    });

    test('to jsonserialize', function () {
        $dto = new DtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        $data = [
            "property1" => 'value 1',
            "property2" => 'value 2',
        ];

        expect($dto->jsonSerialize())
            ->toBe($data);
    });

    test('to string', function () {
        $dto = new DtoTest(
            property1: 'value 1',
            property2: 'value 2',
        );

        $data = json_encode([
            "property1" => 'value 1',
            "property2" => 'value 2',
        ]);

        expect($dto->__toString())
            ->toBe($data);
    });
});
