<?php

class TcFinance
{
    private $financeExamples = [];
    private static $instance;

    public static function getInstance()
    {
        if (null === static::$instance) {
            $financeHelper = new static();

            $args = [
                //'fields' => 'ids',
                'post_type' => ['financeexample'],
                'posts_per_page' => '-1',
            ];
            $finances = new WP_Query($args);

            while ($finances->have_posts()) {
                $finance = $finances->next_post();
                $financeCustom = get_post_custom($finance->ID);
                $example = [];
                $example['weekly_price'] = $finance->post_title;

                $include = [
                    'cash_price',
                    'deposit',
                    'credit_amount',
                    'final_payment',
                    'monthly_amount',
                    'apr',
                    'total_amount',
                    'term'
                ];

                foreach ($include as $field) {
                    $example[$field] = $financeCustom[$field][0];
                }

                $financeHelper->financeExamples[$financeCustom['cash_price'][0]] = $example;

            }
            static::$instance = $financeHelper;
        }
        return static::$instance;
    }

    /**
     * Retrieve the weekly price of a car given its price
     *
     * @param string $cash_price the price of the car
     *
     * @return array
     */
    public static function getWeeklyPrice($cash_price)
    {
        $financeHelper = static::getInstance();
        if (array_key_exists($cash_price, $financeHelper->financeExamples)) {
            return ['pounds' => $financeHelper->financeExamples[$cash_price]['weekly_price'], 'pence' => ''];
        } else {
            $weeklyPrice = (ceil($cash_price / 100) * 100) / 200;
            $weeklyPounds = $weeklyPrice;
            $decimals = '';
            if (strpos($weeklyPrice, '.') !== false) {
                $decimals = explode('.', $weeklyPrice);
                $weeklyPounds = $decimals[0];
                $decimals = str_pad($decimals[1], '2', '0');
            }
            return ['price' => $weeklyPrice, 'pounds' => $weeklyPounds, 'pence' => $decimals];
        }
    }

    /**
     * Retrieve the weekly price of a car given its price
     *
     * @param string $cash_price the price of the car
     *
     * @return array
     */
    public static function getTradeInWeeklyPrice($cash_price)
    {
        $financeHelper = static::getInstance();
        if (array_key_exists($cash_price, $financeHelper->financeExamples) && isset($financeHelper->financeExamples[$cash_price]['trade_in_weekly_price'])) {
            return ['pounds' => $financeHelper->financeExamples[$cash_price]['trade_in_weekly_price'], 'pence' => ''];
        } else {
            $tradeInWeeklyPrice = ((ceil($cash_price / 100) * 100) / 200) - 5;
            $tradeInWeeklyPounds = $tradeInWeeklyPrice;
            $decimals = '';
            if (strpos($tradeInWeeklyPrice, '.') !== false) {
                $decimals = explode('.', $tradeInWeeklyPrice);
                $tradeInWeeklyPounds = $decimals[0];
                $decimals = str_pad($decimals[1], '2', '0');
            }
            return ['price' => $tradeInWeeklyPrice, 'pounds' => $tradeInWeeklyPounds, 'pence' => $decimals];
        }
    }

    /**
     * @param string $cash_price The price of the car to get the deposit
     *
     * @return string
     */
    public static function getDeposit($cash_price)
    {
        $financeHelper = static::getInstance();
        if (array_key_exists($cash_price, $financeHelper->financeExamples)) {
            return $financeHelper->financeExamples[$cash_price]['deposit'];
        } else {
            return '';
        }
    }
}
