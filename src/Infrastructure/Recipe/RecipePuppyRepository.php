<?php

namespace App\Infrastructure\Recipe;


use App\Domain\Model\Recipe;
use App\Domain\Model\RecipeRepository;
use App\Domain\SearchCriteria;
use App\Infrastructure\Utils\QueryBuilderTrait;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerInterface as logger;
use Psr\Log\LogLevel;

class RecipePuppyRepository implements RecipeRepository
{
    use QueryBuilderTrait;

    const API_ENDPOINT = 'http://www.recipepuppy.com';

    /**
     * @var ClientInterface $client
     */
    private $client;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

        $stack = HandlerStack::create();
        $stack->push(Middleware::log($this->logger, new MessageFormatter(), LogLevel::INFO));
        $stack->push(Middleware::log($this->logger, new MessageFormatter("\n-----------------\nREQUEST: {request}\n\nRESPONSE:\n{response}\n-----------------\n"), LogLevel::DEBUG));

        $this->client = new Client([
            'base_uri' => self::API_ENDPOINT,
            'handler' => $stack
        ]);

    }

    public function findByText(SearchCriteria $searchCriteria)
    {
        $results = [];
        try {
            $response = $this->client->request('GET', $this->setParams($searchCriteria));

            $data = $response->getBody();

            $result = json_decode($data, true);
            $results = [];
            foreach ($result["results"] as $item) {
                array_push($results, new Recipe(
                    $item["title"],
                    $item["href"],
                    explode(",", $item["ingredients"]),
                    $item["thumbnail"]
                ));
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        } finally {
            return $results;
        }
    }

    /**
     * @param SearchCriteria $searchCriteria
     * @return string
     */
    public function setParams(SearchCriteria $searchCriteria)
    {
        $q = $searchCriteria->getText() ?? null;
        $i = ($searchCriteria->getIngredients()) ?  implode(',', $searchCriteria->getIngredients()) : null;
        $p = $searchCriteria->getPage() ?? null;

        return $this->appendQuery('/api', compact('q','p', 'i'));
    }

}