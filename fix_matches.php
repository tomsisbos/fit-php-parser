<?php
$file = 'src/Enums/BaseType.php';
$content = file_get_contents($file);

// For invalidFrom
$content = preg_replace('/self::ENUM,/', 'self::ENUM, self::ENUM_LE,', $content);
$content = preg_replace('/self::SINT8 => 0x7F,/', 'self::SINT8, self::SINT8_LE => 0x7F,', $content);
$content = preg_replace('/self::BYTE,/', 'self::BYTE, self::BYTE_LE,', $content);
$content = preg_replace('/self::STRING,/', 'self::STRING, self::STRING_LE,', $content);
$content = preg_replace('/self::UINT8Z => 0x00,/', 'self::UINT8Z, self::UINT8Z_LE => 0x00,', $content);
$content = preg_replace('/self::UINT8 => 0xFF,/', 'self::UINT8, self::UINT8_LE => 0xFF,', $content);

// For isInt
$content = str_replace('self::FLOAT32,', 'self::FLOAT32, self::FLOAT32_LE,', $content);
$content = str_replace('self::FLOAT64,', 'self::FLOAT64, self::FLOAT64_LE,', $content);
$content = str_replace('self::STRING,', 'self::STRING, self::STRING_LE,', $content);

// For unpackFormatFrom - add simple mappings
$unpack = <<<'PHP'
            self::ENUM_LE => 'c',
            self::SINT8_LE => 'c',
            self::UINT8_LE => 'C',
            self::UINT8Z_LE => 'C',
            self::STRING_LE => 'a*',
            self::BYTE_LE => 'c',
PHP;

$content = str_replace("self::SINT16 => \$littleEndian ? 's' : 'S',", "$unpack\n            self::SINT16 => \$littleEndian ? 's' : 'S',", $content);

file_put_contents($file, $content);
echo "Fixed match statements\n";
