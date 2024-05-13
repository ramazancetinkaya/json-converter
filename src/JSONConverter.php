<?php
/**
 * JSON Converter Library
 * 
 * A library to convert JSON data to various formats such as CSV, XML and vice versa.
 *
 * @category Library
 * @package  JSONConverter
 * @author   Ramazan Çetinkaya <ramazancetinkayadev@hotmail.com>
 * @version  1.0
 * @license  MIT License
 * @link     https://github.com/ramazancetinkaya/json-converter
 */

namespace JSONConverter;

class JSONConverter {
    
    /**
     * Converts JSON data to CSV format.
     *
     * @param string $json JSON data to convert.
     * @param string $csvFilePath Path to save the CSV file.
     * @param bool $includeHeader Whether to include headers in the CSV file.
     * @param string $delimiter CSV delimiter character.
     * @param string $enclosure CSV enclosure character.
     * @throws Exception if conversion fails or file cannot be saved.
     */
    public static function jsonToCSV(
        string $json,
        string $csvFilePath,
        bool $includeHeader = true,
        string $delimiter = ',',
        string $enclosure = '"'
    ): void {
        try {
            // Decode JSON data
            $data = json_decode($json, true);
            if ($data === null) {
                throw new Exception("Invalid JSON format.");
            }

            // Open CSV file for writing
            $file = fopen($csvFilePath, 'w');
            if ($file === false) {
                throw new Exception("Failed to open CSV file for writing.");
            }

            // Write headers to CSV file if required
            if ($includeHeader) {
                fputcsv($file, array_keys($data[0]), $delimiter, $enclosure);
            }

            // Write data to CSV file
            foreach ($data as $row) {
                fputcsv($file, $row, $delimiter, $enclosure);
            }

            // Close CSV file
            fclose($file);
        } catch (Exception $e) {
            throw new Exception("Failed to convert JSON to CSV: " . $e->getMessage());
        }
    }

    /**
     * Converts JSON data to XML format.
     *
     * @param string $json JSON data to convert.
     * @param string $xmlFilePath Path to save the XML file.
     * @param bool $prettyPrint Whether to pretty print the XML.
     * @throws Exception if conversion fails or file cannot be saved.
     */
    public static function jsonToXML(
        string $json,
        string $xmlFilePath,
        bool $prettyPrint = false
    ): void {
        try {
            // Decode JSON data
            $data = json_decode($json, true);
            if ($data === null) {
                throw new Exception("Invalid JSON format.");
            }

            // Create new DOMDocument
            $xml = new DOMDocument('1.0', 'utf-8');
            $xml->formatOutput = $prettyPrint;

            // Create root element
            $root = $xml->createElement('root');
            $xml->appendChild($root);

            // Convert JSON data to XML
            foreach ($data as $item) {
                $child = $xml->createElement('item');
                $root->appendChild($child);

                self::arrayToXML($item, $xml, $child);
            }

            // Save XML to file
            $result = $xml->save($xmlFilePath);
            if ($result === false) {
                throw new Exception("Failed to save XML file.");
            }
        } catch (Exception $e) {
            throw new Exception("Failed to convert JSON to XML: " . $e->getMessage());
        }
    }

    // Helper function to convert array to XML
    private static function arrayToXML(array $data, DOMDocument $xml, DOMNode $node): void {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $child = $xml->createElement($key);
                $node->appendChild($child);
                self::arrayToXML($value, $xml, $child);
            } else {
                $child = $xml->createElement($key, htmlspecialchars($value));
                $node->appendChild($child);
            }
        }
    }

    /**
     * Converts CSV data to JSON format.
     *
     * @param string $csvFilePath Path to the CSV file.
     * @param bool $includeHeader Whether the CSV file includes headers.
     * @param string $delimiter CSV delimiter character.
     * @param string $enclosure CSV enclosure character.
     * @return string JSON representation of CSV data.
     * @throws Exception if conversion fails or file cannot be read.
     */
    public static function csvToJSON(
        string $csvFilePath,
        bool $includeHeader = true,
        string $delimiter = ',',
        string $enclosure = '"'
    ): string {
        try {
            // Open CSV file for reading
            $file = fopen($csvFilePath, 'r');
            if ($file === false) {
                throw new Exception("Failed to open CSV file for reading.");
            }

            // Initialize variables
            $data = [];
            $headers = [];

            // Read CSV file and convert to associative array
            while (($row = fgetcsv($file, 0, $delimiter, $enclosure)) !== false) {
                // Store headers if provided
                if ($includeHeader && empty($headers)) {
                    $headers = $row;
                } else {
                    $data[] = array_combine($headers, $row);
                }
            }

            // Close CSV file
            fclose($file);

            // Encode data to JSON format
            return json_encode($data, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            throw new Exception("Failed to convert CSV to JSON: " . $e->getMessage());
        }
    }

    /**
     * Converts XML data to JSON format.
     *
     * @param string $xmlFilePath Path to the XML file.
     * @return string JSON representation of XML data.
     * @throws Exception if conversion fails or file cannot be read.
     */
    public static function xmlToJSON(string $xmlFilePath): string {
        try {
            // Read XML file
            $xmlString = file_get_contents($xmlFilePath);
            if ($xmlString === false) {
                throw new Exception("Failed to read XML file.");
            }

            // Parse XML string
            $xml = simplexml_load_string($xmlString);
            if ($xml === false) {
                throw new Exception("Invalid XML format.");
            }

            // Encode XML to JSON format
            return json_encode($xml, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            throw new Exception("Failed to convert XML to JSON: " . $e->getMessage());
        }
    }

}
