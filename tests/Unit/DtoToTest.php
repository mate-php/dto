<?php

use Mate\Dto\Dto;

class DtoToDatabase extends Dto
{
    public int $id;
    public int $clientId;
}

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

    test('to database', function () {
        $dto = new DtoToDatabase(
            id: 1,
            clientId: 2,
        );

        $data = [
            "id" => 1,
            "client_id" => 2,
        ];

        expect($dto->toDatabase())
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
