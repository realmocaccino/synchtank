<?php

namespace App\Controller;

use App\Contract\TrackServiceInterface;
use App\DTO\TrackRequestDTO;
use App\Exception\TrackNotFoundException;
use App\Exception\TrackValidationException;
use App\Resource\TrackResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('/api/tracks')]
class TrackController extends AbstractController
{
    public function __construct(
        private TrackServiceInterface $trackService,
    ) {}
    
    #[Route('', name: 'tracks_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        try {
            return $this->json([
                'status' => 'success',
                'data' => TrackResource::fromEntities($this->trackService->getAllTracks())
            ], Response::HTTP_OK);
        } catch (Throwable $e) {
            return $this->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the tracks'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    #[Route('', name: 'tracks_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try {
            $data = TrackRequestDTO::fromRequest($request);
            $track = $this->trackService->createTrack($data);

            return $this->json([
                'status' => 'success',
                'message' => 'Track created successfully',
                'data' => TrackResource::fromEntity($track)->toArray()
            ], Response::HTTP_CREATED);
        } catch (TrackValidationException $e) {
            return $this->json([
                'status' => 'error',
                'errors' => $e->getErrors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $e) {
            return $this->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the track'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    #[Route('/{id}', name: 'tracks_update', methods: ['PUT'], requirements: ['id' => '\d+'])]
    public function update(int $id, Request $request): JsonResponse
    {
        try {
            $data = TrackRequestDTO::fromRequest($request);
            $track = $this->trackService->updateTrack($id, $data);

            return $this->json([
                'status' => 'success',
                'message' => 'Track updated successfully',
                'data' => TrackResource::fromEntity($track)->toArray()
            ], Response::HTTP_OK);
            
        } catch (TrackNotFoundException $e) {
            return $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        } catch (TrackValidationException $e) {
            return $this->json([
                'status' => 'error',
                'errors' => $e->getErrors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Throwable $e) {
            return $this->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the track'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}