<?php

namespace PayPal\Converter;

class FormatConverter
{
    /**
     * Format the data based on the input formatter value
     *
     * @param $value
     * @param $formatter
     * @return string
     */
    public static function format($value, $formatter)
    {
        return sprintf($formatter, $value);
    }

    /**
     * Format the input data with decimal places
     *
     * Defaults to 2 decimal places
     *
     * @param     $value
     * @param int $decimals
     * @return null|string
     */
    public static function formatToNumber($value, $decimals = 2)
    {
        if ($value !== null && trim($value) !== '') {
            return number_format(trim($value), $decimals, '.', '');
        }
        return null;
    }

    /**
     * Helper method to format price values with associated currency information.
     *
     * It covers the cases where certain currencies does not accept decimal values. We will be adding
     * any specific currency level rules as required here.
     *
     * @param      $value
     * @param string|null $currency
     * @return null|string
     */
    public static function formatToPrice($value, $currency = null)
    {
        if ($value === null) {
            return null;
        }

        $decimals = 2;
        $currencyDecimals = array('JPY' => 0, 'TWD' => 0, 'HUF' => 0);
        if ($currency && array_key_exists($currency, $currencyDecimals)) {
            if (str_contains($value, ".") && (floor($value) != $value)) {
                //throw exception if it has decimal values for JPY, TWD and HUF which does not ends with .00
                throw new \InvalidArgumentException("value cannot have decimals for $currency currency");
            }
            $decimals = $currencyDecimals[$currency];
        } elseif (!str_contains($value, '.')) {
            // Check if value has decimal values. If not no need to assign 2 decimals with .00 at the end
            $decimals = 0;
        }

        $result = self::formatToNumber($value, $decimals);

        if ($result === null) {
            return null;
        }

        return str_ends_with($result, '.00')
            ? substr($result, 0, -3)
            : $result;
    }
}
