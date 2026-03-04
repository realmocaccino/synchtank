<?php

namespace App\Contract;

use App\Entity\Track;
use App\DTO\TrackRequestDTO;

interface TrackServiceInterface
{
    public function getAllTracks(): array;
    public function createTrack(TrackRequestDTO $data): Track;
    public function updateTrack(int $id, TrackRequestDTO $data): Track;
}