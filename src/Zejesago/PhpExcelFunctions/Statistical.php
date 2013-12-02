<?php namespace Zejesago\PhpExcelFunctions;

class Statistical {

    /**
     * @link   http://office.microsoft.com/en-001/mac-excel-help/max-function-HA102927838.aspx
     * @param  dynamic $number1 numbers for which you want to find the maximum
     *                          value.
     *                            + you can specify arguments that are numbers,
     *                              empty cells, logical values, or text
     *                              representations of numbers. The following
     *                              arguments cause errors: error values, or
     *                              text that cannot be translated into numbers.
     *                            + If an argument is an array or reference,
     *                              only numbers in that array or reference are
     *                              used. Empty cells, logical values, or text
     *                              in the array or reference is ignored. If
     *                              logical values and text must not be ignored,
     *                              use MAXA function instead.
     *                            + If the arguments contain no numbers, this
     *                              function returns 0 (zero).
     * @return int              returns the largest value in a set of values.
     * @access public
     * @static
     */
    public static function max($number1)
    {
        $numbers    = func_get_args();
        $hasNumeric = false;

        foreach ($numbers as $key => $number) {
            if (is_array($number)) {
                $numbers[$key] = call_user_func_array('self::max', $number);
                $hasNumeric    = true;
            } elseif ( ! $hasNumeric && is_numeric($number)) {
                $hasNumeric = true;
            }
        }

        if ( ! $hasNumeric) {
            return 0;
        }

        arsort($numbers, SORT_NUMERIC);
        return reset($numbers);
    }

    /**
     * @link   http://office.microsoft.com/en-001/mac-excel-help/rank-avg-function-HA102927979.aspx
     * @param  int|string $number the number whose rank you want to find.
     * @param  array      $ref    an array of, or a reference to, a list of
     *                            numbers. Nonnumeric values in ref are ignored.
     * @param  int        $order  a number that specifies how to rank number.
     *                              + If order is 0 (zero) or omitted, Excel
     *                                ranks number as if ref were a list sorted
     *                                in descending order.
     *                              + If order is any nonzero value, Excel ranks
     *                                number as if ref were a list sorted in
     *                                ascending order.
     * @return int|bool           returns the rank of a number in a list of
     *                            numbers. Its size is relative to other values
     *                            in the list; if more than one value has the
     *                            same rank, the average rank is returned. FALSE
     *                            if $number cannot be found.
     * @access public
     * @static
     */
    public static function rankAvg($number, array $ref, $order = 0)
    {
        $indices = array();

        foreach ($ref as $key => $value) {
            if (is_numeric($value)) {
                $number == $value and array_push($indices, $key);
            } else {
                unset($ref[$key]);
            }
        }

        $order ? asort($ref, SORT_NUMERIC) : arsort($ref, SORT_NUMERIC);

        $indicesCount = count($indices);

        if (0 === $indicesCount) {
            return false;
        } elseif (1 === $indicesCount) {
            return array_search(reset($indices), array_keys($ref))+1;
        } else {
            $sum = 0;
            foreach ($indices as $index) {
                $sum += (array_search($index, array_keys($ref))+1);
            }
            return $sum / $indicesCount;
        }
    }

}