<?php

namespace App\Helpers;

class FileHelper
{
    public static function getFileIcon($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $icons = [
            'pdf' => 'bi-file-earmark-pdf text-red-600',
            'doc' => 'bi-file-earmark-word text-blue-600',
            'docx' => 'bi-file-earmark-word text-blue-600',
            'xls' => 'bi-file-earmark-excel text-green-700',
            'xlsx' => 'bi-file-earmark-excel text-green-700',
            'ppt' => 'bi-file-earmark-ppt text-orange-600',
            'pptx' => 'bi-file-earmark-ppt text-orange-600',
            'zip' => 'bi-file-earmark-zip text-purple-600',
            'rar' => 'bi-file-earmark-zip text-purple-600',
            'txt' => 'bi-file-earmark-text text-gray-600',
            'csv' => 'bi-file-earmark-spreadsheet text-green-500',
        ];

        return $icons[$extension] ?? 'bi-file-earmark text-gray-600';
    }

    public static function getFileType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $types = [
            'pdf' => 'PDF Document',
            'png' => 'PNG Image',
            'doc' => 'Word Document',
            'docx' => 'Word Document',
            'xls' => 'Excel Spreadsheet',
            'xlsx' => 'Excel Spreadsheet',
            'ppt' => 'PowerPoint',
            'pptx' => 'PowerPoint',
        ];

        return $types[$extension] ?? 'File';
    }
}
