<?php

namespace App\Controller;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BizController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/', name: 'app_bizz')]
    public function getData()
    {
        try {
            $response = $this->client->request('GET', 'https://test.wertkt.com/api/biz/');
            $statusCode = $response->getStatusCode();

            if ($statusCode === 200) {
                $content = $response->getContent();
                $data = json_decode($content, true);
                return $this->render('base.html.twig', [
                    'data' => $data
                ]);
            } else {
                print("Error");
                return null;
            }
        } catch (TransportExceptionInterface $e) {
            return $e;
        }
    }

    #[Route('/{id}', name: 'app_biz_details')]
    public function getResult($id)
    {
        try {
            $response1 = $this->client->request('GET', 'https://test.wertkt.com/api/biz/' . $id);
            $response2 = $this->client->request('GET', 'https://test.wertkt.com/api/result/');
            $statusCode1 = $response1->getStatusCode();
            $statusCode2 = $response2->getStatusCode();

            if ($statusCode1 === 200 and $statusCode2) {
                $content1 = $response1->getContent();
                $content2 = $response2->getContent();
                $data1 = json_decode($content1, true);
                $data2 = json_decode($content2, true);
                $resultsid = $data1['results'];

                return $this->render('recap.html.twig', [
                    'data1' => $data1,
                    'id' => $resultsid,
                    'data2' => $data2
                ]);
            } else {
                print("Error");
                return null;
            }
        } catch (TransportExceptionInterface $e) {
            return $e;
        }
    }

    
    #[Route('/biz/{id}', name: 'app_biz_detail')]
    public function getDetail($id)
    {
        try {
            $response = $this->client->request('GET', 'https://test.wertkt.com/api/biz/' . $id);
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

}