<?php

namespace App\Utils;

use Carbon\Carbon;

class GeneticAlgorithm
{
    public static function generateChromosome($employees, $shifts, $startDate, $endDate, $staffPerShift)
    {
        $chromosome = [];
        $currentDate = $startDate;

        while ($currentDate <= $endDate) {
            // Skip Sundays
            if (date('N', strtotime($currentDate)) != 7) {
                $daySchedule = [];
                foreach ($shifts as $shift) {
                    $staffForShift = array_rand($employees, $staffPerShift); // Randomly select staff
                    $daySchedule[$shift] = array_map(fn($index) => $employees[$index], $staffForShift); // Map the indexes to employee names
                }
                $chromosome[] = $daySchedule;
            }
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }

        return $chromosome;
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
