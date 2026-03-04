<?php

namespace App\Resource;

use App\Entity\Track;

class TrackResource
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $title,
        public readonly ?string $artist,
        public readonly ?int $duration,
        public readonly ?string $isrc,
        public readonly ?string $createdAt,
        public readonly ?string $updatedAt,
    ) {}

    public static function fromEntity(Track $track): self
    {
        return new self(
            $track->getId(),
            $track->getTitle(),
            $track->getArtist(),
            $track->getDuration(),
            $track->getIsrc(),
            $track->getCreatedAt()?->format('c'),
            $track->getUpdatedAt()?->format('c'),
        );
    }

    public static function fromEntities(array $tracks): array
    {
         return array_map(
            fn (Track $track) => self::fromEntity($track)->toArray(),
            $tracks
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist' => $this->artist,
            'duration' => $this->duration,
            'isrc' => $this->isrc,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}