<?php

namespace App\Infrastructure\Recipe;

use App\Domain\Model\RecipeRepository;
use App\Domain\RecipeSearchCriteria;
use App\Infrastructure\Utils\QueryBuilderTrait;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecipePuppyRepository implements RecipeRepository
{
    use QueryBuilderTrait;

    const API_ENDPOINT = 'http://www.recipepuppy.com';

    /**
     * @var ClientInterface $client
     */
    private $client;

    private $logger;

    /**
     * @var RecipePuppyParamsConverter
     */
    private $paramsConverter;

    /**
     * @var RecipePuppyResponseConverter
     */
    private $recipeConverter;

    public function __construct(LoggerInterface $logger, RecipePuppyParamsConverter $paramsConverter, RecipePuppyResponseConverter $recipeConverter)
    {
        $this->logger = $logger;
        $this->paramsConverter = $paramsConverter;
        $this->recipeConverter = $recipeConverter;

        $stack = HandlerStack::create();
        $stack->push(Middleware::log($this->logger, new MessageFormatter(), LogLevel::INFO));
        $stack->push(Middleware::log($this->logger, new MessageFormatter("\n-----------------\nREQUEST: {request}\n\nRESPONSE:\n{response}\n-----------------\n"), LogLevel::DEBUG));

        $this->client = new Client([
            'base_uri' => self::API_ENDPOINT,
            'handler' => $stack
        ]);
    }

    /**
     * @param RecipeSearchCriteria $searchCriteria
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search(RecipeSearchCriteria $searchCriteria)
    {
        $results = [];
        try {
            $response = $this->client->request('GET', $this->appendQuery('/api', $this->paramsConverter->transform($searchCriteria)));

            $data = $response->getBody();

            $result = json_decode($data, true);
            $results = [];

            foreach ($result["results"] as $item) {
                array_push($results, $this->recipeConverter->transform($item));
            }

        } catch (\Exception | NotFoundHttpException $e) {
            $this->logger->error($e->getMessage());
        } finally {
            return $results;
        }
    }
}