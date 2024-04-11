<?php


function nbr_of_days($date) {
    $date = new DateTime($date);
    $now = new DateTime();
    $interval = $now->diff($date);
    return $interval->format('%a jours');
}
