<?php

namespace App\Controller;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResultController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/result', name: 'app_result')]
    public function getData()
    {
        try {
            $response = $this->client->request('GET', 'https://test.wertkt.com/api/result/');
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getContent();
                $data = json_decode($content, true);
                return $this->json($data);
            } else {
                print("Error");
                return null;
            }
        } catch (TransportExceptionInterface $e) {
            return $e;
        }
    }

    #[Route('/result/{id}', name: 'app_result_detail')]
    public function getDetail($id)
    {
        try {
            $response = $this->client->request('GET', 'https://test.wertkt.com/api/result/' . $id);
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getContent();
                $data = json_decode($content, true);
                return $this->json($data[$id]);
            } else {
                print("Error");
                return null;
            }
        } catch (TransportExceptionInterface $e) {
            return $e;
        }
    }

}