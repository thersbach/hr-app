<?php
namespace App\Controller;

use App\Entity\CompensationCalculationLine;
use App\Entity\CompensationRule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employee;

class CalculationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/calculate", name="calculate", methods={"GET"})
     */
    public function calculate(Request $request): JsonResponse
    {
        // set max execution time to 5 minutes
        ini_set('max_execution_time', 300);

        // reset all compensation calculation lines
        $this->entityManager->createQuery('DELETE FROM App\Entity\CompensationCalculationLine')->execute();

        // get employees from database
        $employees = $this->entityManager->getRepository(Employee::class)->findAll();

        // get all compensation rules
        $compensationRules = $this->entityManager->getRepository(CompensationRule::class)->findAll();

        foreach ($employees as $employee) {
            // calculate compensation for each employee, starting from the first monday of the year.
            // Every route going to and going from is calculated.
            // If the employee has a workday on that day, the compensation is calculated and saved (two lines)
            // there can be multiple compensation rules per day (bonus compensation)
            $workdays = ceil($employee->getWorkdays());
            $distance = $employee->getDistanceFromHome();
            $transport = $employee->getTransport();
            $workDate = new \DateTime('first monday of January ' . date('Y'));

            $daysThisYear = date('L') ? 366 : 365;

            // loop through all days
            for ($i = 0; $i < $daysThisYear; $i++) {
                $dayOfWeek = $workDate->format('N');

                // check if the employee has a workday on this day
                if ($dayOfWeek <= $workdays) {
                                     // filter compensation rules for this day
                    $rules = array_filter($compensationRules, function ($rule) use ($distance, $transport) {
                        return $rule->getTransport()->getId() == $transport->getId()
                            && $rule->getDistanceFrom() <= $distance
                            && (
                                $rule->getDistanceTill() >= $distance
                                || $rule->getDistanceTill() == null
                            );
                    });

                    // save every compensation rule for this day, going to work and going home
                    foreach ($rules as $rule) {
                        $line = new CompensationCalculationLine();
                        $line->setEmployee($employee);
                        $line->setWorkDate($workDate);
                        $line->setCompensationRule($rule);
                        $line->setDirection('to');
                        $line->setDistance($distance);
                        $line->setCompensation($rule->getCompensation() * $distance);
                        $this->entityManager->persist($line);

                        $line = new CompensationCalculationLine();
                        $line->setEmployee($employee);
                        $line->setWorkDate($workDate);
                        $line->setCompensationRule($rule);
                        $line->setDirection('from');
                        $line->setDistance($distance);
                        $line->setCompensation($rule->getCompensation() * $distance);
                        $this->entityManager->persist($line);
                    }
                }

                // save all lines for this day
                $this->entityManager->flush();

                $workDate->modify('+1 day');
            }
        }

        return new JsonResponse(['result' => 1]);
    }
}
