<?php

namespace App\Utils;

use Carbon\Carbon;
use DateTime;

class GeneticAlgorithm
{
    public static function generateChromosome($data)
    {
        $employees = $data['employees'];
        $start_date = new DateTime($data['start_date']);
        $end_date = new DateTime($data['end_date']);
        $staff_count = $data['staff_counts'];
        $shifts = explode(',', $data['shifts']);

        $assignments = [];

        $employeePool = $employees;

        function rotateEmployees(&$employees)
        {
            $first = array_shift($employees);
            array_push($employees, $first);
        }

        for ($date = clone $start_date; $date <= $end_date; $date->modify('+1 day')) {
            if ($date->format('N') == 7) {
                continue;
            }

            foreach ($shifts as $shift) {
                $assignedEmployees = array_slice($employeePool, 0, $staff_count);

                $assignments[] = [
                    'date' => $date->format('Y-m-d'),
                    'shift' => $shift,
                    'employees' => $assignedEmployees,
                ];

                for ($i = 0; $i < $staff_count; $i++) {
                    rotateEmployees($employeePool);
                }
            }
        }

        return $assignments;
    }

    private static function getRandomSample($array, $size)
    {
        $shuffled = $array;
        shuffle($shuffled);
        return array_slice($shuffled, 0, $size);
    }

    public static function fitness($chromosome, $employees)
    {
        dd($employees);
        $workload = array_fill_keys($employees, 0);

        foreach ($chromosome as $day) {
            foreach ($day['shifts'] as $shift) {
                foreach ($shift as $staff) {
                    $workload[$staff] += 1;
                }
            }
        }

        $maxWorkload = max($workload);
        $minWorkload = min($workload);
        return -($maxWorkload - $minWorkload) * 10;
    }

    public static function selection($population, $employees)
    {
        usort($population, function ($a, $b) use ($employees) {
            return self::fitness($b, $employees) - self::fitness($a, $employees);
        });

        return array_slice($population, 0, count($population) / 2);
    }

    public static function crossover($parent1, $parent2)
    {
        $crossoverPoint = floor(count($parent1) / 2);
        return array_merge(array_slice($parent1, 0, $crossoverPoint), array_slice($parent2, $crossoverPoint));
    }

    public static function mutate($chromosome, $employees, $mutationRate = 0.01)
    {
        foreach ($chromosome as &$day) {
            if (mt_rand() / mt_getrandmax() < $mutationRate) {
                $halfStaff = floor(count($employees) / 2);
                $morningStaff = self::getRandomSample($employees, $halfStaff);
                $afternoonStaff = array_filter($employees, fn($staff) => !in_array($staff, $morningStaff));
                $day['shifts'] = [$morningStaff, $afternoonStaff];
            }
        }
        return $chromosome;
    }

    public static function runAlgorithm($generations, $populationSize, $employees, $shifts, $startDate, $endDate, $staffPerShift)
    {
        $population = array_map(fn() => self::generateChromosome($employees, $shifts, $startDate, $endDate, $staffPerShift), range(1, $populationSize));

        for ($generation = 0; $generation < $generations; $generation++) {
            $population = self::selection($population, $employees);
            $nextGeneration = [];

            while (count($nextGeneration) < $populationSize) {
                $parent1 = $population[array_rand($population)];
                $parent2 = $population[array_rand($population)];
                $child = self::crossover($parent1, $parent2);
                $nextGeneration[] = self::mutate($child, $employees);
            }

            $population = $nextGeneration;
        }

        $data = array_reduce($population, fn($best, $current) => self::fitness($current, $employees) > self::fitness($best, $employees) ? $current : $best);

        dd($data);
    }

    public static function formatSchedule($bestSchedule)
    {
        $formattedSchedule = array_map(
            function ($schedule, $index) {
                $morningShift = implode(', ', $schedule['shifts'][0]);
                $afternoonShift = implode(', ', $schedule['shifts'][1]);

                return 'Day ' . ($index + 1) . ': ' . $schedule['date'] . "\nMorning: " . $morningShift . "\nAfternoon: " . $afternoonShift;
            },
            $bestSchedule,
            array_keys($bestSchedule),
        );

        return implode("\n\n", $formattedSchedule);
    }
}
