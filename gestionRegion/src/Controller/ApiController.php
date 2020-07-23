<?php

namespace App\Controller;

use App\Entity\Region;
use App\Repository\RegionRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/regions", name="api_add_region_api",methods={"GET"})
     */
    public function addRegionByApi(SerializerInterface $serializer)
    {
        $regionJson=file_get_contents("https://geo.api.gouv.fr/regions");
    //     //methode 1
    //     //Recuperation des Regions en Json
    //     $regionJson=file_get_contents("https://geo.api.gouv.fr/regions");
    //     //decode json vers tableau 
    //     $regionTab=$serializer->decode($regionJson,"json");
    //    //denormalisation tableau vers tableau d'ogjet
    //    $regionObject=$serializer->denormalize($regionTab, 'App\Entity\Region[]');
    //     dd($regionObject);
    
    
        //Methode 2: deserialisation de json ver tableau objet
        $entityManager = $this->getDoctrine()->getManager();
        
        $regionObject = $serializer->deserialize($regionJson, 'App\Entity\Region[]','json');
       
        foreach($regionObject as $region){
        $entityManager->persist($region);

    }
        $entityManager->flush();

     return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
}

        /**
             * @Route("/api/regions", name="api_show_region",methods={"GET"})
            */
            public function showRegion(SerializerInterface $serializer,RegionRepository $repo)
        {
            $regionsObject=$repo->findAll();
            $regionsJson =$serializer->serialize($regionsObject,"json",

            [
                "groups"=>["region::read_all"]
            ]
        );
            return new JsonResponse($regionsJson,Response::HTTP_OK,[],true);
            }

            /**
             * @Route("/api/regions", name="api_add_region",methods={"POST"})
            */
            public function addRegion(SerializerInterface $serializer,Request $request,ValidatorInterface $validator)
        {
            //recupérer le contenu du body de la requette
            $regionsJson=$request->getContent();
            $region = $serializer->deserialize($regionsJson, Region::class,'json');
            //validation
                $errors = $validator->validate($region);
                if (count($errors) > 0) {
                $errorsString =$serializer->serialize($errors,"json");
                 return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($region);
            $entityManager->flush();
            return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
            }
}

