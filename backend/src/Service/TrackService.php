<?php

namespace App\Service;

use App\Contract\TrackServiceInterface;
use App\Entity\Track;
use App\DTO\TrackRequestDTO;
use App\Exception\TrackNotFoundException;
use App\Exception\TrackValidationException;
use App\Repository\TrackRepository;
use DateTimeImmutable;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TrackService implements TrackServiceInterface
{
    public function __construct(
        private TrackRepository $trackRepository,
        private ValidatorInterface $validator
    ) {}
    
    public function getAllTracks(): array
    {
        return $this->trackRepository->findAll();
    }
    
    public function createTrack(TrackRequestDTO $data): Track
    {
        $track = new Track();

        $this->applyData($track, $data);
        $this->validateTrack($track);

        $this->trackRepository->save($track, flush: true);
        
        return $track;
    }
    
    public function updateTrack(int $id, TrackRequestDTO $data): Track
    {
        $track = $this->getTrackOrFail($id);

        $this->applyData($track, $data);
        $track->setUpdatedAt(new DateTimeImmutable());
        $this->validateTrack($track);

        $this->trackRepository->save($track, flush: true);
        
        return $track;
    }

    private function applyData(Track $track, TrackRequestDTO $data): void
    {
        if ($data->title !== null) {
            $track->setTitle($data->title);
        }
        if ($data->artist !== null) {
            $track->setArtist($data->artist);
        }
        if ($data->duration !== null) {
            $track->setDuration($data->duration);
        }
        if ($data->isrc !== null) {
            $track->setIsrc($data->isrc);
        }
    }

    private function getTrackOrFail(int $id): Track
    {
        $track = $this->trackRepository->find($id);

        if (! $track) {
            throw new TrackNotFoundException($id);
        }

        return $track;
    }

    private function validateTrack(Track $track): void
    {
        $errors = $this->validator->validate($track);

        if (count($errors) > 0) {
            throw new TrackValidationException($errors);
        }
    }
}