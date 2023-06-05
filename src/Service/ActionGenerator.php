<?php

namespace App\Service;

use IntlDateFormatter;

class ActionGenerator
{
    public function getAction(): array
    {
        $array_day =
            [
                [
                    'id' => 1,
                    'first' => "Lundi à 6h00",
                    'second' => "Lundi à 9h00",
                    'third' => "Lundi à 12h00",
                    'fourth' => "Lundi à 15h00",
                    'fifth' => "Lundi à 18h00",
                ],
                [
                    'id' => 2,
                    'first' => "Mardi à 6h00",
                    'second' => "Mardi à 9h00",
                    'third' => "Mardi à 12h00",
                    'fourth' => "Mardi à 15h00",
                    'fifth' => "Mardi à 18h00",
                ],
                [
                    'id' => 3,
                    'first' => "Mercredi à 6h00",
                    'second' => "Mercredi à 9h00",
                    'third' => "Mercredi à 12h00",
                    'fourth' => "Mercredi à 15h00",
                    'fifth' => "Mercredi à 18h00",
                ],
                [
                    'id' => 4,
                    'first' => "Jeudi à 6h00",
                    'second' => "Jeudi à 9h00",
                    'third' => "Jeudi à 12h00",
                    'fourth' => "Jeudi à 15h00",
                    'fifth' => "Jeudi à 18h00",
                ],
                [
                    'id' => 5,
                    'first' => "Vendredi à 6h00",
                    'second' => "Vendredi à 9h00",
                    'third' => "Vendredi à 12h00",
                    'fourth' => "Vendredi à 15h00",
                    'fifth' => "Vendredi à 18h00",
                ],
            ];

        $format = new IntlDateFormatter('FR',
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::FULL
        );
        $format->setPattern('EEE');

        $day = ucfirst($format->format(time()));

        $date = date('d');

        $dayDate = "$day $date";

        $hour = date('H:i');

        $table =
            [
                'array_day' => $array_day,
                'dayDate' => $dayDate,
                'hour' => $hour
            ];
        return $table;
    }
}
