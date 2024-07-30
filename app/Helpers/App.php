<?php


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
                    'type' => 'paragraph',
                    'data' => [
                        'text' => $trimmedLine,
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

        return json_encode($editorJsContent, JSON_PRETTY_PRINT);
    }
}