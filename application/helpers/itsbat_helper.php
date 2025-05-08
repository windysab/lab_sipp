<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Extract year from Itsbat Nikah posita text
 * 
 * @param string $posita The posita text
 * @return string|null The extracted year or null if not found
 */
if (!function_exists('extract_marriage_year')) {
    function extract_marriage_year($posita)
    {
        if (empty($posita)) {
            return null;
        }

        // Try to match year pattern in text
        preg_match('/\b(19|20)\d{2}\b/', $posita, $matches);

        return !empty($matches[0]) ? $matches[0] : null;
    }
}

/**
 * Format date to Indonesian format
 * 
 * @param string $date Date string in Y-m-d format
 * @return string Formatted date in Indonesian format
 */
if (!function_exists('format_indo_date')) {
    function format_indo_date($date)
    {
        if (empty($date)) {
            return '-';
        }

        $bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        $date = DateTime::createFromFormat('Y-m-d', $date);
        if (!$date) {
            return '-';
        }

        return $date->format('d') . ' ' . $bulan[$date->format('m')] . ' ' . $date->format('Y');
    }
}

/**
 * Calculate marriage duration in years
 * 
 * @param int $marriageYear The year of marriage
 * @return int|null The duration in years or null if not possible
 */
if (!function_exists('calculate_marriage_duration')) {
    function calculate_marriage_duration($marriageYear)
    {
        if (empty($marriageYear) || !is_numeric($marriageYear)) {
            return null;
        }

        $currentYear = date('Y');
        return $currentYear - (int)$marriageYear;
    }
}
