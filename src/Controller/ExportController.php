<?php
namespace App\Controller;

use App\Entity\CompensationCalculationLine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employee;

class ExportController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Export compensation calculation lines to a csv file, grouped by employee and from first monday to first monday of every month
     *
     * @Route("/export", name="calculate", methods={"GET"})
     */
    public function export(Request $request): Response
    {
        $employees = $this->entityManager->getRepository(Employee::class)->findAll();

        $csv = fopen('php://temp', 'w+');

        /**
         * specs:
         * employee, transport, traveled distance, compensation for the entire month and the payment date.
         */
        fputcsv($csv, ['Employee', 'Transport', 'Traveled distance', 'Compensation', 'Payment date'], ';');

        foreach ($employees as $employee) {
            $compensationCalculationLines = $this->entityManager->getRepository(CompensationCalculationLine::class)->findBy(['employee' => $employee]);

            // loop through all months, and save a line for each month per employee
            for ($i = 1; $i <= 12; $i++) {
                $compensation = 0;
                $traveledDistance = 0;

                foreach ($compensationCalculationLines as $compensationCalculationLine) {
                    if ($compensationCalculationLine->getWorkDate()->format('n') == $i) {
                        $compensation += $compensationCalculationLine->getCompensation();
                        $traveledDistance += $compensationCalculationLine->getDistance();
                    }
                }

                $payment_date = new \DateTime(date('Y-' . $i . '-1'));
                $payment_date->modify('first monday of next month');

                fputcsv($csv, [
                    $employee->getName(),
                    $employee->getTransport()->getName(),
                    $traveledDistance,
                    $compensation,
                    (string) $payment_date->format('Y-m-d')
                ], ';');
            }
        }

        rewind($csv);
        $csvContent = stream_get_contents($csv);
        fclose($csv);
        $response = new Response($csvContent);

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="compensation-overview.csv"');
        $response->headers->set('Content-Length', strlen($csvContent));
        $response->headers->set('Connection', 'close');

        return $response;
    }
}
