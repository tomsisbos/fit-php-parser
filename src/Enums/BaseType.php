<?php

declare(strict_types=1);

namespace FitParser\Enums;

use Symfony\Component\String\ByteString;

enum BaseType: int
{
    case ENUM = 0x00;
    case SINT8 = 0x01;
    case UINT8 = 0x02;
    case SINT16 = 0x03;
    case UINT16 = 0x04;
    case SINT32 = 0x05;
    case UINT32 = 0x06;
    case STRING = 0x07;
    case FLOAT32 = 0x08;
    case FLOAT64 = 0x09;
    case UINT8Z = 0x0A;
    case UINT16Z = 0x0B;
    case UINT32Z = 0x0C;
    case BYTE = 0x0D;
    case SINT64 = 0x0E;
    case UINT64 = 0x0F;
    case UINT64Z = 0x10;
    case ENUM_LE = 0x80;
    case SINT8_LE = 0x81;
    case UINT8_LE = 0x82;
    case SINT16_LE = 0x83;
    case UINT16_LE = 0x84;
    case SINT32_LE = 0x85;
    case UINT32_LE = 0x86;
    case STRING_LE = 0x87;
    case FLOAT32_LE = 0x88;
    case FLOAT64_LE = 0x89;
    case UINT8Z_LE = 0x8A;
    case UINT16Z_LE = 0x8B;
    case UINT32Z_LE = 0x8C;
    case BYTE_LE = 0x8D;
    case SINT64_LE = 0x8E;
    case UINT64_LE = 0x8F;
    case UINT64Z_LE = 0x90;

    public static function sizeFrom(BaseType $baseType): int
    {
        return match ($baseType) {
            self::ENUM,
            self::ENUM_LE,
            self::SINT8,
            self::SINT8_LE,
            self::STRING,
            self::STRING_LE,
            self::UINT8Z,
            self::UINT8Z_LE,
            self::BYTE,
            self::BYTE_LE,
            self::UINT8,
            self::UINT8_LE => 1,
            self::SINT16,
            self::SINT16_LE,
            self::UINT16,
            self::UINT16_LE,
            self::UINT16Z,
            self::UINT16Z_LE => 2,
            self::SINT32,
            self::SINT32_LE,
            self::UINT32,
            self::UINT32_LE,
            self::UINT32Z,
            self::UINT32Z_LE,
            self::FLOAT32,
            self::FLOAT32_LE => 4,
            self::FLOAT64,
            self::FLOAT64_LE,
            self::SINT64,
            self::SINT64_LE,
            self::UINT64,
            self::UINT64_LE,
            self::UINT64Z,
            self::UINT64Z_LE => 8,
        };
    }

    public static function invalidFrom(BaseType $baseType): float|int
    {
        return match ($baseType) {
            self::ENUM,
            self::ENUM_LE,
            self::BYTE,
            self::BYTE_LE,
            self::UINT8,
            self::UINT8_LE => 0xFF,
            self::SINT8,
            self::SINT8_LE => 0x7F,
            self::SINT16,
            self::SINT16_LE => 0x7FFF,
            self::UINT16,
            self::UINT16_LE => 0xFFFF,
            self::SINT32,
            self::SINT32_LE => 0x7FFFFFFF,
            self::UINT32,
            self::UINT32_LE,
            self::FLOAT32,
            self::FLOAT32_LE => 0xFFFFFFFF,
            self::STRING,
            self::STRING_LE,
            self::UINT8Z,
            self::UINT8Z_LE => 0x00,
            self::FLOAT64,
            self::FLOAT64_LE,
            self::UINT64,
            self::UINT64_LE => 0xFFFFFFFFFFFFFFFF,
            self::UINT16Z,
            self::UINT16Z_LE => 0x0000,
            self::UINT32Z,
            self::UINT32Z_LE => 0x00000000,
            self::SINT64,
            self::SINT64_LE => 0x7FFFFFFFFFFFFFFF,
            self::UINT64Z,
            self::UINT64Z_LE => 0x0000000000000000,
        };
    }

    public static function unpackFormatFrom(BaseType $baseType, bool $littleEndian = true): string
    {
        return match ($baseType) {
            self::ENUM,
            self::SINT8,
            self::BYTE => 'c',
            self::UINT8Z,
            self::UINT8 => 'C',
            self::SINT16 => $littleEndian ? 's' : 'S',
            self::SINT16_LE => 's',
            self::UINT16,
            self::UINT16Z => $littleEndian ? 'v' : 'n',
            self::UINT16_LE,
            self::UINT16Z_LE => 'v',
            self::SINT32,
            self::UINT32,
            self::UINT32Z => $littleEndian ? 'V' : 'N',
            self::SINT32_LE,
            self::UINT32_LE,
            self::UINT32Z_LE => 'V',
            self::STRING => 'a*',
            self::FLOAT32 => $littleEndian ? 'f' : 'G',
            self::FLOAT32_LE => 'f',
            self::FLOAT64 => $littleEndian ? 'd' : 'E',
            self::FLOAT64_LE => 'd',
            self::SINT64 => $littleEndian ? 'q' : 'J',
            self::SINT64_LE => 'q',
            self::UINT64,
            self::UINT64Z => $littleEndian ? 'P' : 'Q',
            self::UINT64_LE => 'P',
        };
    }

    public static function fromFieldType(?string $fieldType): ?self
    {
        return match ($fieldType) {
            'sint8' => self::SINT8,
            'uint8' => self::UINT8,
            'sint16' => self::SINT16,
            'uint16' => self::UINT16,
            'sint32' => self::SINT32,
            'uint32' => self::UINT32,
            'string' => self::STRING,
            'float32' => self::FLOAT32,
            'float64' => self::FLOAT64,
            'uint8z' => self::UINT8Z,
            'uint16z' => self::UINT16Z,
            'uint32z' => self::UINT32Z,
            'byte' => self::BYTE,
            'sint64' => self::SINT64,
            'uint64' => self::UINT64,
            'uint64z' => self::UINT64Z,
            default => null,
        };
    }

    public static function isNumeric(BaseType $baseType): bool
    {
        return self::STRING !== $baseType;
    }

    public static function isInt(BaseType $baseType): bool
    {
        return match ($baseType) {
            self::BYTE,
            self::STRING,
            self::FLOAT32,
            self::FLOAT32_LE,
            self::FLOAT64,
            self::FLOAT64_LE,
            self::ENUM => false,
            self::SINT8,
            self::UINT8Z,
            self::UINT8,
            self::SINT16,
            self::SINT16_LE,
            self::UINT16,
            self::UINT16_LE,
            self::UINT16Z,
            self::UINT16Z_LE,
            self::SINT32,
            self::SINT32_LE,
            self::UINT32,
            self::UINT32_LE,
            self::UINT32Z,
            self::UINT32Z_LE,
            self::SINT64,
            self::SINT64_LE,
            self::UINT64,
            self::UINT64_LE,
            self::UINT64Z => true,
        };
    }

    public static function unpackFrom(BaseType $baseType, ByteString $string): float|int|string
    {
        $value = unpack(BaseType::unpackFormatFrom($baseType).'value', $string->toString());

        if (false === $value || false === \array_key_exists('value', $value)) {
            throw new \RuntimeException(
                \sprintf(
                    'Unable to unpack value from BaseType (%s) : %s',
                    $baseType->name,
                    $string->toString()
                )
            );
        }

        if (
            false === \is_int($value['value'])
            && false === \is_float($value['value'])
            && false === \is_string($value['value'])
        ) {
            throw new \RuntimeException(
                \sprintf(
                    'Unable type from unpacked value for BaseType (%s) : %s',
                    $baseType->name,
                    $string->toString()
                )
            );
        }

        return $value['value'];
    }
}
