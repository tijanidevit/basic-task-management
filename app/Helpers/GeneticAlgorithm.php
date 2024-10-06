<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class GeneticAlgorithm
{

    public function __construct(protected array $employees, protected $startDate, protected $endDate, protected $staffPerShift, protected $shifts, protected $populationSize = 150, protected $generations = 300, protected $mutationRate = 0.05)
    {
        $this->startDate = Carbon::parse($startDate);
        $this->endDate = Carbon::parse($endDate);
        $this->staffPerShift = $staffPerShift;
        $this->shifts = explode(',',$shifts);
        $this->populationSize = $populationSize;
        $this->generations = $generations;
        $this->mutationRate = $mutationRate;
    }

    public function run()
    {
        $population = $this->initializePopulation();

        for ($i = 0; $i < $this->generations; $i++) {
            $population = $this->evolve($population);
        }

        return $this->getBestSchedule($population);
    }

    public function generateSchedule()
    {
        $schedule = [];
        $currentDay = $this->startDate;
        $staffCount = count($this->employees);
        $staffIndex = 0;

        while ($currentDay->lte($this->endDate)) {
            // Skip Sundays
            if ($currentDay->isSunday()) {
                $currentDay->addDay();
                continue;
            }

            // Assign staff for each shift on this day
            foreach ($this->shifts as $shift) {
                $shiftAssignments = [];

                // Assign staff to the shift ensuring no one is assigned twice in the same day
                for ($i = 0; $i < $this->staffPerShift; $i++) {
                    $shiftAssignments[] = $this->employees[$staffIndex % $staffCount];
                    $staffIndex++;
                }

                // Add to the schedule
                $schedule[] = [
                    'date' => $currentDay->toDateString(),
                    'shift' => $shift,
                    'staff' => $shiftAssignments
                ];
            }

            // Move to the next day
            $currentDay->addDay();
        }

        return $schedule;
    }

    protected function initializePopulation(): Collection
    {
        $population = collect();

        for ($i = 0; $i < $this->populationSize; $i++) {
            $chromosome = $this->generateChromosome();
            $population->push($chromosome);
        }

        return $population;
    }

    /**
     * Generate a single chromosome (schedule).
     */
    protected function generateChromosome(): array
    {
        $schedule = [];
        $date = clone $this->startDate;

        while ($date->lte($this->endDate)) {
            foreach ($this->shifts as $shift) {
                // Select random employees for each shift
                $assignedStaff = collect($this->employees)->random($this->staffPerShift)->toArray();

                $schedule[] = [
                    'date' => $date->toDateString(),
                    'shift' => $shift,
                    'staff' => $assignedStaff,
                ];
            }

            // Move to the next day
            $date->addDay();
        }

        return $schedule;
    }

    /**
     * Fitness function to evaluate a chromosome.
     */
    protected function fitnessFunction(array $chromosome): int
    {
        // Example: Maximizing staff distribution, avoiding over-usage, fairness
        // Customize your fitness calculation based on your constraints.
        $fitness = 0;

        $staffUsage = array_fill_keys($this->employees, 0);

        foreach ($chromosome as $shift) {
            foreach ($shift['staff'] as $staffId) {
                $staffUsage[$staffId]++;
            }
        }

        // Calculate fitness score (for simplicity, use sum of staff distribution)
        foreach ($staffUsage as $usage) {
            $fitness += $usage;
        }

        return $fitness;
    }

    /**
     * Evolve the population by selecting, crossing over, and mutating.
     */
    protected function evolve(Collection $population): Collection
    {
        $newPopulation = collect();

        // Select the best individuals for reproduction
        $selected = $this->selection($population);

        // Generate new population via crossover
        for ($i = 0; $i < $this->populationSize / 2; $i++) {
            $parent1 = $selected->random();
            $parent2 = $selected->random();

            [$child1, $child2] = $this->crossover($parent1, $parent2);

            $newPopulation->push($this->mutate($child1));
            $newPopulation->push($this->mutate($child2));
        }

        return $newPopulation;
    }

    /**
     * Selection: Choose the best chromosomes for reproduction.
     */
    protected function selection(Collection $population): Collection
    {
        // Sort by fitness and select the top half of the population
        return $population->sortByDesc(fn($chromosome) => $this->fitnessFunction($chromosome))->take($this->populationSize / 2);
    }

    /**
     * Crossover: Combine two parents to produce two offspring.
     */
    protected function crossover(array $parent1, array $parent2): array
    {
        // Random crossover point
        $crossoverPoint = rand(1, count($parent1) - 1);

        $child1 = array_merge(array_slice($parent1, 0, $crossoverPoint), array_slice($parent2, $crossoverPoint));
        $child2 = array_merge(array_slice($parent2, 0, $crossoverPoint), array_slice($parent1, $crossoverPoint));

        return [$child1, $child2];
    }

    /**
     * Mutate: Randomly alter a chromosome to introduce variety.
     */
    protected function mutate(array $chromosome): array
    {
        if (rand(0, 100) / 100 < $this->mutationRate) {
            // Mutate a random day and shift by changing the staff
            $randomIndex = array_rand($chromosome);
            $chromosome[$randomIndex]['staff'] = collect($this->employees)->random($this->staffPerShift)->toArray();
        }

        return $chromosome;
    }

    /**
     * Return the best chromosome (schedule) from the population.
     */
    protected function getBestSchedule(Collection $population): array
    {
        return $population->sortByDesc(fn($chromosome) => $this->fitnessFunction($chromosome))->first();
    }
}
