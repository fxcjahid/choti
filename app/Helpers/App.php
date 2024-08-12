<?php

use Illuminate\Support\Facades\Request;


if (! function_exists('ConvertPlaneTextToEditorJsBlocks')) {
    function ConvertPlaneTextToEditorJsBlocks($plainText)
    {
        // Split the plain text into lines based on newlines
        $lines = explode("\n", $plainText);

        // Prepare the blocks array
        $blocks = [];

        foreach ($lines as $line) {
            // Trim the line to remove extra spaces
            $trimmedLine = trim($line);
            if (! empty($trimmedLine)) {
                $blocks[] = [
                    'id'    => uniqid('', true),  // Call the function to generate a unique ID
                    'type'  => 'paragraph',
                    'data'  => [
                        'text' => $trimmedLine,
                    ],
                    'tunes' => [
                        'alignment' => [
                            'alignment' => 'left',
                        ],
                    ],
                ];
            }
        }

        // Prepare the full Editor.js content array
        $editorJsContent = [
            'time'    => round(microtime(true) * 1000),
            'blocks'  => $blocks,
            'version' => '2.27.0',
        ];

        return json_encode($editorJsContent, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

if (! function_exists('isValidEditorJsBlocks')) {
    function isValidEditorJsBlocks($content)
    {
        // Decode the JSON content
        $data = json_decode($content, true);

        // Check if the decoding was successful and the data is an array
        if (! is_array($data)) {
            return false;
        }

        // Check if required keys exist and have the correct types
        if (! isset($data['time']) || ! is_int($data['time'])) {
            return false;
        }

        if (! isset($data['blocks']) || ! is_array($data['blocks'])) {
            return false;
        }

        if (! isset($data['version']) || ! is_string($data['version'])) {
            return false;
        }

        // Validate each block in the blocks array
        foreach ($data['blocks'] as $block) {
            if (! isset($block['type']) || ! is_string($block['type'])) {
                return false;
            }

            if (! isset($block['data']) || ! is_array($block['data'])) {
                return false;
            }

            // Additional checks for the 'paragraph' block type
            if ($block['type'] === 'paragraph') {
                if (! isset($block['data']['text']) || ! is_string($block['data']['text'])) {
                    return false;
                }
            }

            // Add additional validation for other block types as needed
            // For example:
            // if ($block['type'] === 'header') {
            //     if (!isset($block['data']['text']) || !is_string($block['data']['text']) ||
            //         !isset($block['data']['level']) || !is_int($block['data']['level'])) {
            //         return false;
            //     }
            // }
        }

        return true;
    }
}

if (! function_exists('activeMenuClass')) {
    function activeMenuClass($uri = '')
    {
        $active = '';
        if (Request::is(Request::segment(1) . '/' . $uri . '/*') || Request::is(Request::segment(1) . '/' . $uri) || Request::is($uri)) {
            $active = 'active';
        }
        return $active;
    }
}