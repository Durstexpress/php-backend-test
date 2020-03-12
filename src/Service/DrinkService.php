<?php


namespace App\Service;


use App\Entity\Drink;
use App\Exception\ExceptionHandler;
use App\Exception\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Exception;

class DrinkService implements DrinkServiceInterface
{

    /** @var EntityManagerInterface  */
    private $entityManager;

    /**
     * DrinkService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getAllDrinks(): array
    {
        try {
            return $this->getRepository()->findAll();
        } catch (Exception $exception) {
            throw ExceptionHandler::handleException(
                $exception,
                'Error getting all drinks.'
            );
        }
    }

    /**
     * @inheritDoc
     * @param int $drinkId
     * @return Drink
     * @throws Exception
     */
    public function getDrinkById(int $drinkId): Drink
    {
        try {
            /** @var Drink $drink */
            $drink = $this->getRepository()->find($drinkId);

            if($drink === null) {
                throw new NotFoundException(sprintf('Drink with ID "%s" was not found  ', $drinkId));
            }

            return $drink;
        } catch (Exception $exception) {
            throw ExceptionHandler::handleException(
                $exception,
                'Error getting drink by ID.'
            );
        }
    }

    /**
     * @inheritDoc
     * @param Drink $drink
     * @return Drink
     * @throws Exception
     */
    public function createDrink(Drink $drink): Drink
    {
        return $this->persist($drink);
    }

    /**
     * @inheritDoc
     * @param Drink $drink
     * @return Drink
     * @throws Exception
     */
    public function updateDrink(Drink $drink): Drink
    {
        $drinkId = $drink->getId();

        try {
            $this->persist($this->getDrinkById($drinkId));

            return $drink;
        } catch (Exception $exception) {
            throw ExceptionHandler::handleException(
                $exception,
                'Error updating drink.'
            );
        }
    }

    /**
     * @inheritDoc
     * @param int $drinkId
     * @throws Exception
     */
    public function deleteDrinkById(int $drinkId): void
    {
        try {
            $this->entityManager->remove($this->getDrinkById($drinkId));
            $this->entityManager->flush();
        } catch (Exception $exception) {
            throw ExceptionHandler::handleException(
                $exception,
                'Error deleting drink.'
            );
        }
    }

    /**
     * @param Drink $drink
     * @return Drink
     * @throws Exception
     */
    protected function persist(Drink $drink)
    {
        try {
            $this->entityManager->persist($drink);
            $this->entityManager->flush();

            return $drink;
        } catch (Exception $exception) {
            throw ExceptionHandler::handleException(
                $exception,
                'Error saving drink.'
            );
        }
    }

    /**
     * @return ObjectRepository
     */
    protected function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Drink::class);
    }
}
